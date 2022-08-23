<?php
// entryへの登録処理を行う
session_start();
require_once('../mylib/function.php');
if(empty($_SESSION['user'])){
    redirectToLogin();
    exit();
}
$postid = (string) filter_input(INPUT_POST, "postid");
try{
    // 登録　
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());
    $pdo->beginTransaction();

    $roomid = uniqid();


    // entryテーブルへ保存
    // 自分のID
    // エントリーするpostId
    $stmt = $pdo->prepare('INSERT INTO posts_entrys VALUES(:postid, :userid, :roomid)');
    // entryする投稿Id
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    // 自分
    $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    // この投稿書とのroomid
    $stmt->bindValue(':roomid', $roomid, PDO::PARAM_STR);
    $result = $stmt->execute();

    if($result) {
        $pdo->commit();
    }
    redirectToHome();
    exit();

}catch(Exception $e) {
    $pdo->rollBack();
    // redirectToHome();
}


?>