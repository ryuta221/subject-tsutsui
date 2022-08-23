function profileImageUpload(file){
    // 選択した画像の登録
    const formData = new FormData();
    // 非同期更新
    let request = new XMLHttpRequest();
    // request.responseType = 'json';
    request.open('POST', 'upload_avator.php', true);
    formData.append('avator', file.files[0]);
    request.send(formData);

    request.onreadystatechange = function() {
        if (request.readyState == 4){
            if(request.status == 200){
                let data = request.responseText;
                console.log(data);
            }else {
                console.log("!!!!");
            }
        }
    }

    // 画像を保存してすぐ表示
    const reader = new FileReader();
    reader.onload = function(e){
        const image = document.getElementById('view').src = reader.result;
        const nav_image = document.getElementById('header_nav_profile_img').src = reader.result; // id名は../mylib/header_nav.php内にある
    }
    reader.readAsDataURL(file.files[0]);
}
