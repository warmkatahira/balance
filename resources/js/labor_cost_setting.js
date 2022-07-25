// 人件費設定登録モーダルを開く
$("[id=labor_cost_setting_register_modal_open]").on("click",function(){
    const modal = document.getElementById('labor_cost_setting_register_modal');
    modal.classList.remove('hidden');
});

// 人件費設定登録モーダルを閉じる
$("[class^=labor_cost_setting_register_modal_close]").on("click",function(){
    const modal = document.getElementById('labor_cost_setting_register_modal');
    modal.classList.add('hidden');
});

// 保存ボタンが押下されたら
$("[id=labor_cost_setting_save]").on("click",function(){
    const labor_cost_setting_form = document.getElementById('labor_cost_setting_form');
    try {
        // 荷役単価を取得して、正常な値であるかチェック
        const hourly_wages = document.querySelectorAll('.hourly_wage');
        hourly_wages.forEach(hourly_wage => {
            // 時給が正しいかチェック
            if (!hourly_wage.value || isNaN(hourly_wage.value)){
                throw new Error('時給が正しくありません。');
            }
        });
        const result = window.confirm('設定を保存しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            labor_cost_setting_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});