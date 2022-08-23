<?php
// reccomend（ランダムで）投稿を取得
try{
    
    $recommend_users = $pdo->prepare('SELECT * FROM users_profiles ORDER BY RAND() LIMIT 3');
    $recommend_users->execute();
}catch(PDOException $e) {

}
foreach($recommend_users as $users) {
?>
<div class="py-1">
    <a href="profile.php?userid=<?=h($users['userid'])?>">
        <div class="card">
            <div class="d-flex  align-items-center m-2">
                <img style="border-radius: 50%;" src="<?= h(isProfileImageExist($users['profile_image_url'])); ?>" width="40" height="40" loading="lazy">
                <div class="fs-5 px-1"><?=h($users['username'])?></div>
            </div>
        </div>
    </a>
</div>
<?php
}
?>