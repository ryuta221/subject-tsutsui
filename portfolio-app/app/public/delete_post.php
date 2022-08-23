<?php
// 投稿の削除
session_start();
require('../mylib/function.php');

if(empty($_SESSION['user'])){
    redirect_to_login();
    exit();
}

$postid = (string)filter_input(INPUT_POST, 'postid');

$sql = "DELETE FROM posts WHERE userid = :userid AND postid = :postid";

// echo $postid;
try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('userid', $_SESSION['user']['userid']);
    $stmt->bindValue('postid', $postid);
    $stmt->execute();

    // 呼び出し元でリダイレクト？
    // echo json_encode(['status' => 'success']);

    redirectToProfile($_SESSION['user']['userid']);
    // exit();

}catch(PDOException $e){

}
?>