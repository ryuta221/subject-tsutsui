<?php
// reccomend（ランダムで）ユーザーを取得
try{
    $recommend_posts = $pdo->prepare('SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.post_status = 1 AND posts.expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) AND posts.userid != :userid ORDER BY RAND() LIMIT 3');
    $recommend_posts->bindValue(":userid", $_SESSION['user']['userid']);
    $recommend_posts->execute();
}catch(PDOException $e) {

}
foreach($recommend_posts as $posts) {
?>

<div class="card rounded-3 m-2">
    <!-- 投稿したユーザー・投稿日の情報 -->
    <div class="user-data! d-flex align-items-center">
        <a href="profile.php?userid=<?= h($posts['userid']); ?>">
            <div class="mx-3" style="margin-top:5px;display: flex;font-size: 18px;line-height: 0.8;">
                <img style="border-radius: 50%;" src="<?= h(isProfileImageExist($posts['profile_image_url'])); ?>" width="35" height="35" loading="lazy">
                <div class="mx-1">
                    <span class="my-1" style="display:block;"><?= h($posts['username']); ?></span>
                    <span class="">
                        <time style="font-size: 12px;"><?=h(datetimeFormatConversion($posts['post_create_at']));?></time>
                    </span>
                </div>
            </div>
        </a> 
    </div>

    <div class="card-body">
        <div class="d-flex">
            <!-- 投稿詳細へのリンク -->
            <div style="overflow: hidden; width: 100%;">
                <a href="post_detail.php?postid=<?=h($posts['postid'])?>&userid=<?=h($posts['userid'])?>">
                    <h5 class="card-title fs-3" style="overflow: hidden; width: 100%;"><?=$posts['article_title']?></h5>
                </a>
            </div>
        </div>
        <p class="card-text width: 6rem bg-light line_wrap" style="margin: 10px;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;"><?= nl2br(h($posts['article_overview']));?></p>
        <div class="recuruit ">
            <div class="d-flex align-items-center">
                <img src="./images/search_icon.jpg" width="30" height="30">
                <div class="fs-6 px-2 align-middle "> 募集スキル:  </div><?= h($posts['recluting_skill']); ?></div>
            <div class="d-flex align-items-center">
                <img src="./images/tilelimit.jpg" width="30" height="30">
                <div class="fs-6 px-2 "> 残り期限:  <?=h(daysLeft($posts['expiration_date']));?>日</div>
            </div>
        </div>
    </div>

</div>
<?php
}
?>