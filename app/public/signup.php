<?php
session_start();
require_once('../mylib/function.php');
// 既にログイン中の時
if(isset($_SESSION['user'])) {
  redirectToHome();
  exit();
}

$_SESSION['token'] = get_csrf_token(); // CSRFのトークンの生成

// 初回
if(empty($_SESSION['error'])){
  $_SESSION['error'] = [];
}
if(empty($_SESSION['tmp'])){
  $_SESSION['tmp'] = [];
}

$username = $_SESSION['tmp']['username'] ?? '';
$email = $_SESSION['tmp']['email'] ?? '';
require_once('html/header.html');
?>
<body style="background-color: gray">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto " style="margin-top:50px">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
          <!-- Background image for card set in CSS! -->
          <!-- <div class="card-img-left d-none d-md-flex" style="background-image: url('https://media.istockphoto.com/vectors/welcome-inscription-hand-drawn-lettering-greeting-card-with-design-vector-id816807384?k=20&m=816807384&s=612x612&w=0&h=QRjPUJ-vhr50lkeJx5j1QKY1n3lakksxrodVf1rEZ4I=');"> </div> -->
          <div class="card-body p-sm-5">
            <div class="text-center">開発メンバー募集サイト</div>
            <h5 class="card-title text-center mb-5 fw-light fs-4">Register</h5>
            <form method="post" action="signup_check.php">
              <div class="form-floating mb-3">
                <input name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="myusername" autofocus value="<?= h($username); ?>" maxlength="100" required >
                <label for="floatingInputUsername">Username</label>
              </div>
            

              <span><?=isset($_SESSION['error']['duplicate_email']) ? $_SESSION['error']['duplicate_email'] : ''?></span>
              <span><?=isset($_SESSION['error']['require_email']) ? $_SESSION['error']['require_email'] : ''?></span>
              <div class="form-floating mb-3">
                <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="name@example.com" value="<?= h($email); ?>" required>
                <label for="floatingInputEmail">Email address</label>
              </div>
              
              <hr>

              <div><?=isset($_SESSION['error']['require_password']) ? $_SESSION['error']['require_password'] : ''?></div>
              <div><?=isset($_SESSION['error']['not_match_password']) ? $_SESSION['error']['not_match_password'] : ''?></div>
              <div class="form-floating mb-3">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
              </div>

              <div class="form-floating mb-2">
                <input name="confirm_password" type="password" class="form-control" id="floatingPasswordConfirm" placeholder="Confirm Password" required>
                <label for="floatingPasswordConfirm">Confirm Password</label>
              </div>

              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit" style="font-size: 0.9rem;letter-spacing: 0.05rem;padding: 0.75rem 1rem;">Register</button>
              </div>

              <!-- Have an account? Sign In -->
              <a class="d-block text-center mt-2 small" href="login.php">既にアカウントを持っている時</a>
              
              <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

$_SESSION['tmp'] = [];
$_SESSION['error'] = []; // 初期化

?>
</body>
</html>