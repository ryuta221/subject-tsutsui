<?php
// Dektopの時のボタン
if(empty($_SESSION['user']['userid'])) {
    // 未ログイン
    echo '<button class="btn btn-primary d-none d-sm-block d-md-block" onclick="notLogin()">bookmarkする。未ログイン</button>';
    echo '<button  type="button" class="btn btn-primary d-none d-sm-block d-md-block" onclick="notLogin()" style="width:30%">Entry</button>';

}else {
    // bookmark済みかどうかの確認
    $bookmark_stmt = $pdo->prepare("SELECT * FROM bookmark  WHERE postid = :postid AND userid = :userid AND bookmark_target_userid = :bookmark_target_userid");
    $bookmark_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR);
    $bookmark_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $bookmark_stmt->bindValue(':bookmark_target_userid', $row['userid'], PDO::PARAM_STR);
    $bookmark_stmt->execute();

    // bookmark済み
    if($bookmark_stmt->rowCount() > 0) {
        echo '<button class="btn btn-primary  d-none d-sm-block d-md-block" onclick="bookmark(event)" data-button="bookmark_button-'. h($j). '" data-postid="' . h($row['postid']) . '" data-userid="' . h($row['userid']) . '">bookmark中</button>';
    }else {
        echo '<button class="btn btn-primary  d-none d-sm-block d-md-block" onclick="bookmark(event)" data-button="bookmark_button-'.h($j) . '" data-postid="' . h($row['postid']) . '" data-userid="' . h($row['userid']) . '">bookmarkする</button>';
    }

    
    //Entry、Editボタンの生成
     

    //　自分の投稿かどうか
    if($row['userid'] != $_SESSION['user']['userid']){

        // Entry ボタン
        $entry_stmt = $pdo->prepare('SELECT * FROM posts_entrys  WHERE postid = :postid AND entry_userid = :userid');
        $entry_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR);
        $entry_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
        $entry_stmt->execute();

        if($entry_stmt->rowCount() == 0) {
            echo '<a href="entry_confirm.php?postid=' . $row['postid'] .'"><button type="button" class="btn btn-primary  d-none d-sm-block d-md-block mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Entryする</button></a>';
        }else {
            echo '<div class="  disable d-none d-sm-block d-md-block  mx-1 align-self-center" style="">Entry済み</div>';
            echo '<a href="./entry_list.php?postid=' . $row['postid'] .'"><button class="btn btn-primary disable d-none d-sm-block d-md-block ">チャット</button></a>';
        }

    }else {
        // 自分のEditボタン
        echo '<a href="edit_post.php?postid=' .  h($row['postid']) . '"><button  type="button" class="btn btn-secondary  d-none d-sm-block d-md-block mx-1"  >Edit</button></a>';
    }
}
?>
<script src="js/bookmark_button.js"></script>