<?php
// 投稿の編集処理
session_start();
require_once("../mylib/function.php");

$_SESSION['token'] = get_csrf_token();

if(empty($_SESSION)) {
    redirectToLogin();
    exit();
}
$postid = (string)filter_input(INPUT_GET, 'postid');

if($postid == '') {
    redirectToNotFound();
}

if(empty($_SESSION['error'])) {
    $_SESSION['error'] = [];
}
if(empty($_SESSION['tmp'])) {
    $_SESSION['tmp'] = [];
}


if(count($_SESSION['tmp']) == 0) {
    try{
        $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
        $stmt = $pdo->prepare('SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE users_profiles.userid = :userid AND posts.postid = :postid');
        $stmt->bindValue(':userid', $_SESSION['user']['userid']);
        $stmt->bindValue(':postid', $postid);
        $stmt->execute();
        // 指定IDの投稿がない時x
        if($stmt->rowCount() == 0){
            redirectToNotFound();
        }

        foreach($stmt as $row) {
            // $username          = $row['username'];
            // $autobiography     = $row['autobiography'];
            $profile_image_url = $row['profile_image_url'];

            $article_title = $row['article_title'];
            $article_overview = $row['article_overview'];
            $recluting_skill = $row['recluting_skill'];
            $job_description = $row['job_description'];
            $expiration_date = $row['expiration_date'];
            $comment = $row['comment'];

        }
    }catch(PDOException $e) {
        var_dump($e);
    }
}else {
    $article_title = $_SESSION['tmp']['article_title'] ?? '';
    $article_overview = $_SESSION['tmp']['article_overview'] ?? '';
    $recluting_skill = $_SESSION['tmp']['recluting_skill'] ?? '';
    $job_description = $_SESSION['tmp']['job_description'] ?? '';
    $expiration_date = $_SESSION['tmp']['expiration_date'] ?? '';
    $comment = $_SESSION['tmp']['comment'] ?? '';
}
require_once("html/header.html");
require_once('../mylib/header_nav.php');

// TODO : pagepage名を取得
$current_filename = basename($_SERVER["PHP_SELF"]);

require_once('../mylib/p.php');
require_once("html/footer.html");
?>
