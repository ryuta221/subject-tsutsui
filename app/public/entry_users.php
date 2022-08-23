<?php
// entryしてくれたユーザーの取得　と　entry_userのリストページの作成
session_start();
$postid = (string) filter_input(INPUT_GET, "postid");
$entry_userid = (string) filter_input(INPUT_GET, "userid"); 
require_once("../mylib/function.php");


try{
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare('SELECT * FROM posts inner jOIN users_profiles ON posts.userid = users_profiles.userid WHERE posts.postid = :postid');
    $stmt->bindValue(':postid', $postid);
    $stmt->execute();
    if($stmt->rowCount() == 0) {
        // 投稿一覧

    }else {
        // 
    }
}catch(PDOException $e) {

}
foreach($stmt as $j => $row) {
    $postid            = $row['postid'];
    $article_title     = $row['article_title'];
    $article_overview  = $row['article_overview'];
    $recluting_skill   = $row['recluting_skill'];
    $job_description   = $row['job_description'];
    $expiration_date   = $row['expiration_date'];
    $comment           = $row['comment'];

    // 本当は直接触らない
    $post_create_at    = $row['post_create_at'];
    $post_update_at    =  $row['post_update_at'];

    $userid            = $row['userid'];
    $profile_image_url = $row['profile_image_url'];
    $username          = $row['username'];
}
require_once("../mylib/header_nav.php");
require_once("html/header.html");
?>
<div class="container">
    <div class="row" style="">
        <div class="col-lg-7" style="/*background-color: yellowgreen;*/">
        <?php
            
            require_once("../mylib/post_card.php");
            ?>
        <h1>この投稿にエントリーしてくれている人</h1>
        <?php
        try{
            
            $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
            $entry_user = $pdo->prepare('SELECT * FROM posts_entrys INNER JOIN users_profiles ON posts_entrys.entry_userid = users_profiles.userid WHERE posts_entrys.postid = :postid');
            $entry_user->bindValue(':postid', $postid);
            $entry_user->execute();
        }catch(PDOException $e) {

        }

            foreach($entry_user as $j => $user) {
                $entry_user_profile_image_url = $user['profile_image_url'];
        ?>
        <a href="entry_users.php?postid=<?=$user['postid']?>&userid=<?=$user['userid']?>">
            <div class="card my-1 " data-userid="<?=$user['userid']?>" data-number="<?=$j?>" data-username="<?= h($user['userid']);?>">
                <div class="card-body d-flex align-items-center">
                    <img style="border-radius: 50%;" src="<?= h($user['profile_image_url'] ?? ''); ?>" width="35" height="35" loading="lazy">
                    <div class="mx-1"><?= h($user['username']);?></div>
                    
                </div>
            </div>
            </a>
        <?php
            }
        
        ?>
    </div>

    <input id="entry_userid" type="hidden" value="<?= h($entry_userid); ?>">
    <input id="postid" type="hidden" value="<?= h($postid); ?>">
    <input id="profile_image" type="hidden" value="<?= h($user['profile_image_url']); ?>">
    
    <div class="col-lg-5 d-lg-block " style="/* background-color: violet; */">
        <?php
        $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
        $u = $pdo->prepare('SELECT * FROM users_profiles WHERE userid = :userid');
        $u->bindValue(':userid', $entry_userid);
        $u->execute();
        foreach($u as $j => $r) {
            $un = $r['username'];
        }
        ?>
        

        <div class="card">
            <div class="card-header" id="chat_title" ><?php echo $entry_userid == '' ? 'チャットしよう' : $un;?></div>
            <div id="message_list" class="card-body " style="height:600px;overflow: hidden;overflow: scroll;">

            </div>
        </div>
        
  
        <script>
            let url = new URL(window.location.href);
            // URLSearchParamsオブジェクトを取得
            let params = url.searchParams;
            let p = params.get('userid');
            if(p!==null) {
                setInterval(() =>ajaxGetMessage(), 1000);
            }
            
            // レスポンス速度向上のためインラインで記述
            let messageList =  document.getElementById("message_list");
            let sendButton =  document.getElementById("sendButton");
            function scrollToBottom(){
                messageList.scrollTop = messageList.scrollHeight;
            }
            function ajaxGetMessage() {
                let req = new XMLHttpRequest();
                req.open('POST', 'get_post_chat.php', true);
                req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
                
                let postid =  document.getElementById("postid").value;
                let entry_userid =  document.getElementById("entry_userid").value;
                let profile_image =  document.getElementById("profile_image").value;
                req.send(`postid=${postid}&entry_userid=${entry_userid}&profile_image=${profile_image}`);
                
                let message = '';

                req.onreadystatechange = (e) => {
                    if (req.readyState == 4 && req.status == 200) {
                        // console.log("@@@@@@");
                        console.log(req.responseText);

                        document.getElementById("message_list").innerHTML = req.responseText;
                        // message = document.createElement('p');
                        // message();
                    }
                }
            }
            function sendToMysql(v) {
                if(document.getElementById('message').value.length != 0) {
                    let req = new XMLHttpRequest();
                    req.open('POST', 'post_chat_entry_users.php', true);
                    req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
                    
                    let postid =  v.dataset.postid;
                    let entry_userid = v.dataset.entry_userid;
                    let message = document.getElementById("message").value;

                    req.send(`postid=${postid}&entry_userid=${entry_userid}&message=${message}`);
                    
                    req.onreadystatechange = (e) => {
                        if (req.readyState == 4 && req.status == 200) {
                            scrollToBottom();
                        }
                    }
                    document.getElementById("message").value = '';
                }

            }
            
        </script>
        <div class="d-flex">
            <input id="message" name="message" type="text"style="width:100%">
            <input id="sendButton"type="button" onclick="sendToMysql(this)" data-postid="<?=h($postid)?>" data-entry_userid="<?=h($entry_userid)?>" value="送信">
        </div>
        </div>
        </div>
    </div>
</div>
        
        



<?php
require_once("html/footer.html");
?>

