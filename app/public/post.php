<?php
// 投稿ページを作る
session_start();
require('html/header.html');
require('../mylib/function.php');
require('../mylib/header_nav.php');
$_SESSION['token'] = get_csrf_token();
isLoginUser();

if(empty($_SESSION['error'])) {
    $_SESSION['error'] = [];
}
if(empty($_SESSION['tmp'])) {
    $_SESSION['tmp'] = [];
}

// var_dump($_SESSION);
// echo basename($_SERVER["PHP_SELF"]);
$article_title = $_SESSION['tmp']['article_title'] ?? '';
$article_overview = $_SESSION['tmp']['article_overview'] ?? '';
$recluting_skill = $_SESSION['tmp']['recluting_skill'] ?? '';
$job_description = $_SESSION['tmp']['job_description'] ?? '';
$expiration_date = $_SESSION['tmp']['expiration_date'] ?? '';
$comment = $_SESSION['tmp']['comment'] ?? '';


$current_filename = basename($_SERVER["PHP_SELF"]);

$profile_image_url = $_SESSION['user']['profile_image_url'];
require_once('../mylib/p.php');



?>
