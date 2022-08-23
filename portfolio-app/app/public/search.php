<?php
// 投稿ページを作る
session_start();
require_once("html/header.html");
require_once("../mylib/function.php");
require_once('../mylib/header_nav.php');


$post_page = (string)filter_input(INPUT_GET, "page");
if($post_page == '') {
    $post_page = 1;
}
$row_count = 10; // 何個ずつの表示か


$q = (string)filter_input(INPUT_GET, 'q');
$sort = (string)filter_input(INPUT_GET, 'sort');


$word = $q . '%';

$sql = "SELECT * FROM posts INNER JOIN users_profiles ON posts.userid = users_profiles.userid WHERE expiration_date >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY) "; // AND posts.article_title LIKE :word

if(strpos($q,'title:')!==false){
    $sql .=  'AND posts.article_title LIKE :word';
    $word = '%' . str_replace('title: ', '', $word);
}else if(strpos($q,'body:')!==false){
    $sql .=  'AND posts.article_overview LIKE :word';
    $word = '%' . str_replace('body: ', '', $word);
}else if(strpos($q,'skill:')!==false){
    $sql .=  'AND posts.recluting_skill LIKE :word';
    $word = '%' . str_replace('skill: ', '', $word);
}else {
    $sql .=  'AND posts.article_title LIKE :word';
}

if($sort != '') {
    if($sort == 'asc') {
        $sql = $sql . ' ORDER BY posts.post_create_at ASC';
    }else{
        $sql = $sql . ' ORDER BY posts.post_create_at DESC';
    }
}

// 新着順
try {

    $pdo = new PDO(DSN,USER_NAME,PASSWD,get_pdo_options());
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':word', $word);
    $stmt->execute();

    $post_count = $stmt->rowCount();
    $sql.= " LIMIT :post_page, :row_count";

    // TODOユーザーのプロフィールと画像を連結して取得
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':word', $word);
    $stmt->bindValue(':post_page', ($post_page - 1) * $row_count);
    $stmt->bindValue(':row_count', $row_count);
    
    $stmt->execute();
}catch(PDOException $e) {
    var_dump($e);
}      
?>


<div class="container" style="background-color:white">
    <div class="row py-3">
        <div class="col-lg-7" style="/* background-color: yellowgreen; */">
            <div class="seach-form" style="background-color: chartreuse;">
                <form class="search royalblue " action="search.php" method="get"  style="margin : 0 auto">
                    <input name="q" type="text" placeholder="input " value="<?=h($q);?>">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        
            <div class="d-flex justify-content-end align-items-center">
            <div class="px-2"><?= $post_count ?> 件</div>
            
            <form>
                <select id="order" class="form-select" aria-label="Default select example" onchange="createUrl()">
                    <?php
                    if($sort == 'desc') {
                        echo '<option value="asc" >新着順</option>';
                        echo '<option value="desc" selected>古い順</option>';
                    }else {
                        echo '<option value="asc" selected>新着順</option>';
                        echo '<option value="desc" >古い順</option>';
                    }
                    
                    ?>
                </select>
            </form>

            <script src="js/create_url.js"></script>
        </div>
        <hr>
<?php
        // 投稿の組み立てを行う
        foreach($stmt as $j=>$row) {
            
            require('../mylib/post_card.php');
        }
        if($post_count == 0) {
            // 見つからなかった
            echo '<div class="d-flex align-items-center justify-content-center" style="/* background-color:silver;*/ height:140px" ><div class="">見つかりませんでした....</div></div>';
        }

        require_once("../mylib/pageClass.php");
        $pageing = new Paging();
        //1ページ毎の表示数を設定
        $pageing -> count = $row_count;

        // echo $row_count.$post_count;
        //全体の件数を設定しhtmlを生成
        $pageing -> setHtml($post_count);
        
        //ページングクラスを表示
        echo $pageing -> html;
?>
        </div>
        <div class="col-lg-4 bg-light" style="/* background-color: violet;*/ ">
            
            <div class="card">
                <div class="card-header">
                    検索オプション
                </div>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item"><div>タイトル検索  <span style="font-size: 13px">ex) タイトルにpythonを含む</span></div><a href="search.php?q=title: python">title: python</a></li>
                    <li class="list-group-item"><div>本文検索 <span style="font-size: 13px">ex) 本文にexampleを含む</span></div><a href="search.php?q=body: example">body: example</a></li>
                    <li class="list-group-item"><div>スキル検索 <span style="font-size: 13px">ex) 募集スキルにPHPを含む</span></div><a href="search.php?q=skill: PHP">skill: PHP</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
    
<?php
require_once("html/footer.html");
?>