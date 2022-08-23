<?php
// profileの変更処理を行う
session_start();
require_once("../mylib/function.php");
// ログイン済みでない時
if(empty($_SESSION['user'])) {
    exit(0);
}

$username = (string)filter_input(INPUT_POST,'username');
$autobiography = (string)filter_input(INPUT_POST,'autobiography');

$twitter_url = (string)filter_input(INPUT_POST,'twitter_url');
$github_url = (string)filter_input(INPUT_POST,'github_url');
$display_email  = (string)filter_input(INPUT_POST,'display_email');

// TODO $display_email = (string)filter_input(INPUT_POST,'display_email');
// email重複チェックとログイン用のじゃないかチェック


$token = (string)filter_input(INPUT_POST,'token');
if($token != $_SESSION['token']){
    exit(0);
}


try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('UPDATE users_profiles SET username = :username, autobiography = :autobiography, twitter_url = :twitter_url, github_url = :github_url,display_email = :display_email WHERE userid = :userid');
    $stmt->bindValue(':username',  $username);
    $stmt->bindValue(':autobiography',  $autobiography);
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);

    $stmt->bindValue(':twitter_url',  $twitter_url);
    $stmt->bindValue(':github_url', $github_url);
    $stmt->bindValue(':display_email', $display_email);
    
    $stmt->execute();
    redirectToProfile($_SESSION['user']['userid']);
    exit(0);
}catch(PDOException $e) {
    // var_dump($e);
}
?>