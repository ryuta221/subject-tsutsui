<?php
session_start();
require_once("../mylib/function.php");
if(empty($_SESSION['user'])){
    redirectToLogin();
    exit();
}

$_SESSION['error'] = [];
$_SESSION['tmp']   = []; // リダイレクトに伴う情報の引き継ぎ時に使用

$post_status      = filter_input(INPUT_POST,'post_status');
$current_filename = (string)filter_input(INPUT_POST,'current_filename');

if($current_filename == 'edit_post.php') {
    $postid = (string)filter_input(INPUT_POST,'postid');
}


$token = (string)filter_input(INPUT_POST,'token');

$_SESSION['tmp']['article_title']    = (string)filter_input(INPUT_POST,'article_title');
$_SESSION['tmp']['article_overview'] = (string)filter_input(INPUT_POST,'article_overview');
$_SESSION['tmp']['recluting_skill']  = (string)filter_input(INPUT_POST,'recluting_skill');
$_SESSION['tmp']['job_description']  = (string)filter_input(INPUT_POST,'job_description');
$_SESSION['tmp']['expiration_date']  = (string)filter_input(INPUT_POST,'expiration_date');
$_SESSION['tmp']['comment']          = (string)filter_input(INPUT_POST,'comment');




// CSRF対策
if($token != $_SESSION['token']){
    $_SESSION['error']['bad_request'] = '<span style="color: red;">不正なリクエスト</span>';
}

// 投稿時にバリデーションを行う
if($post_status == 1) {
    if($_SESSION['tmp']['article_title'] == '') {
        $_SESSION['error']['require_title'] = '<span style="color: red;">*必須</span>';
    }
    if(strlen($article_title) > 100) {
        $_SESSION['error']['toolong_article_title'] = '<span style="color: red;">*文字数オーバー</span>';
    }
    if($_SESSION['tmp']['article_overview'] == '') {
        $_SESSION['error']['require_article_overview'] = '<span style="color: red;">*必須</span>';
    }

    // deadline
    if($_SESSION['tmp']['expiration_date'] == '') {
        $_SESSION['error']['expiration_date'] = '<span style="color: red;">*有効な時間を指定してください</span>';
    }

    if($_SESSION['tmp']['recluting_skill'] == '') {
        $_SESSION['error']['require_recluting_skill'] = '<span style="color: red;">*必須</span>';
    }
    if($_SESSION['tmp']['job_description'] == '') {
        $_SESSION['error']['job_description'] = '<span style="color: red;">*必須</span>';
    }
    
}else {
    // 下書きの時は現在の日付を指定
    $now_datetime = new DateTime('now');
    $_SESSION['tmp']['expiration_date'] = $now_datetime->format('Y-m-d');
}


if(count($_SESSION['error']) === 0){
    try{

        $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

        if($current_filename == 'edit_post.php') {
            // 投稿の更新を行う
            $stmt = $pdo->prepare("UPDATE posts SET userid = :userid, 
                article_title    = :article_title,
                article_overview = :article_overview, 
                
                recluting_skill  = :recluting_skill, 
                job_description  = :job_description, 
                expiration_date  = :expiration_date, 
                
                comment          = :comment,
                post_status      = :post_status 
                WHERE postid     = :postid");

            $stmt->bindValue('userid', $_SESSION['user']['userid']);
            $stmt->bindValue('article_title', $_SESSION['tmp']['article_title']);
            $stmt->bindValue('article_overview', $_SESSION['tmp']['article_overview']);


            $stmt->bindValue('recluting_skill', $_SESSION['tmp']['recluting_skill']);
            $stmt->bindValue('job_description', $_SESSION['tmp']['job_description']);
            $stmt->bindValue('expiration_date', $_SESSION['tmp']['expiration_date']);
            
            $stmt->bindValue('comment', $_SESSION['tmp']['comment']);
            $stmt->bindValue('post_status', $post_status);
            $stmt->bindValue('postid', (string)filter_input(INPUT_POST,'postid'));
        }else if($current_filename == 'post.php'){
            // 新規投稿処理
            if($_SESSION['tmp']['comment'] == '') {
                $_SESSION['tmp']['comment'] = '参加待ってます';
            }

            // 投稿Idの生成
            $postid = uniqid();
            $stmt = $pdo->prepare("INSERT INTO posts VALUES(:postid, :userid, :article_title, :article_overview, :recluting_skill, :job_description,:expiration_date, :comment, default, default, :post_status)");

            $stmt->bindValue('postid', $postid);
            $stmt->bindValue('userid', $_SESSION['user']['userid']);
            $stmt->bindValue('article_title', $_SESSION['tmp']['article_title']);
            $stmt->bindValue('article_overview', $_SESSION['tmp']['article_overview']);
            $stmt->bindValue('recluting_skill', $_SESSION['tmp']['recluting_skill']);
            
            $stmt->bindValue('job_description', $_SESSION['tmp']['job_description']);
            $stmt->bindValue('expiration_date', $_SESSION['tmp']['expiration_date']);
            $stmt->bindValue('comment', $_SESSION['tmp']['comment']);
            $stmt->bindValue('post_status', $post_status);

        }else {
            // hidden値が変更されたNotFoundへ
            unset($_SESSION['tmp']);
            unset($_SESSION['error']);
            redirectToNotFound();
        }
        

        $stmt->execute();

        unset($_SESSION['tmp']);
        unset($_SESSION['error']);

        if($post_status == 0) redirectToProfile($_SESSION['user']['userid']); // 下書きした
        else redirectToHome(); // 更新して投稿した
        
        
        
    }catch(PDOException $e) {
        // echo "a".$expiration_date."a";
        // var_dump($e);
    }
}else {
    // 遷移元に応じたリダイレクト処理
    if($current_filename == 'edit_post.php') {
        redirectToEditPost($postid);
    }else if($current_filename == 'post.php') {
        redirect_to_post();
    }
}
?>