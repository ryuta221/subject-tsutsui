<?php
// 投稿の詳細ページ
// $_SESSIONではなく普通のセッション変数に代入
// $current_filename 現在のファイル名の取得
?>
<div class="container py-3">
    <div class="row">            
        <div class="card mx-auto " style=" width: 90%;"> 
            <div class="card-header fs-2"><?= $current_filename == 'edit_post.php' ? '投稿編集' : '投稿ページ'?></div>
            <form id="edit_post_form" action="post_check.php" method="post">
                <div class="card-body ms-2">

                    <div class="title" style="width: 90%;">
                        <div class="d-flex">
                            <h5 class="card-title fs-10">タイトル</h5>
                            <?= isset($_SESSION['error']['require_title']) ? $_SESSION['error']['require_title'] : ''; ?>
                        </div>
                        <div class="ms-2" >
                            <input id="article_title" name="article_title" class="w-100" type="text" style="padding: 0 7px"value="<?= h($article_title); ?>" maxlength="100">
                            <div id="article_title_length" style="text-align:right"></div>
                        </div>
                    </div>
                    <div class="project my-3" style="width: 90%;">
                        <div class="d-flex">
                            <h5 class="card-title fs-10">プロジェクトについて</h5>
                            <span><?= isset($_SESSION['error']['require_article_overview']) ? $_SESSION['error']['require_article_overview'] : ''?></span>
                        </div>
                        
                        <div class="ms-2" >
                            
                            <textarea id="article_overview" name="article_overview" style="height: 400px; width: 100%; padding: 7px 7px;" maxlength="500"><?= h($article_overview); ?></textarea>
                            <div id="article_overview_length" style="text-align:right"></div>
                        </div>
                    </div>

                    <div class="recuruit">

                        <div class="recuruit_skill"  style="width: 80%;">
                            <div class="d-flex align-items-center pb-1">
                                <img src="./images/search_icon.jpg" width="40" height="40" style="">
                                <div class="d-flex">
                                    <div class="fs-5 ms-1" style="white-space:nowrap;"> 募集するスキルや業種</div>
                                    <div class="d-none d-md-block"><?= isset($_SESSION['error']['require_recluting_skill']) ? $_SESSION['error']['require_recluting_skill'] : ''; ?></div>
                                </div>
                            </div>
                            <div class="ms-5" style="width:100%;">
                                <div class="d-block d-md-none"><?= isset($_SESSION['error']['require_recluting_skill']) ? $_SESSION['error']['require_recluting_skill'] : ''; ?></div>
                                <input id="recluting_skill" name="recluting_skill" type="text" style="width:100%;padding: 0 7px;"value="<?=h($recluting_skill);?>" maxlength="100">
                                <div id="recluting_skill_length" style="text-align:right;"></div>
                            </div>
                        </div>
                        
                        <div style="width:80%">
                            <div class="d-flex align-items-center pb-1">
                                <img src="./images/bag.jpg" width="40" height="40">
                                <div class="d-flex">
                                    <div class="fs-5 ms-1"> 担当して欲しい業務</div>
                                    <div class="d-none d-md-block"><?= isset($_SESSION['error']['job_description']) ? $_SESSION['error']['job_description'] : ''; ?></div>
                                </div>
                            </div>
                            <div class="ms-5" style="width:100%;">
                                <div class="d-block d-md-none"><?= isset($_SESSION['error']['job_description']) ? $_SESSION['error']['job_description'] : ''; ?></div>
                                <textarea id="job_description" name="job_description" style="width:100%; height:400px;padding: 7px 7px" maxlength="500" ><?=h($job_description)?></textarea>
                                <div id="job_description_length" style="text-align:right;"></div>
                            </div>
                        </div>
                            
                        
                    
                        
                        <div class="d-flex align-items-center ">
                            <img src="./images/tilelimit.jpg" width="40" height="40" style="">
                            <div class="fs-5 px-1" style="white-space:nowrap;"> 募集期間</div>
                            
                            <input type="date" name="expiration_date" value="<?= editTime($expiration_date)?>" 
                            min=
                            <?php
                            // TODO: 3~10日間まで掲載される
                            $objDateTime = new DateTime();
                            // $objDateTime->modify('+3 day');
                            // echo $objDateTime->format('Y-m-d');
                            // $now = new DateTime();
                            echo $objDateTime->format('Y-m-d');
                            ?>
                            
                            max=
                            <?php
                            $objDateTime->modify('+10 day');
                            echo $objDateTime->format('Y-m-d');
                            ?>
                            >
                            
                                
                            <div class="d-none d-md-block"><?= isset($_SESSION['error']['expiration_date']) ? $_SESSION['error']['expiration_date'] : ''; ?></div>
                            </div>
                            
                        </div>
                        <div class="d-block d-md-none"><?= isset($_SESSION['error']['expiration_date']) ? $_SESSION['error']['expiration_date'] : ''; ?></div>
                            
                        <div class="my-3">
                            <h4 class="fs-5">一言メッセージ</h4>
                            <div class="d-flex align-items-center">
                                <img style="border-radius: 50%;" src="<?php
                                if($profile_image_url == '') {
                                    echo './images/user.png';
                                }else {
                                    echo h($profile_image_url);
                                }
                                ?>" width="60" height="60" size="30" loading="lazy">
                                <div class="balloon2-left mx-4" style="width:70%;height:200px">
                                    <textarea id="comment" name="comment" style="border:none;width: 100%;height:100%;padding: 0.5em;" maxlength="200" value="よろしくお願いします"><?=h($comment);?></textarea>
                                    <div id="comment_length" style="text-align:right;width:101.6%;padding-top:3px">3文字</div>
                                </div>
                                
                            </div>
                            <input type="hidden" name="profile_image_url" value="<?=$profile_image_url?>">
                        </div>
                    </div>
                </div>
                <script src="js/count_button.js"></script>
                <script>
                    // 処理が遅いのでワンライナー
                    const article_title = document.getElementById('article_title');
                    const article_title_length = document.getElementById('article_title_length');
                    function coutn_article_title_length() {
                        article_title_length.textContent = countGrapheme(article_title.value) + '/100';
                    }

                    const article_overview = document.getElementById('article_overview');
                    const article_overview_length = document.getElementById('article_overview_length');
                    function count_article_overview_length() {
                        article_overview_length.textContent = countGrapheme(article_overview.value) + '/500';
                    }

                    const recluting_skill = document.getElementById('recluting_skill');
                    const recluting_skill_length = document.getElementById('recluting_skill_length');
                    function count_recluting_skill_length() {
                        recluting_skill_length.textContent = countGrapheme(recluting_skill.value) + '/100';
                    }

                    const job_description = document.getElementById('job_description');
                    const job_description_length = document.getElementById('job_description_length');
                    function count_job_description_length() {
                        job_description_length.textContent = countGrapheme(job_description.value) + '/500';
                    }

                    const comment = document.getElementById('comment');
                    const comment_length = document.getElementById('comment_length');
                    function count_comment_length() {
                        comment_length.textContent = countGrapheme(comment.value) + '/200';
                    }

                    window.onload = () => {
                        // TODO サロゲートペアの考慮とそれに伴うMysqlの文字数上限の見直し
                        coutn_article_title_length();

                        count_article_overview_length();

                        count_recluting_skill_length();

                        count_job_description_length();

                        count_comment_length();

                        // 属性の登録
                        article_title.addEventListener('input', coutn_article_title_length, false);
                        article_overview.addEventListener('input', count_article_overview_length, false);
                        recluting_skill.addEventListener('input', count_recluting_skill_length, false);
                        job_description.addEventListener('input', count_job_description_length, false);
                        comment.addEventListener('input', count_comment_length, false);
                    }
                    
                </script>
                <!-- 各ボタンにpostidを渡すための埋め込み -->
                <input name="postid" type="hidden" value="<?=h($postid);?>">
                <div class="card-footer d-flex justify-content-end">
                    <!-- 保存 -->
                    <div class="px-1">
                        <button type="button"  onclick="draftSubmit()" class="btn btn-primary btn-lg">下書きとして保存</button>
                    </div>
                    <!-- 公開 -->
                    <div class="px-1">
                        <button type="button"  onclick="publicSubmit()" class="btn btn-primary btn-lg"><?= $current_filename == 'edit_post.php' ? '更新して投稿する' : '投稿する'?></button>
                    </div>
                    <?php
                    // $page_name;
                    if($current_filename == 'post.php') {
                        // 新規投稿の時は削除ボタンを表示しない
                    }else {
                        // edit_post.phpの時
                    ?>
                        <!-- 消す -->
                        <div class="px-1">
                            <button type="button"  onclick="deleteButton()" class="btn btn-danger btn-lg">投稿削除</button>
                        </div>
                    <?php
                    }
                    
                    ?>
                </div>
                <?php
                if($current_filename == 'edit_post.php') {
                    echo '<input id="postid" type="hidden" name="postid" value="' . $postid . '">';
                }
                
                ?>
                <script>
                        function deleteButton() {
                            if (window.confirm('投稿を削除しますか？？')) {
                                // deleteへ
                                let form = document.createElement('form');
                                let postid = document.getElementById('postid').value;

                                console.log(postid);
                                
                                form.action = "delete_post.php";
                                form.method = 'post';

                                document.body.append(form);
                                form.addEventListener('formdata', (e) => {
                                    var fd = e.formData;
                                    
                                    // データをセット
                                    fd.set('postid', postid);
                                });

                                console.log(form);
                                // submit
                                form.submit();
                            }
                        }
                        // 下書きボタン
                        function draftSubmit(){
                            let fo = document.getElementById('edit_post_form');
                            fo.addEventListener('formdata', (e) => {
                                e.formData.set('post_status', 0);
                            });
                            
                            fo.submit();
                        }
                        // 公開投稿ボタン
                        function publicSubmit(){
                            // 公開投稿を示すフラグを立ててフォーム送信
                            let fo = document.getElementById('edit_post_form');
                            fo.addEventListener('formdata', (e) => {
                                e.formData.set('post_status', 1);
                            });
                            
                            fo.submit();
                        }
                    </script>
                <input type="hidden" name="token" value="<?= h($_SESSION['token']) ?>">
                <input type="hidden" name="current_filename" value="<?= h($current_filename) ?>">
                
                
                <?php
                $_SESSION['error'] = [];
                $_SESSION['tmp'] = [];
                ?>
            </form>
        </div>
    </div>
</div>