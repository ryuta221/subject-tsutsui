<?php

session_start();
header("Content-type: application/json; charset=UTF-8");
require_once("../mylib/function.php");

$postid = (string)filter_input(INPUT_POST, "postid");
$message = (string)filter_input(INPUT_POST, "message");

try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('INSERT INTO post_chat VALUES(:postid, :entry_userid, :message, :posted_userid)');
    $stmt->bindValue(':postid', $postid);
    $stmt->bindValue(':message', $message);
    $stmt->bindValue(':posted_userid', $_SESSION['user']['userid']);
    $stmt->bindValue(':entry_userid', $_SESSION['user']['userid']);
    $stmt->execute();

    echo json_encode(['status' => "success",'message' => $message]);
}catch(PDOException $e) {
    // var_dump($e);
    echo json_encode(['error' => $e]);

}
?>