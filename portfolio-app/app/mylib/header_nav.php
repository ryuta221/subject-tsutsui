<?php
// header部
require_once('../public/html/header.html');
require_once('function.php');
if(empty($_SESSION['user'])) {
    ridirectToNotFound();
}
?>
<header class="navbar navbar-expand-lg navbar-dark " style="background-color:green">
    <div class="container">
        <!-- 左上アイコン -->
        <a class="navbar-brand d-none d-md-block" href="home.php"  style="white-space: nowrap;">開発メンバー募集サイト</a>
        <a class="navbar-brand d-block d-md-none" href="home.php"  style="white-space: nowrap;">アイコン</a>
        <!-- 右の色はbg-light で決まる -->
        <div class="d-flex  align-items-center ">
            <!-- 検索アイコン単体  -->
            <div class="d-block d-md-none">
                <a href="search.php">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </a>
            </div>
            <!-- 検索窓とアイコン mdの時表示 -->
            <div class="d-none d-md-block mx-2">
                <form class=" " action="search.php" method="get" style="margin : 0 auto">
                    <input type="text" name="q"  placeholder="input">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div> 
            <!-- header部 -->
            <div class="d-flex ">
                <!-- 投稿ボタン -->
                <a href="post.php">
                    <button class="btn btn-secondary">投稿する</button>
                </a>
                <!-- dropdownのボタン -->
                <div class="dropdown" >
                    <a class="dropdown-toggle text-decoration-none link-pink" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img id="header_nav_profile_img" src="<?= h(isProfileImageExist($_SESSION['user']['profile_image_url'])); ?>" width="40" height="40" class="rounded-circle">
                    </a>
                    <!-- dropdownのメニュー -->
                    <ul class="dropdown-menu" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 40px, 0px);" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="profile.php?userid=<?= h($_SESSION['user']['userid']); ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="edit_account.php">Settings</a></li>
                        <li>
                            <form method="post" action="logout.php">
                                <button class="btn">ログアウト</button>
                                <input id="logout_button" type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>        
</header>
