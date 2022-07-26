// 配送方法登録モーダルを開く
$("[id=shipping_method_register_modal_open]").on("click",function(){
    const modal = document.getElementById('shipping_method_register_modal');
    modal.classList.remove('hidden');
});

// 配送方法登録モーダルを閉じる
$("[class^=shipping_method_register_modal_close]").on("click",function(){
    const modal = document.getElementById('shipping_method_register_modal');
    modal.classList.add('hidden');
});

// 配送方法登録ボタンが押下されたら
$("[id=shipping_method_register_enter]").on("click",function(){
    const shipping_company = document.getElementById('shipping_company');
    const shipping_method = document.getElementById('shipping_method');
    const shipping_method_register_form = document.getElementById('shipping_method_register_form');
    try {
        // 運送会社が入力されているか
        if (shipping_company.value == 0) {
            throw new Error('運送会社を入力して下さい。');
        }
        // 配送方法が入力されているか
        if(shipping_method.value == ''){
            throw new Error('配送方法を入力して下さい。');
        }
        const result = window.confirm('配送方法登録を実行しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            shipping_method_register_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});