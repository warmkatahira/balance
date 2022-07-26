// 保存ボタンが押下されたら
$("[id=user_save]").on("click",function(){
    const user_update_form = document.getElementById('user_update_form');
    try {
        const result = window.confirm('ユーザーマスタを更新しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            user_update_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});