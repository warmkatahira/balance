// 月額経費設定登録モーダルを開く
$("[id=monthly_expenses_setting_register_modal_open]").on("click",function(){
    const modal = document.getElementById('monthly_expenses_setting_register_modal');
    modal.classList.remove('hidden');
});

// 月額経費設定登録モーダルを閉じる
$("[class^=monthly_expenses_setting_register_modal_close]").on("click",function(){
    const modal = document.getElementById('monthly_expenses_setting_register_modal');
    modal.classList.add('hidden');
});

// 月額経費設定登録ボタンが押下されたら
$("[id=monthly_expenses_setting_register_enter]").on("click",function(){
    // 登録情報の要素を取得
    const expenses_item_id = document.getElementById('expenses_item_id');
    const setting_date_year = document.getElementById('setting_date_year');
    const setting_date_month = document.getElementById('setting_date_month');
    const expenses_amount = document.getElementById('expenses_amount');
    try {
        // 経費が選択されているかチェック
        if (expenses_item_id.value == 0){
            throw new Error('経費が選択されていません。');
        }
        // 設定年月が正しいかチェック
        if(!setting_date_year.value || !setting_date_month.value || isNaN(setting_date_year.value) || isNaN(setting_date_month.value)){
            throw new Error('設定年月が正しくありません。');
        }
        // 設定年月が正しいかチェック
        if(setting_date_year.value.length != 4 || setting_date_month.value.length != 2){
            throw new Error('設定年月が正しくありません。');
        }
        // 経費金額が正しいかチェック
        if (!expenses_amount.value || isNaN(expenses_amount.value)){
            throw new Error('経費金額が正しくありません。');
        }
        const monthly_expenses_setting_register_form = document.getElementById('monthly_expenses_setting_register_form');
        const result = window.confirm('月額経費設定を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            monthly_expenses_setting_register_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// 削除ボタンが押下されたら
$("[class^=monthly_expenses_setting_delete]").on("click",function(){
    const result = window.confirm('削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});