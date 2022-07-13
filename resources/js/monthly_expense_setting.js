// 月額経費設定登録モーダルを開く
$("[id=monthly_expense_setting_register_modal_open]").on("click",function(){
    const modal = document.getElementById('monthly_expense_setting_register_modal');
    modal.classList.remove('hidden');
});

// 月額経費設定登録モーダルを閉じる
$("[class^=monthly_expense_setting_register_modal_close]").on("click",function(){
    const modal = document.getElementById('monthly_expense_setting_register_modal');
    modal.classList.add('hidden');
});

// 削除ボタンが押下されたら
$("[class^=monthly_expense_setting_delete]").on("click",function(){
    const result = window.confirm('削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});