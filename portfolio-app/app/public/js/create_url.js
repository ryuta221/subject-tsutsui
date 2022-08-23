function createUrl() {
    // sortするurl作ってリダイレクト
    const order = document.getElementById('order').value;
    console.log(order);
    
    let url = new URL(window.location.href);

    let params = url.searchParams;
    const q = params.get('q') ?? '';

    if(order == 'asc') {
        window.location = url.origin + url.pathname + '?q=' + q + '&sort=' + order;
    }else {
        window.location = url.origin + url.pathname + '?q=' + q + '&sort=' + order;
    }
}