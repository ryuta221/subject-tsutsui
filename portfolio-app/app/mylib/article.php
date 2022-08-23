<?php
require_once('function.php');
try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE post_status = 1 AND expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) ORDER BY RAND() LIMIT 3');
    $stmt->execute();
}catch(PDOException $e) {
    // error
}

foreach($stmt as $row) {
    $postid            = $row['postid'];
    $article_title     = $row['article_title'];
    $article_overview  = $row['article_overview'];
    $recluting_skill   = $row['recluting_skill'];
    $job_description   = $row['job_description'];
    $expiration_date   = $row['expiration_date'];
    $comment           = $row['comment'];

    // 本当は直接触らない
    $post_create_at    = $row['post_create_at'];
    $post_update_at    =  $row['post_update_at'];

    // users_profilesの項目
    $userid            = $row['userid'];
    $profile_image_url = $row['profile_image_url'];
    $username          = $row['username'];
?>

<div class="card rounded-3 m-2  order-2">
    <!-- 投稿したユーザー・投稿日の情報 -->
    <div class="user-data! d-flex align-items-center">
        <a href="profile.php?userid=<?=h($userid)?>">
            <div class="mx-3" style="margin-top:5px;display: flex;font-size: 18px;line-height: 0.8;">
                <img style="border-radius: 50%;" src="<?= h(isProfileImageExist($profile_image_url));?>" width="35" height="35" loading="lazy">
                <div class="mx-1">
                    <span class="my-1" style="display:block;"><?= h($username); ?></span>
                    <span class="">
                        <time style="font-size: 12px;"><?= h(datetimeFormatConversion($post_create_at)); ?></time>
                    </span>
                </div>
            </div>
        </a> 
    </div>

    <div class="card-body">
        <div class="d-flex ">
            <!-- 投稿詳細へのリンク -->
            <a href="post_detail.php?postid=<?=h($postid)?>&userid=<?=h($userid)?>">
                <h5 class="card-title fs-3"><?= h($article_title); ?></h5>
            </a>
        </div>
        <p class="card-text width: 6rem bg-light line_wrap" style="margin: 10px;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;"><?= h($article_title); ?></p>
        <div class="recuruit">
            <div class="d-flex align-items-center">
                <img src="./images/search_icon.jpg" width="30" height="30">
                <div class="fs-6 px-2 align-middle "> 募集スキル:  </div><?= h($recluting_skill); ?></div>
            <div class="d-flex align-items-center">
                <img src="./images/tilelimit.jpg" width="30" height="30">
                <div class="fs-6 px-2 "> 残り期限: <?=h(daysLeft($expiration_date));?>日</div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>