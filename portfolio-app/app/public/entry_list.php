<?php
// 自分がエントリーした投稿
$postid = (string) filter_input(INPUT_GET, "postid"); 

session_start();
require_once("../mylib/function.php");
require_once("html/header.html");
require_once("../mylib/header_nav.php");

?>
<div class="container">
    <div class="row" style="">
        <!-- 投稿詳細 -->
        <div class="col-lg-7" style="/*background-color: yellowgreen;*/">

        <?php
        
        $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
        // postidをつけずに訪問した時
        if($postid == '') {
        ?>
            <h2 class="pt-3">エントリー中の記事</h2>
            
            <?php
            $stmt = $pdo->prepare('SELECT * FROM posts_entrys  INNER JOIN posts ON posts_entrys.postid = posts.postid INNER JOIN users_profiles ON  posts.userid = users_profiles.userid WHERE posts_entrys.entry_userid = :userid');
            $stmt->bindValue(':userid', $_SESSION['user']['userid']);
            $stmt->execute();
            if($stmt->rowCount() == 0) {
                echo '<div class="w-100 bg-light">
                <div class="px-3  d-flex align-items-center justify-content-center" style="height:400px;">エントリー中の記事はありません</div>
            </div>';
            }else {
                foreach($stmt as $j=>$row) {
                    require('../mylib/post_card.php');
                }
            }
        }else {
            // 投稿の詳細の検索
            $stmt = $pdo->prepare('SELECT * FROM posts inner jOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.postid = :postid');
            $stmt->bindValue(':postid', $postid);
            $stmt->execute();

            if($stmt->rowCount() == 0) {
                echo '<div class="w-100 h-100 bg-light "><div class="px-3">チャットはありません</div></div>';
            }else {
                foreach($stmt as $j => $row) {
                    $postid           = $row['postid'];
                    $article_title    = $row['article_title'];
                    $article_overview = $row['article_overview'];
                    $recluting_skill  = $row['recluting_skill'];
                    $job_description  = $row['job_description'];
                    $expiration_date  = $row['expiration_date'];
                    $comment          = $row['comment'];

                    // 本当は直接触らない
                    $post_create_at   = $row['post_create_at'];
                    $post_update_at   =  $row['post_update_at'];

                    // users table
                    $userid            = $row['userid'];
                    $profile_image_url = $row['profile_image_url'];
                    $username          = $row['username'];
                }
                require_once('../mylib/post_detail_card.php');
            } 
        }
        
        ?>
    </div>

    <input id="entry_userid" name="entry_userid"  type="hidden" value="<?=$_SESSION['user']['userid']?>">
    <input id="postid" name="postid"  type="hidden"  value="<?=$postid?>">

    <div class="col-lg-5 py-3 ">
        <div class="card ">
            <div class="card-header d-flex align-items-center" id="chat_title" >
                <div class="d-flex me-auto"> 
                    <?php
                    if($postid == '' || $stmt->rowCount() == 0) {
                        echo '';
                    }else {
                        echo '<img id="view" style="border-radius: 50%;" src="'. h(isProfileImageExist($profile_image_url)) .'" width="30" height="30" size="30" loading="lazy" >';
                    }
                    ?>
                    
                    <div class="align-self-center ps-1">
                        <?php echo $postid == '' || $stmt->rowCount() == 0 ? 'チャットしよう' : $row['article_title'];?>
                    </div>
                </div>
                <div class="" style="">
                    <img id="view" class="" style="border-radius: 50%;text-align:right;" src="<?= h(isProfileImageExist($_SESSION['user']['profile_image_url'])); ?>" width="30" height="30" size="30" loading="lazy" >
                </div>
            </div>
            <div id="message_list" class="card-body " style="height:400px;overflow: hidden;overflow: scroll;">
                <script>
                    
                    let messageList =  document.getElementById("message_list");
                    // 一番下へスクロール
                    function scrollToBottom(){
                        messageList.scrollTop = messageList.scrollHeight;
                    }

                    // URLを取得
                    let url = new URL(window.location.href);

                    // URLSearchParamsオブジェクトを取得
                    let params = url.searchParams;
                    let p = params.get('postid');
                    if(p !== null) {
                        // console.log(typeof params.get('postid'));
                        setInterval(() =>ajaxGetMessage(), 1000);

                        // Mysqlからの投稿取得
                        function ajaxGetMessage() {
                            // console.log("ajaxGetMessage!!");
                            let req = new XMLHttpRequest();
                            req.open('POST', 'get_post_chat.php', true);
                            req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
                            
                            let postid =  document.getElementById("postid").value;
                            let entry_userid =  document.getElementById("entry_userid").value;
                            req.send(`postid=${postid}&entry_userid=${entry_userid}`);
                            
                            let message = '';

                            req.onreadystatechange = (e) => {
                                if (req.readyState == 4 && req.status == 200) {
                                    if(req.responseText == 'no_data') {
                                        document.getElementById("message_list").innerHTML = '<div class="position-absolute top-50 start-50 translate-middle"><div>チャットはありません</div></div>'
                                    }else {
                                        document.getElementById("message_list").innerHTML = req.responseText;
                                    }
                                }
                            }
                        }
                    }else {
                        // postidの指定がない時
                        document.getElementById("message_list").innerHTML = '<div class="position-absolute top-50 start-50 translate-middle"><div>エントリーしてチャットを始めましょう</div></div>'
                    }
                    
                    // Mysqlへの登録処理
                    function sendToMysql(v) {
                        if(document.getElementById('message').value.length != 0) {
                            let req = new XMLHttpRequest();
                            req.open('POST', 'post_chat.php', true);
                            req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
                            
                            let postid =  v.dataset.postid;
                            let message = document.getElementById("message").value;
                            req.send(`postid=${postid}&message=${message}`);
                            req.onreadystatechange = (e) => {
                                if (req.readyState == 4 && req.status == 200) {
                                    console.log(req.responseText);
                                    scrollToBottom();
                                }
                            }
                            document.getElementById("message").value = '';
                        }
                        

                    }
                </script>
            </div>
            <?php
            // 入力がない時は送信しない
            if($postid != '' && ($stmt->rowCount() != 0)) {
            ?>
            <div class="d-flex">
                <input id="message" style="width:100%" name="message" type="text">
                <input type="button" onclick="sendToMysql(this)" data-postid="<?=h($postid)?>"  value="送信">
            </div>
            <?php
            }
            ?>
            
            
        </div>
        
    </div>
    

    <?php
    
    if($postid != '') {
    ?>
        <div class="col-lg-7">
        <h2>その他のエントリー</h2>
        <?php
        $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
        $stmt = $pdo->prepare('SELECT * FROM posts_entrys  INNER JOIN posts ON posts_entrys.postid = posts.postid INNER JOIN users_profiles ON  posts.userid = users_profiles.userid WHERE posts_entrys.entry_userid = :userid');
        $stmt->bindValue(':userid', $_SESSION['user']['userid']);
        $stmt->execute();
        foreach($stmt as $j=>$row) {
            require('../mylib/post_card.php');
        }
        ?>

    </div>
    <?php
    }
    
    ?>
        
    </div>
</div>
<?php
require_once("html/footer.html");
?>


