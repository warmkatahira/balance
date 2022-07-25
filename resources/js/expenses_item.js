// 経費項目登録モーダルを開く
$("[id=expenses_item_register_modal_open]").on("click",function(){
    const modal = document.getElementById('expenses_item_register_modal');
    modal.classList.remove('hidden');
});

// 経費項目登録モーダルを閉じる
$("[class^=expenses_item_register_modal_close]").on("click",function(){
    const modal = document.getElementById('expenses_item_register_modal');
    modal.classList.add('hidden');
});