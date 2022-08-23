<?php
// 投稿詳細ページを作る
session_start();
require_once('../mylib/function.php');
$postid = (string) filter_input(INPUT_GET, "postid");
$userid = (string) filter_input(INPUT_GET, "userid");
if($postid === '' || $userid === '') {
    redirectToNotFound();
    exit();
}
if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
}
require_once("html/header.html");
require_once('../mylib/header_nav.php');

try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());

    // ユーザーのプロフィールと画像を連結して取得
    $stmt = $pdo->prepare("SELECT * FROM posts inner jOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.postid = :postid AND users_profiles.userid = :userid");
    $stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
    $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
    $stmt->execute();
}catch(PDOException $e) {
    // var_dump($e);
}
if($stmt->rowCount() === 0) {
    redirectToNotFound();
    exit();
}

foreach($stmt as $row) {
    $article_title     = $row['article_title'];
    $article_overview  = $row['article_overview'];
    $recluting_skill   = $row['recluting_skill'];
    $job_description   = $row['job_description'];
    $expiration_date   = $row['expiration_date'];
    $comment           = $row['comment'];

    // 本当は直接触らない
    $post_create_at    = $row['post_create_at'];
    $post_update_at    =  $row['post_update_at'];

    // users_profilesテーブルの項目
    $userid            = $row['userid'];
    $profile_image_url = $row['profile_image_url'];
    $username          = $row['username'];
}


?>
<div class="container">
    <div class="row" style="">
        <div class="col-lg-7" style="/*background-color: yellowgreen;*/background-color: white;">
            <?php
            require_once('../mylib/post_detail_card.php');
            ?>
            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="col-lg-4 bg-light" style="/*background-color: violet;*/">
            <h2 class="py-3"> おすすめの投稿</h2>
            <?php
            require("../mylib/article.php");
            ?>    
        </div>
    </div>
</div>
<?php
require_once("html/footer.html");
?>