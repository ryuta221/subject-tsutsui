<?php
// エントリー時に表示する警告ページ
session_start();
require_once('../mylib/function.php');
if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
}
require('html/header.html');
require('../mylib/header_nav.php');
$_SESSION['token'] = get_csrf_token();

$userid = (string)filter_input(INPUT_GET, "userid");
$postid = (string)filter_input(INPUT_GET, "postid");


try{
    
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());
    // id チェック
    
    $stmt = $pdo->prepare('SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.postid = :postid AND users_profiles.userid = :userid');
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
    $stmt->execute();
}catch(PDOException $e) {
    
}

foreach($stmt as $row) {
    $postid            = $row['postid'];
    $article_title     = $row['article_title'];
    $article_overview  = $row['article_overview'];
    $recluting_skill   = $row['recluting_skill'];
    $job_description   = $row['job_description'];
    $expiration_date   = $row['expiration_date'];
    $comment           = $row['comment'];
    $post_create_at    = $row['post_create_at'];
    $post_update_at    =  $row['post_update_at'];

    $userid            = $row['userid'];
    $profile_image_url = $row['profile_image_url'];
    $username          = $row['username'];
}


?>
<div class="container">
    <div class="row justify-content-center">
        <div class="card m-3 col-lg-10">
            <div class="card-header fs-3">
                エントリーの注意事項
            </div>
            <div class="card-body">
                <p class=" width: 6rem bg-light" style="margin: 8px;">
                    注意書き<br>
                    注意書き<br>
                    注意書き<br>
                    注意書き<br>
                    注意書き<br>
                    注意書き
                </p>
            </div>
            <form action="entry_check.php" method="post"  class="text-right">
                <div class="d-flex w-100 justify-content-end py-2">
                <button type="submit" class="btn btn-primary" style="">entry</button></div>
                <input type="hidden" name="postid" value="<?= h($postid) ?>">
            </form>
            
        </div>
    </div>
</div>
<?php

require_once("html/footer.html");
?>