var change_flg = false;         // フォームの変更を判定する変数

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
            // ここでfalseに戻しておかないとダイアログが表示されてしまう
            change_flg = false;
            labor_cost_setting_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});

// ページ遷移時に確認ダイアログの設定
window.addEventListener('beforeunload', function(e) {
    // 変更があったらダイアログを表示
    if( change_flg === true ) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// フォーム内の要素に変更があると発火
$("input").change(function(){
    // change_flgをtrueに変更
    change_flg = true;
});