// 売上計画登録モーダルを開く
$("[id=sales_plan_register_modal_open]").on("click",function(){
    const modal = document.getElementById('sales_plan_register_modal');
    modal.classList.remove('hidden');
});

// 売上計画登録モーダルを閉じる
$("[class^=sales_plan_register_modal_close]").on("click",function(){
    const modal = document.getElementById('sales_plan_register_modal');
    modal.classList.add('hidden');
});

// 売上計画登録ボタンが押下されたら
$("[id=sales_plan_register_enter]").on("click",function(){
    // 登録情報の要素を取得
    const plan_date = document.getElementById('plan_date');
    const sales_plan_amount = document.getElementById('sales_plan_amount');
    try {
        // 計画年月が選択されているかチェック
        if (plan_date.value == 0){
            throw new Error('計画年月が選択されていません。');
        }
        // 売上計画金額が正しいかチェック
        if(!sales_plan_amount.value || !sales_plan_amount.value){
            throw new Error('売上計画金額が正しくありません。');
        }
        const sales_plan_register_form = document.getElementById('sales_plan_register_form');
        const result = window.confirm('売上計画設定を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            sales_plan_register_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// 削除ボタンが押下されたら
$("[class^=sales_plan_delete]").on("click",function(){
    const result = window.confirm('削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        form.submit();
    }else {
        return false;
    }
});