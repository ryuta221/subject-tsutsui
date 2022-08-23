<?php
// ユーザーのアイコンの登録を行う
session_start();
require('../mylib/function.php');
header("Content-type: application/json; charset=UTF-8");

$avator_image =  $_FILES['avator']['tmp_name'] ?? '';
$result = [];
// TODO :validation

if($avator_image == ''){
    echo json_encode(['status' => 'fail']);
    exit(0);
}
// TODO :拡張子、サイズチェック

try{
    // storageへのアップロード
    $bytes = random_bytes(5);
    $filename = 'profile/' . bin2hex($bytes) . basename($_FILES['avator']['name']);

    $image = fopen($_FILES['avator']['tmp_name'],'rb');
    $mime = mime_content_type($_FILES['avator']['tmp_name']);

    // s3へのアップロード
    $path = s3($filename, $image, $mime);

    // Dbへパスを保存
    $pdo = new PDO(DSN, USER_NAME, PASSWD, get_pdo_options());
    $stmt = $pdo->prepare('UPDATE users_profiles SET profile_image_url = :profile_image_url WHERE userid = :userid');
    $stmt->bindValue(':profile_image_url', $path);
    $stmt->bindValue(':userid', $_SESSION['user']['userid']);
    $stmt->execute();

    // s3から画像消す　
    $_SESSION['user']['profile_image_url'] = $path;
    echo json_encode(['status' => 'succsess', 'path' => $path]);
    exit(0);
    
}catch(PDException $e){
    // error
    echo json_encode(['status' => 'fail']);
    exit(0);
}
echo json_encode(['path' => $avator_image]);


?>