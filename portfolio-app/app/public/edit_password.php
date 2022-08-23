<?php

session_start();

require_once("../mylib/function.php");
require_once("html/header.html");
$_SESSION['token'] = get_csrf_token();
require_once('../mylib/header_nav.php');
// セッションない
if(empty($_SESSION['user'])) {
    exit(0);
}

if(empty($_SESSION['error'])) {
    $_SESSION['error'] = [];
}

// var_dump($_SESSION);
try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM  users WHERE userid = :userid');
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);
    $stmt->execute();

    if($stmt->rowCount() == 0){
        //404error
        echo 'Oops..!!';
        exit();
    }
}catch(PDOException $e) {
    var_dump($e);
}
?>
<body style="height:100%;display: flex;
	flex-direction: column;background-color: #EEEEEE;
	min-height: 100vh;">
<div class="container" >
    <div class="row">            
        <!-- まとめる -->
        <?php
        require_once('html/edit_left.html');
        ?>
        
        <div class="card my-3 mx-1 col-lg-9 mx-auto" > 
            <div class="card-header fs-2">パスワード設定</div>
            <form action="edit_password_check.php" method="post" id="post_form" >
                <div class="row">
                    <div class="col-lg-8 card-body">
                        <?=$_SESSION['error']['require_password'] ?? '' ?>
                        <?=$_SESSION['error']['worng_password'] ?? ''?>
                        <div class="my-3 mx-1" style="background-color: azure;">
                            <h4>現在のパスワード</h4>
                            <input name="current_password" type="password">
                        </div>
                        <hr>


                        <?=$_SESSION['error']['not_match_password'] ?? ''?>
                        <div class="my-3 mx-1" style="background-color: azure;">
                            <h4>新規パスワード</h4>
                            <input name="new_password" type="password">
                        </div>

                        
                        <div class="my-3 mx-1" style="background-color: azure;">
                            <h4>新規パスワード確認</h4>
                            <input name="conform_new_password" type="password">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                更新
                            </button>
                        </div>
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