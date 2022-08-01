// 月額売上設定登録モーダルを開く
$("[id=monthly_sales_setting_register_modal_open]").on("click",function(){
    const modal = document.getElementById('monthly_sales_setting_register_modal');
    modal.classList.remove('hidden');
});

// 月額売上設定登録モーダルを閉じる
$("[class^=monthly_sales_setting_register_modal_close]").on("click",function(){
    const modal = document.getElementById('monthly_sales_setting_register_modal');
    modal.classList.add('hidden');
});

// 月額売上設定登録ボタンが押下されたら
$("[id=monthly_sales_setting_register_enter]").on("click",function(){
    // 登録情報の要素を取得
    const sales_item_id = document.getElementById('sales_item_id');
    const sales_amount = document.getElementById('sales_amount');
    console.log(sales_item_id.value);
    try {
        // 売上が選択されているかチェック
        if (sales_item_id.value == 0){
            throw new Error('売上が選択されていません。');
        }
        // 経費金額が正しいかチェック
        if (!sales_amount.value || isNaN(sales_amount.value)){
            throw new Error('売上金額が正しくありません。');
        }
        // 既に存在する売上ではないかチェック
        if (document.querySelector('#tr_' + sales_item_id.value) !== null) {
            throw new Error('既に存在する売上です。');
        }
        const monthly_sales_setting_register_form = document.getElementById('monthly_sales_setting_register_form');
        const result = window.confirm('月額売上設定を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            monthly_sales_setting_register_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// 削除ボタンが押下されたら
$("[class^=monthly_sales_setting_delete]").on("click",function(){
    const result = window.confirm('削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});