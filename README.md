# 開発メンバー募集サイト(株式会社アルサーガ様企業課題)
開発に必要なスキルを持つメンバーを募集できる掲示板です。<br>
個人開発をする際、必要なスキルを持つメンバーがおらず、開発に時間がかかってしまうという課題を解決したかったため開発しました。

## 主な機能
- ログイン・ログアウト、新規登録機能
- 投稿機能（投稿、編集、削除、投稿詳細の表示）
- 下書き機能（投稿下書き、編集、保存、削除）
- Ajaxを用いた非同期での投稿ブックマーク機能（ブックマークへの保存、削除）
- Ajaxポーリングでのチャット機能
- 投稿の検索機能
- プロフィール機能（プロフィール情報の表示、編集、削除）
- アカウント管理機能(アカウント情報の編集、削除)


## 使用技術

<div >
    <p class="fs-4">フロントエンド (HTML5, CSS3, javaScript, bootstrap5)<br></p>
    <div class="d-flex">
        <img src="./images/html-5.svg" width="200" height="200"> 
        <img src="./images/css-3.svg"width="200" height="200"> 
        <img src="./images/javascript.svg" width="200" height="200"> 
        <img src="./images/bootstrap.svg" width="200" height="200"> 
    </div>
</div>
<div >
    <p class="fs-4">バックエンド (PHP7, Apache, MySql, Ec2, S3, Route53, certificate-maneger, dokcer, docker compose)<br></p>
    <div class="d-flex">
        <img src="./images/php.svg">
    </div>
    <p>インフラ</p>
    <img src="./images/apache.svg"width="200" height="200"> 
    <img src="./images/mysql.svg" width="200" height="200"><br>
    <img src="./images/docker.png" height="200">
    <img src="./images/docker-compose.png" height="200"> <br>
    <img src="./images/aws-ec2.svg" width="200" height="200"> 
    <img src="./images/aws-s3.svg" width="200" height="200">
    <img src="./images/aws-route53.svg" width="200" height="200">
    <img src="./images/aws-certificate-manager.svg" width="200" height="200">
</div>

## Demo
<div>
  <div>
    <h3>新規登録からログインまで</h3>
    <img src="./images/gif/signup_login.gif"> 
  </div>
  
   <div>
    <h3>記事の投稿</h3>
    <img src="./images/gif/post.gif"> 
  </div>
  
  <div>
    <h3>記事の編集</h3>
    <img src="./images/gif/edit_post.gif"> 
  </div>
  <div>
    <h3>記事の検索とログアウト</h3>
    <img src="./images/gif/search.gif"> 
  </div>
  
</div>


## 🌐 App URL
<a href="https://subject-tsutsui.net" target="_blank">https://subject-tsutsui.net</a>

## 💬 Usage  
`$ git clone https://github.com/ryuta221/subject-tsutsui.git`

コンテナの開始  
`$ docker compose up --build -d`

コンテナの削除  
`$ docker compose down`


## 📦 Features
詳細は https://subject-tsutsui.net/about_site.php に記載

## :eyes: Author
- 19c1080016tr@edu.tech.ac.jp
