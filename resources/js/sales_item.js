// 売上項目登録モーダルを開く
$("[id=sales_item_register_modal_open]").on("click",function(){
    const modal = document.getElementById('sales_item_register_modal');
    modal.classList.remove('hidden');
});

// 売上項目登録モーダルを閉じる
$("[class^=sales_item_register_modal_close]").on("click",function(){
    const modal = document.getElementById('sales_item_register_modal');
    modal.classList.add('hidden');
});