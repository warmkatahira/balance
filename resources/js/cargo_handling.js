// 荷役登録モーダルを開く
$("[id=cargo_handling_register_modal_open]").on("click",function(){
    const modal = document.getElementById('cargo_handling_register_modal');
    modal.classList.remove('hidden');
});

// 荷役登録モーダルを閉じる
$("[class^=cargo_handling_register_modal_close]").on("click",function(){
    const modal = document.getElementById('cargo_handling_register_modal');
    modal.classList.add('hidden');
});

// 荷役登録ボタンが押下されたら
$("[id=cargo_handling_register]").on("click",function(){
    // 登録情報の要素を取得
    const cargo_handling_name = document.getElementById('cargo_handling_name');
    try {
        // 荷役名が入力されているかチェック
        if (!cargo_handling_name.value){
            throw new Error('荷役が入力されていません。');
        }
        // 既に存在する荷役名ではないかチェック
        if (document.querySelector('#tr_' + cargo_handling_name.value) !== null) {
            throw new Error('既に存在する荷役名です。');
        }
        const cargo_handling_register_form = document.getElementById('cargo_handling_register_form');
        const result = window.confirm('荷役を追加しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            cargo_handling_register_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});

// 荷役を削除
$(document).on("click", ".cargo_handling_delete", function () {
    const result = window.confirm('荷役マスタを削除しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == false) {
        return false;
    }
});