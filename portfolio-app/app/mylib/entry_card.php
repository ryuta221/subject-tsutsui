<div class="card rounded-3 m-2  order-2"  >
    <!-- 投稿したユーザー・投稿日の情報 -->
    <div class="user-data! d-flex align-items-center">
        <a href="profile.php?userid=<?= h($row['userid']);?>">
            <div class="mx-3" style="margin-top:5px;display: flex;font-size: 18px;line-height: 0.8;">
                <img style="border-radius: 50%;" src="<?= h(isProfileImageExist($row['profile_image_url'])); ?>" width="35" height="35" loading="lazy">
                <div class="mx-1">
                    <span class="my-1" style="display:block;"><?=  $row['username']?></span>
                    <span class="">
                        <time style="font-size: 12px;"><?= h(datetimeFormatConversion($row['post_create_at'])); ?></time>
                    </span>
                </div>
            </div>
        </a> 
        <div class="d-flex" style="margin-left: auto; background-color:red;">
            <?php
            require('bookmark_entry_button_desktop.php');
            ?>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex align-items-center ">
            <!-- 投稿詳細へのリンク -->
            <a href="post_detail.php?postid=<?= h($row['postid']); ?>&userid=<?= h($row['userid']);?>">
                <h5 class="card-title fs-3"><?= h($row['article_title']); ?></h5>
            </a>
            
        </div>
        
        <p class="card-text width: 6rem bg-light line_wrap" style="margin: 10px;overflow: hidden;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;">
            <?= h($row['article_overview']);?>
        </p>
        <div class="recuruit ">
            <div class="d-flex align-items-center">
                <img src="./images/search_icon.jpg" width="30" height="30">
                <div class="fs-6 px-2 align-middle "> 募集スキル:  </div>
                <?= h($row['recluting_skill']);?>
            </div>
            <div class="d-flex align-items-center">
                <img src="./images/tilelimit.jpg" width="30" height="30">
                <div class="fs-6 px-2 "> 残り期限: 
                <?=h(daysLeft($row['expiration_date']));?>日
                </div>
            </div>
        </div>
    </div>

    <!-- モバイルのボタン -->
    <div class="d-flex justify-content-around">
        <?php
        require('bookmark_entry_button_mobile.php');
        ?>
    </div>
</div>
<!-- cardのdiv -->