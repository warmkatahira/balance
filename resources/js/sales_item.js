// 売上項目登録モーダルを開く
$("[id=sales_item_register_modal_open]").on("click",function(){
    const modal = document.getElementById('sales_item_register_modal');
    modal.classList.remove('hidden');
});

// 売上項目登録モーダルを閉じる
$("[class^=sales_item_register_modal_close]").on("click",function(){
    const modal = document.getElementById('sales_item_register_modal');
    modal.classList.add('hidden');
});

// 登録ボタンが押下されたら
$("[id=sales_item_register_enter]").on("click",function(){
    // 登録情報の要素を取得
    const sales_item_name = document.getElementById('sales_item_name');
    try {
        // 項目名が入力されているかチェック
        if (!sales_item_name.value){
            throw new Error('項目名が入力されていません。');
        }
        // 既に存在する項目名ではないかチェック
        if (document.querySelector('#tr_' + sales_item_name.value) !== null) {
            throw new Error('既に存在する項目名です。');
        }
        const sales_item_register_form = document.getElementById('sales_item_register_form');
        const result = window.confirm('売上項目を追加しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            sales_item_register_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});

// 項目を削除
$(document).on("click", ".sales_item_delete", function () {
    const result = window.confirm('売上項目マスタを削除しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});