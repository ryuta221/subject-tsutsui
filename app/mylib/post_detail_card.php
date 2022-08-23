<!-- 投稿詳細に表示されるcard -->
<div class="card m-3" >
    <div class="user-info">
        <div class="d-flex">
            <a href="profile.php?userid=<?= h($userid); ?>">
                <div class="px-3 py-2 d-flex align-items-center" >
                    <img class="me-1" style="border-radius: 50%;" src="<?= h(isProfileImageExist($profile_image_url));?>" width="30" height="30" size="30" loading="lazy">
                    <div class="fs-4"><?= h($username);?></div>
                    
                </div>
            </a>
            <div class="d-flex  py-2" style="margin-left:auto;">
                <?php require_once('bookmark_entry_button_desktop.php');?>
            </div>
        </div>
        <div class="d-flex ms-3" style="height:15px;">
            <p class="me-2" style="font-size:13px">投稿日<time><?= h(datetimeFormatConversion($post_create_at)); ?></time></p>
            <p class="" style="font-size:13px">更新日 <time><?= h(datetimeFormatConversion($post_update_at)); ?></time></p>
        </div>
    </div>
    
    <div class="card-body">
        <div class="d-flex align-items-center">
            <h5 class="card-title" style="overflow: hidden;"><?= h($article_title);?></h5>
            <div class="d-flex" style="margin-left: auto;">
        </div>
        <input id="userid" type="hidden" value="<?= h($userid); ?>">
        <input id="postid" type="hidden" value="<?= h($postid); ?>">
    </div>
    <p class="card-text width: 6rem bg-light" style="margin: 8px;">
        <?= nl2br(h($article_overview)); ?>
    </p>
    <div class="recuruit">
        <div class="d-flex align-items-center">
            <img src="./images/search_icon.jpg" width="30" height="30">
            <div class="fs-6 px-2 align-middle " style="overflow: hidden;"> 募集スキル:  <?= h($recluting_skill); ?></div>
        </div>
        <div class="my-1">
            <div class="d-flex align-items-center">
                <img src="./images/bag.jpg" width="30" height="30">
                <div class="fs-6 px-2 align-middle "> 担当して欲しい業務</div>
            </div>
            <p class="ms-5"><?= nl2br(h($job_description));?></p>
        </div>
    

        <div class="d-flex align-items-center">
            <img src="./images/tilelimit.jpg" width="30" height="30">
            <div class="fs-6 px-2 "> 残り期限: <?=h(daysLeft($expiration_date));?>日</div>
        </div>              
        <div class="my-2" style="">
                <h4 class="fs-5">一言メッセージ</h4>
                <a href="#">
                    <div class="d-flex align-items-center">
                        <img style="border-radius: 50%;" src="<?= h(isProfileImageExist($profile_image_url));?>" width="60" height="60" size="30" loading="lazy">
                        <div class="balloon2-left" style="width: 50%">
                            <?= nl2br(h($comment)); ?>
                        </div>
                    </div>
                </a>
        </div>
        <div class="d-flex justify-content-around">
            <?php
            require('bookmark_entry_button_mobile.php');
            ?>
        </div>
    </div>            
    </div>            
</div>