// 経費登録モーダルを開く
$("[id=expense_register_modal_open]").on("click",function(){
    const modal = document.getElementById('expense_register_modal');
    modal.classList.remove('hidden');
});

// 経費登録モーダルを閉じる
$("[class^=expense_register_modal_close]").on("click",function(){
    const modal = document.getElementById('expense_register_modal');
    modal.classList.add('hidden');
});