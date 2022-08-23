<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div calss="card">
    <div class="card-title">
    </div>    
    <div class="card-body">
        <h3>なぜ作ったか</h3> 
        <p>個人開発をする際、必要なスキルを持つメンバーがおらず、開発に時間がかかってしまうという課題を解決したかった。<br> 人と交流したかった（個人的に）。</p> 
        <h3>主な機能</h3> 
        <ul>
            <li>ログイン・ログアウト、新規登録機能</li>
            <li>投稿機能（投稿、編集、削除、投稿詳細の表示）</li>
            <li>下書き機能（投稿下書き、編集、保存、削除）</li>
            <li>Ajaxを用いた非同期での投稿ブックマーク機能（ブックマークへの保存、削除）</li>
            <li>Ajaxポーリングでのチャット機能</li>
            <li>twitterへの投稿の共有</li>
            <li>投稿の検索機能</li>
            <li>プロフィール機能（プロフィール情報の表示、編集、削除）</li>
            <li>アカウントの編集機能</li>
            <li>レスポンシブ対応</li>
        </ul>
        <p>要件<br>※ログイン機能, CRUD処理, 検索機能, Bootstrapを用いたレスポンシブ対応, インフラにAWSを利用</p>
        <p>任意<br>※Dockerを使用しての環境構築</p>
        <div>  
            <h3 class="">使用技術</h3> 
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
                <img src="./images/mysql.svg" width="200" height="200"> 
                <img src="./images/aws-ec2.svg" width="200" height="200"> 
                <img src="./images/aws-s3.svg" width="200" height="200">
                <img src="./images/aws-route53.svg" width="200" height="200"> 
                <img src="./images/aws-certificate-manager.svg" width="200" height="200"> 
                <img src="./images/docker-icon.svg" width="200" height="200"> 
                <img src="./images/docker_compose.png" width="200" height="200"> 
            </div>

            <div class="db_structure">
            <p class="fs-4">DB設計<br></p>
                <ul>
                <li>
                    <div>usersテーブル</div>
                    <img src="./images/db_images/users.png" style="width: 50%">
                    <p>各ユーザーの情報を格納</p>
                </li>
                
                <li>
                    <div>users_profielsテーブル</div>
                    <img src="./images/db_images/users_profiles.png" style="width: 50%">
                    <p>各ユーザーのプロフィール情報を格納</p>
                </li>
                <li>
                    <div>postsテーブル</div>
                    <img src="./images/db_images/posts.png" style="width: 50%">
                    <p>各ユーザーの情報を保存</p>
                </li>
                <li>
                    <div>bookmarkテーブル</div>
                    <img src="./images/db_images/bookmark.png" style="width: 50%">
                    <p>bookmarkする投稿を格納</p>
                </li>
                <li>
                    <div>post_chatテーブル</div>
                    <img src="./images/db_images/post_chat.png" style="width: 50%">
                    <p>各投稿毎にエントリーしたユーザーとのチャット履歴を格納</p>
                </li>
                <li>
                    <div>post_entryテーブル</div>
                    <img src="./images/db_images/posts_entry.png" style="width: 50%">
                    <p>各投稿とそれにエントリーするユーザーを格納</p>
                </li>
                </ul>
            </div>
        </div>
        <h3>工夫した点</h3> 
        <ul>
            <li>なるべく、見ただけでわかるようにシンプルなUI設計にした。</li>
            <li>レスポンシブ対応できた</li>
        </ul>
        <h3>苦労した点・反省点</h3> 
        <ul>
            <li>個人開発掲メンバーを募集する掲示板というアイディアが微妙だった!</li>
            <li>AWSのセキュリティ、ロールの設定がうまくいかず時間がかかってしまった</li>
            <li>事前にしっかりとした仕様書を作っていなかった為思いつきで機能を追加していき、完成までの時間がかかってしまった→必要最低限の機能の洗い出しや、利用者数や層をあらかじめ推定しておき、適した実装をなるべく短期間で行えるようにする、どのくらいの期間で完成させるのかなどの目安も決めておく。</li>
            <li>コードを殴り書きしているところが多々あるため、後から機能の追加を行う際に自分でも何読んでるかわからなくなっていた→可読性、保守・運用、拡張性を意識したコーディングをおこなう</li>
            <li>実際に利用してもらうことを前提にした設計やテストができていない、またAWSのIAM周りの設定の理解が曖昧→上流から下流までの知識を身につけ、本番環境で耐えうる設計ができるようにする</li>
        </ul> 
        <h3>実装したかった機能</h3> 
        <ul>
            <li>Websocketなどを用いたEntryしてくれたユーザーとのリアルタイムなチャット</li>
            <li>より高度な検索機能</li>
            <li>もっと見やすいUIやUX</li>
            <li>ユーザーごとに最適化されたrecommend</li>
            <li>メールによるパスワードリセットやSNS認証</li>
        </ul> 
        <h3>感想</h3> 
        <p>今まで分担して開発を行うことが多く全体概要を深く理解せずとも実装できていたが課題を通して全体の流れを意識した開発を行うことで、各フェーズにシームレスな引き継ぎができるようにしておくことの重要性に気づけた。<br>
        また、主に技術選定時に、様々な技術についての知識がないことに気がつけた（AWSなど)<br>
        今までフレームワークの使用をなるべく控えていたが、使ってみると局所的に開発時間が大幅に短縮でき開発効率が上がったことが実感できたため、今後は積極的に導入していこうと思った。</p>
        </ul> 
    </div>
</div>
