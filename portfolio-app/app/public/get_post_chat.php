<?php 
// 自分とのエントリー履歴の取得
    session_start();
    require_once("../mylib/function.php");

    $entry_userid  = (string)filter_input(INPUT_POST, "entry_userid"); // 自分
    $postid        = (string)filter_input(INPUT_POST, "postid");
    $profile_image = (string)filter_input(INPUT_POST, "profile_image");

    $sql = "SELECT * FROM post_chat WHERE entry_userid = :entry_userid AND postid = :postid";
    $pdo = new PDO(DSN, USER_NAME, PASSWD ,get_pdo_options());
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':entry_userid', $entry_userid);
    $stmt->bindValue(':postid', $postid);
    $stmt->execute();

    $output = '';

    if($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['posted_userid'] == $_SESSION['user']['userid']) {
                $output .= '<div class="talk_right d-flex justify-content-end py-2"><p class="" style="/*text-align: right;*/
                background-color:#85e249;
                border-radius:20px;
                padding:3px 10px;
                margin:0 10px 0 0;
                max-width:200px;
                ">'.$row['message'].'</p></div>';
            }else {
                $output .= '<div class="d-flex justify-content-start py-2"><p class="" style="/*text-align: left;*/background-color:#85e249;
                border-radius:20px;
                padding:3px 10px;
                margin:0 10px 0 0;
                max-width:200px;">'.$row['message'].'</p></div>';
            }
            
        }
    }else {
        // トーク履歴がない時
    }
    echo $output;

  

?>