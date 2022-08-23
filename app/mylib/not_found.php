<?php
// 404ページで表示する画像
session_start();

require_once("header_nav.php");
require_once("../public/html/header.html");
?>
<body>
    <div>
        <div>
            <img src="./images/not_found_image.png" style="width:100%">
        </div>
    </div>
</body>
<?php
require_once('../public/html/footer.html');
?>