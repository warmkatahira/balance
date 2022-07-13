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
    const cargo_handling_note = document.getElementById('cargo_handling_note');
    // 作成した要素の追加先を取得
    const cargo_handling_body = document.getElementById('cargo_handling_body');

    try {
        // 荷役名が入力されているかチェック
        if (!cargo_handling_name.value){
            throw new Error('荷役が入力されていません。');
        }
        // 既に存在する荷役名ではないかチェック
        if (document.querySelector('#tr_' + cargo_handling_name.value) !== null) {
            throw new Error('既に存在する荷役名です。');
        }
        // trタグを作成
        const cargo_handling_tr = document.createElement('tr');
        cargo_handling_tr.id = 'tr_' + cargo_handling_name.value;
        // 荷役名のtdタグを作成
        const cargo_handling_name_td = document.createElement('td');
        cargo_handling_name_td.classList.add('p-1', 'px-2', 'border');
        // 荷役名のinputタグを作成
        const cargo_handling_name_input = document.createElement('input');
        cargo_handling_name_input.name = 'cargo_handling_name_add[]';
        cargo_handling_name_input.value = cargo_handling_name.value;
        cargo_handling_name_input.readOnly = true;
        // 荷役名のtdタグにinputタグを追加
        cargo_handling_name_td.append(cargo_handling_name_input);
        // 荷役備考のtdタグを作成
        const cargo_handling_note_td = document.createElement('td');
        cargo_handling_note_td.classList.add('p-1', 'px-2', 'border');
        // 荷役備考のinputタグを作成
        const cargo_handling_note_input = document.createElement('input');
        cargo_handling_note_input.name = 'cargo_handling_note_add[]';
        cargo_handling_note_input.value = cargo_handling_note.value;
        cargo_handling_note_input.readonly = true;
        // 荷役備考のtdタグにinputタグを追加
        cargo_handling_note_td.append(cargo_handling_note_input);
        // 削除のtdタグを作成
        const cargo_handling_delete_btn_td = document.createElement('td');
        cargo_handling_delete_btn_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 削除のbuttonタグを作成
        const cargo_handling_delete_btn = document.createElement('button');
        cargo_handling_delete_btn.type = 'button';
        cargo_handling_delete_btn.id = cargo_handling_name.value;
        cargo_handling_delete_btn.classList.add('cargo_handling_delete', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'p-1', 'text-xs');
        cargo_handling_delete_btn.innerHTML = '削除';
        // 削除のtdタグにbuttonタグを追加
        cargo_handling_delete_btn_td.append(cargo_handling_delete_btn);
        // 全てのタグをtrタグに追加
        cargo_handling_tr.append(cargo_handling_name_td , cargo_handling_note_td, cargo_handling_delete_btn_td);
        // trタグをtbodyタグに追加
        cargo_handling_body.append(cargo_handling_tr);
    } catch (e) {
        alert(e.message);
    }
});

// 荷役を削除
$(document).on("click", ".cargo_handling_delete", function () {
    const delete_target_id = $(this).attr('id');
    const delete_target = document.getElementById('tr_' + delete_target_id);
    delete_target.remove();
});

// 保存ボタンが押下されたら
$("[id=cargo_handling_save]").on("click",function(){
    const cargo_handling_form = document.getElementById('cargo_handling_form');
    try {
        const result = window.confirm('荷役マスタを保存しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            cargo_handling_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});