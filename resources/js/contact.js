// 問い合わせボタンが押下されたら
$("[id=contact_confirm]").on("click",function(){
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const contact_form = document.getElementById('contact_form');
    try {
        // 件名が入力されているか
        if (title.value == '') {
            throw new Error('件名を入力して下さい。');
        }
        // 問い合わせ内容が入力されているか
        if(content.value == ''){
            throw new Error('問い合わせ内容を入力して下さい。');
        }
        const result = window.confirm('問い合わせを行いますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            contact_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});