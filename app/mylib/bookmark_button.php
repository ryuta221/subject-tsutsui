
<?php
// bookmark処理を行う

try{
    // bookmark済みかどうかの確認
    $bookmark_stmt = $pdo->prepare("SELECT * FROM bookmark  WHERE postid = :postid AND userid = :userid AND bookmark_target_userid = :bookmark_target_userid");
    $bookmark_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR); // bookmark対象の投稿Id
    $bookmark_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR); // 自分のuserId
    $bookmark_stmt->bindValue(':bookmark_target_userid', $row['userid'], PDO::PARAM_STR); // 投稿者のuserID
    $bookmark_stmt->execute();
}catch(PDOException $e) {
}
// ブックマーク済み
// bookmark button
if($bookmark_stmt->rowCount() > 0) {
?>
<button class="btn btn-primary  d-none d-sm-block d-md-block" onclick="bookmark(event)" data-button="bookmark_button-<?= h($j); ?>" data-postid="<?=h($row['postid'])?>" data-userid="<?=h($row['userid'])?>">bookmark中</button>
<?php
}else {
?>
<button class="btn btn-primary  d-none d-sm-block d-md-block" onclick="bookmark(event)" data-button="bookmark_button-<?= h($j); ?> " data-postid="<?=h($row['postid'])?>" data-userid="<?=h($row['userid'])?>">bookmarkする</button>
<?php
}
?>
<script src="js/bookmark_button.js"></script>

<!-- entry Button -->
<?php
// entryしているかどうか
if($row['userid'] != $_SESSION['user']['userid']){
    $entry_stmt = $pdo->prepare('SELECT * FROM posts_entrys  WHERE postid = :postid AND entry_userid = :userid');
    $entry_stmt->bindValue(':postid', $row['postid'], PDO::PARAM_STR);
    $entry_stmt->bindValue(':userid', $_SESSION['user']['userid'], PDO::PARAM_STR);
    $entry_stmt->execute();

    // entry button
    if($entry_stmt->rowCount() == 0) {
    ?>
        <a href="entry_confirm.php?postid=<?=$row['postid']?>"><button type="button" class="btn btn-primary  d-none d-sm-block d-md-block mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Entryする
        </button>
    </a>
    <?php
    }else {
        echo '<button class="' .'btn btn-primary disable d-none d-sm-block d-md-block' . ' mx-1">Entry済み</button>';
    }
}else {
?>
<!-- edit button -->
<a href="edit_post.php?postid=<?= h($row['postid']);?>">
    <button  type="button" class="btn btn-secondary  d-none d-sm-block d-md-block mx-1"  >
        Edit
    </button>
</a>
<?php
}
?>

                            