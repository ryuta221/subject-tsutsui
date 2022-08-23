<?php
// emailの変更処理
session_start();
require_once("../mylib/function.php");


$token = (string)filter_input(INPUT_POST, "token");
if($token != $_SESSION['token']) {
    exit(0);
}

$new_email = (string)filter_input(INPUT_POST, "email");
$_SESSION['error'] = [];

try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM  users WHERE userid = :userid');
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);
    $stmt->execute();

    foreach($stmt as $row) {
        $current_email = $row['email'];
    }

    if($current_email == $new_email) {
        $_SESSION['error']['duplication_email'] = '<span style="color: red;">重複してる!!</span>';
    }

}catch(PDOException $e) {
    var_dump($e);
}

if(count($_SESSION['error']) == 0) {
    try{
        $stmt = $pdo->prepare('UPDATE users SET email = :email WHERE userid = :userid');
        $stmt->bindValue(':email', $new_email);
        $stmt->bindValue(':userid', $_SESSION['user']['userid']);
        $stmt->execute();

        redirectEditAccount();
        exit(0);

    }catch(PDOException $e) {
        var_dump($e);
    }
}else {
    redirectEditAccount();
    exit(0);
}

?>