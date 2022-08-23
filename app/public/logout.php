<?php
session_start();
require_once("../mylib/function.php");
if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
}

$token = (string)filter_input(INPUT_POST, 'token');
// CSRF チェック
if ($token != $_SESSION['token']) {
    // リダイレクト
    redirectToHome();
    exit();
}

//セッション破棄
// セッションクッキーを削除
if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
}

session_destroy();
//リダイレクト
redirectToLogin();
?>