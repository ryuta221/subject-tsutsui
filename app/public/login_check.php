<?php
session_start();
require_once("../mylib/function.php");

// ログイン済みかどうか
if(isset($_SESSION['user'])) {
    redirectToHome();
    exit();
}

// 初期化
if(empty($_SESSION['error'])){
    $_SESSION['error'] = []; 
}
if(empty($_SESSION['tmp'])){
    $_SESSION['tmp'] = []; 
}

$_SESSION['tmp']['email']    = (string)filter_input(INPUT_POST,'email');
$password                    = (string)filter_input(INPUT_POST,'password');
$token                       = (string)filter_input(INPUT_POST,'token');


/* 各種バリデーション */

if($token != $_SESSION['token']) {
    $_SESSION['error']['bad_request'] = '<span style="color:red;padding-bottom:3px">bad request</span>';
}

if($_SESSION['tmp']['email'] == '' || $password == '') {
    $_SESSION['error']['empty_password'] = '<span style="color:red;padding-bottom:3px">未入力があります</span>';
}


if(count($_SESSION['error']) == 0) {
    // DBへの登録処理
    try {
        $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $_SESSION['tmp']['email'], PDO::PARAM_STR);
        $result = $stmt->execute();

        // ユーザー見つからない
        if($stmt->rowCount() ==  0){
            $_SESSION['error']['notFound'] = '<span style="color:red;padding-bottom:3px">ユーザー名かパスワードが違います</span>';
            redirectToLogin();
            exit();
        }
        
        foreach($stmt as $row){
            $userid = $row['userid'];
            $email = $row['email'];
            $db_password = $row['password'];
        }
        // パスワード検証
        if(password_verify($password, $db_password)){
            // ログイン成功
            // セッション ID の振り直し
            session_regenerate_id(true);            
            

            // mailaddressに対応するプロフィール情報の取得
            $sql = "SELECT * FROM users_profiles WHERE userid = :userid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();

            // 初回
            if(empty($_SESSION['user'])) $_SESSION['user'] = [];
            
        
            // user情報をセッションにほじ
            $_SESSION['user']['email'] = $email;
            
            // session変数の容量なぞ
            foreach($stmt as $row){
                $_SESSION['user']['userid']            = $row['userid'];
                $_SESSION['user']['username']          = $row['username'];
                $_SESSION['user']['autobiography']     = $row['autobiography'];
                $_SESSION['user']['profile_image_url'] = $row['profile_image_url'];
            }
            unset($_SESSION['token']);
            unset($_SESSION['error']);
            redirectToHome();
            exit();
        }else{
            // echo 'fail....';
            // ログイン失敗
            $_SESSION['error']['notFound'] = '<span class="pb-1" style="color:red;padding-bottom:3px">ユーザー名かパスワードが違います</span>';
            redirectToLogin();
            exit();
        }

    }catch(PDOException $e) {
        $pdo->rollBack();
        RedirectToLogin();
        exit(0);
    }
}else {
    // errorファイルへ
    RedirectToLogin();
    exit(0);
}
?>