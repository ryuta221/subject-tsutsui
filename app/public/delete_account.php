<?php
// アカウントの削除
require_once('../mylib/function.php');
session_start();


if(empty($_SESSION['user'])){
    redirect_to_login();
    exit();
}

try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

    $pdo->beginTransaction();
    // TODO s3内のプロフィール画像削除    
    // bookmarkの削除を行う-->> 自分に関連する投稿のbookmarkを削除とboookmarkしているされている投稿を消す
    $stmt = $pdo->prepare('DELETE FROM bookmark WHERE userid = :userid OR bookmark_target_userid = :bookmark_target_userid');
    $stmt->bindValue('userid', $_SESSION['user']['userid']);
    $stmt->bindValue('bookmark_target_userid', $_SESSION['user']['userid']);
    $result = $stmt->execute();

    // 投稿削除
    $stmt = $pdo->prepare('DELETE FROM posts WHERE userid = :userid');
    $stmt->bindValue('userid', $_SESSION['user']['userid']);
    $result = $stmt->execute();

    // profile削除
    $stmt = $pdo->prepare('DELETE FROM users_profiles WHERE userid = :userid');
    $stmt->bindValue('userid', $_SESSION['user']['userid']);
    $result = $stmt->execute();

    // user情報削除
    
    $stmt = $pdo->prepare('DELETE FROM users WHERE userid = :userid');
    $stmt->bindValue('userid', $_SESSION['user']['userid']);

    $result = $stmt->execute();

    // 削除成功時
    if($result) {
        $pdo->commit();
    }

    // セッション削除
    $_SESSION = [];
    session_destroy();


    // リダイレクト
    redirectToLogin();
    exit(0);
}catch(PDOException $e){
    // TODO :errorページへリダイレクト
    $pdo->rollBack();
    // var_dump($e);
}catch (S3Exception $e) {
    // TODO :errorページへリダイレクト
    $pdo->rollBack();
    // var_dump($e);
    
}

?>



