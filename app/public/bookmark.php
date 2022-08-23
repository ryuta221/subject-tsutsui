<?php
// bookmarkの登録、削除処理を行う
session_start();
require_once('../mylib/function.php');
if(empty($_SESSION['user'])){
    redirectToLogin();
    exit();
}
// json形式で返す
header("Content-Type: application/json; charset=UTF-8");
// 投稿Id
$postid = (string) filter_input(INPUT_POST, "postId");
// 投稿者のId
$userid = (string) filter_input(INPUT_POST, "userId");  

try{
    // 登録　
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

    // id チェック
    $stmt = $pdo->prepare('SELECT * FROM bookmark  WHERE postid = :postid AND userid = :userid AND bookmark_target_userid = :bookmark_target_userid');
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    $stmt->bindValue(':bookmark_target_userid', $userid, PDO::PARAM_STR); //投稿者のId
    $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);// 自分のuserId
    $stmt->execute();
}catch(PDOException $e) {
    echo json_encode(['status' => 'error'. $e]);
}
    
if($stmt->rowCount() == 0) {
    $stmt = $pdo->prepare('INSERT INTO bookmark VALUES(:userid, :postid, :bookmark_target_userid)');
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    $stmt->bindValue(':bookmark_target_userid', $userid, PDO::PARAM_STR);
    $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(['status' => 'bookmarked']);
}else {
    $stmt = $pdo->prepare('DELETE FROM bookmark WHERE postid = :postid AND userid = :userid AND bookmark_target_userid = :bookmark_target_userid');
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    $stmt->bindValue(':bookmark_target_userid', $userid, PDO::PARAM_STR); //投稿者
    $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $stmt->execute();

    echo json_encode(['status' => 'unbookmark']);
}

?>