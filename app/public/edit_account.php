<?php
// アカウントの変更処理
session_start();
require_once("../mylib/function.php");
$_SESSION['token'] = get_csrf_token();

// check_session.php
if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit(0);
}
if(empty($_SESSION['error'])) {
    $_SESSION['error'] = [];
}
require_once("html/header.html");
require_once('../mylib/header_nav.php');
try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM  users WHERE userid = :userid');
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);
    $stmt->execute();

    if($stmt->rowCount() == 0){
        redirectToNotFound();
        exit();
    }

    foreach($stmt as $row) {
        $email = $row['email'];
    }
}catch(PDOException $e) {
    // var_dump($e);
}
?>
<body>
<div class="container" >
    <div class="row"> 
        <?php
        require_once('html/edit_left.html');
        ?>
        <div class="card my-3 mx-1 mx-auto col-lg-9"> 
            <div class="card-header fs-2">アカウント編集</div>
            <form action="edit_email_check.php" method="post" id="post_form" >
                <div class="card-body" style="background-color: ;">
                    <div class="mx-3" style="background-color: azure;">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                            <div class="fs-5 px-1">メールアドレス</div>
                        </div>
                        <div><?= $_SESSION['error']['duplication_email'] ?? '' ?></div>
                        <input name="email" type="mail" value="<?= h($email); ?>">
                        <button type="submit" class="btn btn-primary">
                            更新
                        </button>
                    </div>
                    <div class="mx-3 my-3" style="background-color: azure;">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                            <div class="ps-1 fs-5">アカウント削除</div>
                        </div>
                        <button type="submit" formaction="delete_account.php" onclick="return delete_account()" class="btn  btn-danger px-3">削除</button>
                        <script>
                            function delete_account() {
                                if (window.confirm('アカウント消す？？')) {
                                    return true;
                                }else return false;
                            }
                        </script>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
            </form>
        </div>
    </div>
</div>
<?php
$_SESSION['error'] = [];
require_once("html/footer.html");
?>