<?php
require __DIR__.'/../../vendor/autoload.php';
// credentialのロード
$dotenv =  Dotenv\Dotenv::createImmutable(__DIR__.'/../config');
$dotenv->load();

date_default_timezone_set('Asia/Tokyo');
define('DSN','mysql:host=app-db_server;dbname=app;charset=utf8');
define('USER_NAME', $_ENV['USER_NAME']);
define('PASSWD', $_ENV['PASSWD']);

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;

/*
* エスケープ処理（配列対応）
*/
function h($str){
    if(is_array($str)){
      //$strが配列の場合、h()関数をそれぞれの要素について呼び出す
      return array_map('h', $str);    
    }else{
      return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
} 

/*
* CSRF対策用のトークン作成
*/
function get_csrf_token() {
    $token_legth = 16; // 16*2=32byte
    $bytes = openssl_random_pseudo_bytes($token_legth);
    return bin2hex($bytes);
}

/*
* 各画面へのリダイレクト
*/
function redirect_to_post() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: post.php');
}
function redirectEditPassword() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: edit_password.php');
}
function redirectEditAccount() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: edit_account.php');
}
function redirectToSignup() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: signup.php');
}
function redirectToProfile($userid) {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: profile.php?userid=' . $userid);
}
function redirectToHome() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: home.php');
}
function redirectToLogin() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: login.php');
}
function redirectToEditPost($postid) {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: edit_post.php?postid='.$postid);
}
function redirectToSearch() {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: search.php');
}

function redirectToNotFound(){
  header("HTTP/1.1 404 Not Found");
  include($_SERVER['DOCUMENT_ROOT'].'/../mylib/not_found.php');
  exit();
}

/**
 * ユーザーがログインしているかどうか(login_check.phpファイル内で認証成功時にセットされる$_SESSION['user']を持つか)をチェック
 */
function isLoginUser() {
  if(empty($_SESSION['user'])) {
    redirectToLogin();
    exit();
  }
}

/**
* PDO の接続オプション取得
*/
function get_pdo_options() {
  return [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
      PDO::ATTR_EMULATE_PREPARES => false
  ];
}

/**
 * profile画像が存在するかどうか
 * 成功時: 画像URL
 * 失敗: デフォルトの画像へのURL
 */
function isProfileImageExist($image) {
  if($image == '') {
    return "./images/user.png";
  }else {
    return $image;
  }
}
/**
 * datetimeの形式（Y-d-m HH:YY:mm）をY/d/mに変換する
 */
function datetimeFormatConversion($datetime) {
  date_default_timezone_set('Asia/Tokyo');
  $date = explode(" ", $datetime);
  return  str_replace("-", "/", $date[0]);
}
/**
 * 今日から数えた残り時間を返す
 */
function  daysLeft($date) {
  $now_datetime = new DateTime();
  $expiration_date = new DateTime($date);
  return  $now_datetime->diff($expiration_date)->days;

}
/**
 * datatime形式を配列にする
 */
function editTime($datetime) {
  date_default_timezone_set('Asia/Tokyo');
  $date = explode(" ", $datetime);
  return $date[0];
}

/**
* s3へのアップロード処理
* 成功時 : 保存したデーターのパスを返す
*/
function s3($filename, $image, $mime){
    /**
     * $filename 保存先のパス
     * $image 画像データ
     * $mime mimeタイプ
     */

    $credentials = new Aws\Credentials\Credentials($_ENV['ACCESS_KEY'], $_ENV['SECRET_KEY']);
    // S3クライアントを作成
    $s3 = new S3Client([
      'version' => 'latest',
      'credentials' => $credentials,
      'region'  => 'us-east-1', // 東京リージョン
    ]);
  
    // TODO:AWSExceptionの追加

    $result = $s3->putObject([
      'ACL' => 'public-read',
      'Bucket' => $_ENV['BUCKET_NAME'], //　保存するバケットの指定
      'Key' => $filename, // 保存先のパスとファイル名の指定
      'Body' => $image, // 画像データーの指定
      'ContentType' => $mime // mimeタイプの指定 mime_content_type($_FILES['img_path']['tmp_name']),
    ]);
  
    // 読み取り用のパスを返す
    return $result['ObjectURL'];
}
?>