<?php
session_start();
require_once('../mylib/function.php');
// var_dump($_SESSION);

// 既にログインしている
if(isset($_SESSION['user'])) {
    redirectToHome();
    exit();
}

$_SESSION['token'] = get_csrf_token();
// errorの初期化
if(empty($_SESSION['error'])){
    $_SESSION['error'] = [];
}

$email = $_SESSION['tmp']['email'] ?? '';
// var_dump($_SESSION);
require_once('html/header.html');
?>
    <body style="">
        <div class="container" >
            <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto "  style="margin-top:50px">
                <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                <!-- <div class="card-img-left d-none d-md-flex">
                    Background image for card set in CSS! 
                </div> -->
                <div class="card-body">
                    <div class="text-center">開発メンバー募集サイト</div>
                    <h3 class="card-title text-center mb-5 fw-light fs-3" style="">Login</h3>
                    <?= isset($_SESSION['error']['notFound']) ? $_SESSION['error']['notFound'] : ''?>
                    <form method="post" action="login_check.php">
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="myusername" required autofocus value="<?= h($email); ?>">
                            <label for="floatingInputUsername">Email</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input name="password"type="password" class="form-control" id="floatingInputPassword" placeholder="myusername" required autofocus>
                            <label for="floatingInputUsername">Password</label>
                            <!-- <a class="d-block text-end virtucal-middel small">
                                forget password??
                            </a> -->
                        </div>
                        <div class="d-grid mb-2">
                            <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit" style="font-size: 0.9rem;letter-spacing: 0.05rem;padding: 0.75rem 1rem;">Login</button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a class="d-block text-center mt-2 small" href="signup.php">アカウント持ってない時</a>
                        </div>
                        <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        <?php
        $_SESSION['error'] = [];
        $_SESSION['tmp'] = [];
        ?>
  </body>
</html>