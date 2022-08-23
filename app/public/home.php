<?php
// Homeの画面を作る
session_start();
require_once('../mylib/function.php');
if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
}

require('html/header.html');

$_SESSION['token'] = get_csrf_token(); // logout処理に使う

// pagenationで使用
$post_page = (string)filter_input(INPUT_GET, "page");
if($post_page == '' ||  !is_numeric($post_page)) {
    $post_page = 1;
}
$row_count = 10; //何個分表示するか
?>
<body>
    <?php
    require_once('../mylib/header_nav.php');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 pb-2" style="background-color: white">
                <!-- 投稿一覧の作成　-->
                <?php
                try {
                    $pdo = new PDO(DSN,USER_NAME,PASSWD,get_pdo_options());
                    // 有効な投稿の総数取得
                    $stmt = $pdo -> query("SELECT COUNT(*) FROM posts WHERE post_status = 1 AND expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) ");
                    $count = $stmt -> fetch(PDO::FETCH_COLUMN);

                    // ユーザーのプロフィールと画像を連結して取得
                    $stmt = $pdo->prepare("SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE post_status = 1 AND expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) ORDER BY post_create_at DESC LIMIT :post_page, :row_count ");// 公開投稿のみの取得
                    $stmt->bindValue(':post_page', ($post_page - 1) * $row_count);
                    $stmt->bindValue(':row_count', $row_count);
                    $stmt->execute();
                }catch(PDOException $e) {
                    // var_dump($e);
                }
                
                if($stmt->rowCount() === 0) {
                    echo '<div class="d-flex align-items-center justify-content-center" style="/* background-color:pink; */ height:140px" ><div class="">投稿はありません</div></div>';
                    
                }
            
                
                // 投稿の組み立てを行う
                foreach($stmt as $j => $row) {
                    // 投稿情報とそのindex -> indexはbookmark処理時の投稿の識別で使用する
                    require('../mylib/post_card.php');
                } 
                                
            
                require_once("../mylib/pageClass.php");
                $pageing = new Paging();
                //1ページ毎の表示数を設定
                $pageing -> count = $row_count;
                //全体の件数を設定しhtmlを生成
                $pageing -> setHtml($count);
                
                //ページングクラスを表示
                echo $pageing -> html;
                ?>
            </div>


            <!-- 右のコンテンツ -->
            <div class="col-lg-4 bg-light" style="/*background-color: violet;*/">
                <div class="card rounded-3 m-2  order-1"  >
                    <div class="card-header "> このサイトについて</div>
                    <div class="card-body">
                        開発メンバーを募集できる掲示板です。<br>
                        <a href="about_site.php" style="color: blue;">詳細はこちら!!</a>
                    </div>
                </div>
                <h2 class=" order-4"> おすすめの投稿</h2>
                <?php require("../mylib/recommend_posts.php");?>
            </div>
        </div>
</div>
<?php
require_once("html/footer.html");
?>
