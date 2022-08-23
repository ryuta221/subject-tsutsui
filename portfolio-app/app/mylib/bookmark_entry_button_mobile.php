
<?php
// mobileの時のボタン
if(empty($_SESSION['user']['userid'])) {
    // 未ログイン用の処理 未使用
    echo '<button class="btn btn-primary  d-block d-sm-none d-md-none" onclick="notLogin()">bookmarkする。未ログイン</button>';
    echo '<button  type="button" class="btn btn-primary  d-block d-sm-none d-md-none" onclick="notLogin()" style="width:30%">Entry.未ログイン</button>';

}else {
    $bookmark_stmt = $pdo->prepare("SELECT * FROM bookmark  WHERE postid = :postid AND userid = :userid AND bookmark_target_userid = :bookmark_target_userid");
    $bookmark_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR);
    $bookmark_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $bookmark_stmt->bindValue(':bookmark_target_userid', $row['userid'], PDO::PARAM_STR);

    $bookmark_stmt->execute();
    // ブックマーク済み
    if($bookmark_stmt->rowCount() > 0) {
        echo '<button class="btn btn-primary  d-block d-sm-none d-md-none" style="white-space: nowrap;" onclick="bookmark(event)" data-button="bookmark_button-'.h($j) . '" data-postid="' . h($row['postid']) .'" data-userid="' .h($row['userid']) . '">bookmark中</button>';
    }else {
        echo '<button class="btn btn-primary  d-block d-sm-none d-md-none" style="white-space: nowrap;" onclick="bookmark(event)" data-button="bookmark_button-'. h($j) . '" data-postid="' . h($row['postid']).'" data-userid="'.h($row['userid']).'">bookmarkする</button>';
    }

    //　自分の投稿かどうか
    if($row['userid'] != $_SESSION['user']['userid']){

        // Entry ボタン
        $entry_stmt = $pdo->prepare('SELECT * FROM posts_entrys  WHERE postid = :postid AND entry_userid = :userid');
        $entry_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR);
        $entry_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
        $entry_stmt->execute();

        if($entry_stmt->rowCount() == 0) {
            echo '<a href="entry_confirm.php?postid=' . $row['postid'] .'"><button type="button" class="btn btn-primary  d-block d-sm-none d-md-none mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop"style="width:120px">Entryする</button></a>';
        }else {
            // echo '<button class="btn btn-primary disable  d-block d-sm-none d-md-none mx-1" style="width:120px">Entry済み</button>';
            echo '<div class="d-block d-sm-none d-md-none mx-1 align-self-center text-center" style="white-space: nowrap;/*width:120px*/">Entry済み</div>';
            echo '<a href="entry_list.php?postid=' . $row['postid'] .'"><button class="btn btn-primary disable  d-block d-sm-none d-md-none mx-1" style="white-space: nowrap;/*width:110px*/">チャット</button></a>';
        }
        
    }else {
        // 自Editボタン
        echo '<a href="edit_post.php?postid=' .  h($row['postid']) . '"><button  type="button"style="width:120px;" class="btn btn-secondary  d-block d-sm-none d-md-none mx-1"  >Edit</button></a>';
    }
}
?>
