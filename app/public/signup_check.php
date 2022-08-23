<?php
session_start();
require_once('../mylib/function.php');

// 直接アクセスされたとき
if(empty($_SESSION)) {
    redirectToSignup();
    exit(0);
}

if(empty($_SESSION['error'])) {
    $_SESSION['error'] = [];
}
if(empty($_SESSION['tmp'])) {
    $_SESSION['tmp'] = [];
}

$_SESSION['error'] = []; // 初期化
$_SESSION['tmp']['username'] = (string)filter_input(INPUT_POST,'username');
$_SESSION['tmp']['email']    = (string)filter_input(INPUT_POST,'email');

if($_SESSION['tmp']['username'] == '') {
    $_SESSION['error']['require_username'] = 'ユーザー名を入力してください';
}

// バックでのエラーデータは、フロント側でエラーチェックを抜けてきたため改竄されている可能性が高いので、バックでの入力エラーは、エラーログに追記した後_session変数いって再度signページへ（データ引き継がない）
$username         = (string)filter_input(INPUT_POST,'username');
$email            = (string)filter_input(INPUT_POST,'email');
$password         = (string)filter_input(INPUT_POST,'password');
$confirm_password = (string)filter_input(INPUT_POST,'confirm_password');

$token            = (string)filter_input(INPUT_POST,'token');


// SCRF対策
if($token != $_SESSION['token']){
    // 不正なリクエスト
    $_SESSION['error']['bad_request'] = '<span style="color:red;padding-bottom:3px">bad request</span>';
}

/* TODO 各種バリデーション */
// id重複
// メアド重複
// パスワード不一致
// 使えない文字使ってないか文字

if($password != $confirm_password){
    $_SESSION['error']['not_match_password'] = '<span style="color:red;padding-bottom:3px"> パスワードが一致しません</span>';
}
if($password == '' || $confirm_password == ''){
    $_SESSION['error']['require_password'] = '<span style="color:red;padding-bottom:3px"> パスワードを入力してください</span>';
}
if($email == ''){
    $_SESSION['error']['require_email'] = '<span style="color:red;padding-bottom:3px"> 正しいメールアドレスを入力してください</span>';
}

try{
    // 重複するメールアドレスないか
    $pdo = new PDO(DSN,USER_NAME,PASSWD,get_pdo_options());
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
}catch(PDOException $e) {
}

if($stmt->rowCount() >= 1) {
    $_SESSION['error']['duplicate_email'] = '<span style="color:red;padding-bottom:3px"> このメールアドレスは既に使われています</span>';
}
$debug = 0;
if(count($_SESSION['error']) === 0 && $debug == 0) {
    $userid = uniqid();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $autobiography = "よろしくお願いします!";

    try {
        // userの登録処理
        $pdo = new PDO(DSN,USER_NAME,PASSWD,get_pdo_options());
        $pdo->beginTransaction();
        $sql = "INSERT INTO users (userid, email, password) VALUES (:userid,:email,:password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->execute();

        // userのプロフィール情報の初期化
        $sql = "INSERT INTO users_profiles (userid,username,profile_image_url,autobiography) VALUES (:userid,:username,:profile_image_url,:autobiography)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':profile_image_url', '', PDO::PARAM_STR);
        $stmt->bindValue(':autobiography', $autobiography, PDO::PARAM_STR);



        $result = $stmt->execute();

        if($result) {
            $pdo->commit();
        }
        unset($_SESSION['tmp']);
        unset($_SESSION['error']);


    }catch(PDOException $e) {
        $pdo->rollBack();
        redirectToSignup();
        exit();
    }
    redirectToHome();
}else {
    redirectToSignup();
    exit(0);
}
?>