<?php
// パスワードの変更を行う
session_start();
require_once('../mylib/function.php');
if(empty($_SESSION['user'])) {
    redirectToLogin();
    die(0);
}

$token = (string)filter_input(INPUT_POST, "token");
if($token != $_SESSION['token']) {
    exit(0);
}

$_SESSION['error'] = [];
$current_password = (string)filter_input(INPUT_POST, "current_password");
$new_password = (string)filter_input(INPUT_POST, "new_password");
$conform_new_password = (string)filter_input(INPUT_POST, "conform_new_password");

if($current_password == '') {
    $_SESSION['error']['require_password'] = '<span style="color: red;">パスワード入力してください</span>';
}
if($new_password != $conform_new_password) {
    $_SESSION['error']['not_match_password'] = '<span style="color: red;">パスワードが一致しません</span>';
}


if(count($_SESSION['error']) == 0) {
    try{
        // 現在のパスワード検証
        $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

        $stmt = $pdo->prepare('SELECT * FROM users WHERE userid = :userid');
        $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
        $stmt->execute();

        foreach($stmt as $row) {
            $db_password = $row['password'];
        }

        if(password_verify($current_password, $db_password)){
            try {
                // 更新処理
                $stmt = $pdo->prepare('UPDATE users SET password = :new_password WHERE userid = :userid');
                $stmt->bindValue(':new_password', password_hash($new_password, PASSWORD_DEFAULT), PDO::PARAM_STR);
                $stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
                $stmt->execute();

                redirectToProfile($_SESSION['user']['userid']);
                exit(0);

            }catch(PDOException $e) {
                $_SESSION['error']['somethingerror'] = "$e";
            }
        }else {
            // echo "***";
            $_SESSION['error']['worng_password'] = '<span style="color: red;">パスワードが間違っています</span>';
            redirectEditPassword();
            exit(0);
        }

    }catch(PDOException $e) {
        var_dump($e);
        $_SESSION['error']['somethingerror'] = "$e";


    }
}else {
    redirectEditPassword();
    exit(0);
}

?>