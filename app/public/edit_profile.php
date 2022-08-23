<?php
session_start();
require_once("../mylib/function.php");

// セッション確認
if(empty($_SESSION['user'])) {
    redirectToLogin();
}

require_once("html/header.html");
$_SESSION['token'] = get_csrf_token();

require_once('../mylib/header_nav.php');

try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM  users_profiles WHERE userid = :userid');
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);
    $stmt->execute();
}catch(PDOException $e) {
    var_dump($e);
}
if($stmt->rowCount() == 0){
    redirectToNotFound();
}

foreach($stmt as $row) {
    $username          = $row['username'];
    $autobiography     = $row['autobiography'];
    $profile_image_url = $row['profile_image_url'];
    $twitter_url       = $row['twitter_url'];
    $github_url        = $row['github_url'];
    $display_email     = $row['display_email'];
}
?>
<body>
<div class="container" >
    <div class="row"> 

        <?php
        require_once('html/edit_left.html');
        ?>

        <div class="card my-3 mx-1 mx-auto col-lg-9" > 
            
            <div class="card-header fs-2">プロフィール編集</div>
            <form action="edit_profile_check.php" method="post" id="post_form" >
                <div class="row">
                    <div class="col-lg-3 text-align-center" style="/*background-color: aquamarine;*/text-align:center;">
                        <div class="my-3 d-flex align-items-center justify-content-center ">
                            <!-- ユーザーアイコン -->
                        <img id="view" style="border-radius: 50%;" src="<?= h(isProfileImageExist($profile_image_url)); ?>" width="180" height="180" size="30" loading="lazy">
                        </div>
                        <label class="align-items-center justify-content-center" >
                            <div class="btn btn-primary">
                                Choose File
                                <input type="file" onchange="profileImageUpload(this)" style="display: none;">
                            </div>
                        </label>
                        <script src="js/profile_image_upload.js"></script>
                    </div>
                    <div class="col-lg-8" style="background-color: azure;/*background-color: red;*/">
                        <div class="my-3 mx-1" style="/*background-color: azure;*/">
                            <h3>ユーザー名</h3>
                            <input name="username" type="text" style="padding: 0 7px;" value="<?= h($username); ?>">
                        </div>
                        <div class="my-3 mx-1" style="/*background-color: azure;*/">
                            <h3>自己紹介</h3>
                            <script src="js/count_button.js"></script>
                            <textarea id="autobiography" name="autobiography" rows="5" cols="40" style="width: 100%; padding: 7px 7px" maxlength="300"><?= h($autobiography) ?></textarea>
                            <div id="autobiography_length" style="text-align:right;color: #999;">3/300</div>
                            <script>
                                const autobiography = document.getElementById('autobiography');
                                const autobiography_length = document.getElementById('autobiography_length');
                                function count_autobiography_length() {
                                    autobiography_length.textContent = countGrapheme(autobiography.value) + '/300';
                                }
                                window.onload = () => {
                                    count_autobiography_length();
                                    // 属性の登録
                                    autobiography.addEventListener('input', count_autobiography_length, false);
                                }
                            </script>
                        </div>
                        <div class="my-3 mx-1" style="/*background-color: azure;*/">
                            <h3>リンク</h3>
                            
                            <div class="d-flex align-items-center py-1 ms-1">
                                <i class="fab fa-twitter me-2"></i>
                                <input name="twitter_url" type="url" style="width: 90%;" value="<?= h($twitter_url) ?>">
                            </div>
                            <div class="d-flex align-items-center py-1 ms-1">
                                <i class="fab fa-github me-2"></i>
                                <input name="github_url" type="url" style="width: 90%;" value="<?= h($github_url) ?>">
                            </div>
                            <div class="d-flex align-items-center py-1 ms-1">
                                <i class="fa fa-envelope me-2" aria-hidden="true"></i>
                                <input name="display_email" type="email" style="width: 90%;" value="<?= h($display_email) ?>">
                            </div>
                            
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
require_once("html/footer.html");
?>