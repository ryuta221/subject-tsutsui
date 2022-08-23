function bookmark(event) {
    let req = new XMLHttpRequest();
    console.log("@@@@@@@@@@@@@@@@");
    // console.log(event.target.dataset.button);
    // console.log(event.target.dataset.userid);
    // console.log(event.target.dataset.postid);
    // console.log(event.target.textContent);
    // console.log(document.querySelector('data-post_id'));
    // console.log(document.querySelector('[data-user_id=' + event.target.dataset + ']'));
    
    req.open('POST', 'bookmark.php', true);
    req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
    
    let postId =  event.target.dataset.postid;
    let userId =  event.target.dataset.userid; // 投稿者のId
    // console.log(`${postId}****${userId}`);
    req.send(`postId=${postId}&userId=${userId}`);
    // console.log(document.getElementById('bookmark_button').textContent);
    // console.log(event.target.textContent);
    // console.log(document.getElementsByClassName(event.target.dataset.button).length);
    req.onreadystatechange = (e) => {
        if (req.readyState == 4) {// 通信の完了時
            if (req.status == 200){
                // console.log(req.responseText);
                var json = JSON.parse(req.responseText);
                // console.log(json);
                if(json.status == 'bookmarked'){
                    event.target.textContent = 'bookmark中';
                    // console.log(":");
                    // for(let j=0;j<document.getElementsByClassName(event.target.dataset.button).length;j++){
                    //     document.getElementsByClassName(event.target.dataset.button)[j].textContent = 'bookmark中';
                    // }
                    // document.getElementsByClassName(event.target.dataset.button).textContent = 'bookmark中';
                    // document.getElementById('bookmark_button').textContent = 'fbookmark中';
                }else if(json.status == 'unbookmark'){//on
                    // document.getElementById('bookmark_button').textContent = 'bookmarkする';
                    event.target.textContent = 'bookmarkする';
                    // document.getElementsByClassName(event.target.dataset.button).textContent = 'bookmarkする';
                    // for(let j=0;j<document.getElementsByClassName(event.target.dataset.button).length;j++){
                    //     document.getElementsByClassName(event.target.dataset.button)[j].textContent = 'bookmarkする';
                    // }
                }
            }else{
                console.log("通信失敗...");
            }
        }else{
            console.log("通信中..."); 
            console.log(e);
        }
    }
    
}