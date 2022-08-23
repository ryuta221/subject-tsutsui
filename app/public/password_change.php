<?php
// パスワードの変更処理を行う
session_start();
require_once('../mylib/function.php');

if(empty($_SESSION['user'])){
    redirectToLogin();
    die();
}

$current_password = (string)filter_input(INPUT_POST, "current_password");
$new_password = (string)filter_input(INPUT_POST, "new_password");


try{
    // 現在のパスワード検証
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

    $stmt = $pdo->prepare('SELECT * FROM users WHERE userid = :userid');
    $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $stmt->execute();

    var_dump($stmt);

}catch(PDOException $e) {
    var_dump($e);
}

?>