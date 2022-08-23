<?php
// プロフィールページを作る
session_start();
require_once("../mylib/function.php");

if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
}

$userid = (string) filter_input(INPUT_GET, "userid"); 
try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM users_profiles WHERE userid = :userid');
    $stmt->bindValue(':userid', $userid);
    $stmt->execute();
    if($stmt->rowCount() == 0){
        redirectToNotFound();
    }
}catch(PDOException $e) {
    // var_dump($e);
}

foreach($stmt as $row) {
    // user_profilesテーブルの項目
    $username          = $row['username'];
    $autobiography     = $row['autobiography'];
    $profile_image_url = $row['profile_image_url'];

    // postsテーブルの項目
    $twitter_url = $row['twitter_url'];
    $github_url = $row['github_url'];
    $display_email = $row['display_email'];

}


require_once("html/header.html");
require_once("../mylib/header_nav.php");
?>
<body style="/*background-color: #F4F5F7;*/">
<div class="container rounded-3"  style=" ">
    <!-- 外の分割 -->
    <div class="row p-2" >
        <div class="col-lg-9" style="/*background-color: orchid;*/">
            <div class="row" >
                <div class="col-lg-4" style="/*background-color: yellowgreen;*/ text-align: center;">
                    <a href="#">
                        <div class="d-flex align-items-center justify-content-center ">
                            <!-- ユーザーアイコン -->
                        <img id="view" style="border-radius: 50%;" src="<?= h(isProfileImageExist($profile_image_url)); ?>" width="200" height="200" size="30" loading="lazy" >
                        </div>
                    </a>
                    
                    <?php
                    if($userid == $_SESSION['user']['userid']) {
                    ?>
                    
                    <label class="align-items-center justify-content-center" >
                        <div class="btn btn-primary">
                            Choose File
                            <input name="image" type="file" style="display: none;" onchange="profileImageUpload(this)">
                        </div>
                    </label>
                    <?php
                    }
                    ?>
                    <script src="js/profile_image_upload.js"></script>

                </div>
                <div class="col-lg-8" style="/*background-color: cornflowerblue;*/">
                
                    <div class="pt-4" style="/*background-color: paleturquoise;*/">
                        <div class="d-flex">
                            <h1 class="fs-2" style="height:30px"><?=h($row['username']);?></h1>
                        </div>
                        <p class="m-2 px-1 box17 " style="background-color: white; height:100px;overflow: hidden;overflow: scroll;">
                            <?=nl2br(h($row['autobiography']));?>
                        </p>
                        <?php
                        if($userid == $_SESSION['user']['userid']) {
                        ?>
                            <form action="#" method="post" class="d-flex justify-content-center pt-4">
                                <button type="submit" class="btn btn-primary w-75 " formaction="./edit_profile.php">プロフィール編集</button>
                                <button class="btn btn-primary w-75" formaction='./entry_list.php'>チャット</button>
                        </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div  class="row">
                <div class="col-lg-4 py-2" style="/*background-color:red;*/">
                    <!-- リンク　-->
                    <div class="card">
                        <div class="card-header">
                        <i class="fa fa-solid fa-link"></i>
                            リンク
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="fab fa-twitter me-2"></i><?= h($row['twitter_url']== '' ?  "No set":$row['twitter_url'])   ?></li>
                            <li class="list-group-item"><i class="fab fa-github me-2"></i><?= h($row['github_url']== '' ?  "No set":$row['github_url'])   ?></li>
                            <li class="list-group-item"><i class="fa fa-envelope me-2" aria-hidden="true"></i><?= h($row['display_email']== '' ?  "No set":$row['display_email'])?></li>
                      </ul>
                    </div>
                </div>
                <script>

                </script>
            
            <div class="col-lg-8 py-2">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" id="reculute_tab">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">募集中</a>
                    </li>
                    <?php
                    if($userid == $_SESSION['user']['userid']) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">下書き</a>
                    </li>

                    <!-- 自分の投稿なら表示 -->
                        <li class="nav-item ">
                            <a class="nav-link" id="test-tab" data-bs-toggle="tab" href="#test" role="tab" aria-controls="test" aria-selected="false">ブックマーク</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="entry-tab" data-bs-toggle="tab" href="#entry" role="tab" aria-controls="entry" aria-selected="false">エントリー中</a>
                        </li>
                    <?php
                    }
                    ?>

                </ul>
                <div class="tab-content profile-tab" id="myTabContent">
                    <!-- 投稿中の記事 -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <?php

                        try{
                            $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
                            $stmt = $pdo->prepare('SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.userid = :userid AND posts.post_status = 1');
                            $stmt->bindValue(':userid', $userid);
                            $stmt->execute();                            
                        }catch(PDOException $e) {
                            // var_dump($e);
                        }
                    
                        if($stmt->rowCount() == 0){
                            ?>
                            <div class="d-flex align-items-center justify-content-center" style="/*background-color:pink;*/ height:140px" >
                                <div class="">投稿はありません</div>
                            </div>
                            
                            <?php
                            // 投稿あったとき
                        }else {
                            foreach($stmt as $j => $row) {

                                // 各投稿でエントリーしているユーザー数取得
                                $entry = $pdo->prepare('SELECT COUNT(*) as cnt FROM posts_entrys WHERE postid = :postid ');
                                $entry->bindValue(':postid', $row['postid']);
                                // $entry->bindValue(':entry_userid', $);
                                $entry->execute();
                        
                                // 自分の投稿の時
                                if($userid == $_SESSION['user']['userid']) {
                                ?>
                                <div class="card my-1" style="display:flex">
                                    <div class="card-body">
                                    <div class=""> <?= h($row['article_title']); ?></div>
                                        <div class=" d-flex align-items-center justify-content-center">
                                            <a href="entry_users.php?postid=<?=$row['postid']?>"><button class="btn"> <?= $entry->fetch()['cnt'] ?>名エントリー中</button></a>
                                            <a href="edit_post.php?postid=<?=h($row['postid']);?>"><button class="btn btn-primary">編集</button></a>
                                            <form action="delete_post.php" method="post" class="ps-3">
                                                <button class="btn btn-secondary" onclick="return conform()">削除</button>
                                                <input type="hidden" name="postid" value="<?=h($row['postid'])?>">
                                            </form>
                                        </div>    
                                    </div>
                                    
                                </div>
                                
                                <?php
                                }else {
                                    require("../mylib/post_card.php");
                                }
                            }
                        }
                        ?>
                    </div>

                    <!-- 下書き -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <?php
                        try{
                            $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
                            $stmt = $pdo->prepare('SELECT * FROM posts  WHERE userid = :userid AND post_status = 0');
                            $stmt->bindValue(':userid', $_SESSION['user']['userid']);
                            $stmt->execute();
                        }catch(PDOException $e) {
                            var_dump($e);
                        }

                            if($stmt->rowCount() == 0){
                        ?>
                            <div class="d-flex align-items-center justify-content-center" style="/*background-color:pink;*/ height:140px" >
                                <div class="">下書きはありません</div>
                            </div>
                            <?php
                            }
                            foreach($stmt as $row) {
                            ?>
                            <div class="card my-1">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-lg-4 d-flex  align-items-center" style="">
                                            <div><a href="edit_post.php?postid=<?=h($row['postid']);?>&userid=<?=h($row['userid'])?>"><?= h($row['article_title']);?></a></div>
                                        </div>
                                        <div class=" col-lg-8 d-flex  align-items-center  " style="padding-left: 3em">
                                            <a href="edit_post.php?postid=<?=h($row['postid']);?> "><button class="btn btn-primary">編集</button></a>
                                            <form action="delete_post.php" method="post" class="ps-3">
                                                <button type="submit" onclick="return conform()" class="btn btn-primary">
                                                    削除
                                                </button>
                                                <input type="hidden" name="postid" value="<?=h($row['postid'])?>">
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                        <script>
                            function conform() {
                                if (window.confirm('投稿を削除しますか？？')) {
                                    return true;
                                }else return false;//
                            }
                        </script>
                    </div>

                    <!-- 自分の投稿かどうかで分岐-->
                    <?php
                    if($userid == $_SESSION['user']['userid']) {
                    ?>

                    <!-- ブックマークした記事 -->
                    <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-12">
                            <!-- article -->
                            <?php
                            $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
                            $stmt = $pdo->prepare('SELECT * FROM bookmark  INNER JOIN posts ON bookmark.postid = posts.postid INNER JOIN users_profiles ON  posts.userid = users_profiles.userid WHERE bookmark.userid = :userid AND posts.expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)');
                            $stmt->bindValue(':userid', $_SESSION['user']['userid']);
                            $stmt->execute();
                        
                            if($stmt->rowCount() == 0){
                            ?>
                                <div class="d-flex align-items-center justify-content-center" style="/*background-color:pink;*/ height:140px" >
                                    <div class="">ブックマークはありません</div>
                                </div>
                            <?php
                            }
    
                            foreach($stmt as $j => $row) {
                                require('../mylib/post_card.php');
                            }
                            ?>
                            </div>
                        </div>
                    </div>


                    <!-- エントリー中 -->
                    <div class="tab-pane fade" id="entry" role="tabpanel" aria-labelledby="profile-tab">
                        <?php

                        try{
                            // 自分がエントリーしている記事取得
                            $stmt = $pdo->prepare('SELECT * FROM posts_entrys  INNER JOIN posts ON posts_entrys.postid = posts.postid INNER JOIN users_profiles ON  posts.userid = users_profiles.userid WHERE posts_entrys.entry_userid = :userid');
                            $stmt->bindValue(':userid', $_SESSION['user']['userid']);
                            $stmt->execute();
                            if($stmt->rowCount() == 0) {
                                echo '<div class="d-flex align-items-center justify-content-center" style="/*background-color:pink;*/ height:140px" >
                                <div class="">エントリーしてみましょう</div>
                            </div>';
                            }
                        }catch(PDOException $e) {
                        }
                        foreach($stmt as $j => $row) {
                            require('../mylib/post_card.php');
                            }
                        ?>
                    </div>
                    
                    <?php
                    }
                    ?>
                </div>
            </div>  
            </div>  
        </div>
        <!-- 左のコンテンツ -->
        <div class="col-lg-3" style="/*background-color: orange;*/ background-color:white">
            <h2>その他ユーザー</h2>
            <div class="suggets-users">
                <?php
                require("../mylib/recommend_users.php");
                
                ?>
     
            </div>            
            </div>
        </div>
    </div>
</div>
</body>
<?php
require_once('html/footer.html');
?>