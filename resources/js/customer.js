// 荷主登録モーダルを開く
$("[id=customer_register_modal_open]").on("click",function(){
    const modal = document.getElementById('customer_register_modal');
    modal.classList.remove('hidden');
});

// 荷主登録モーダルを閉じる
$("[class^=customer_register_modal_close]").on("click",function(){
    const modal = document.getElementById('customer_register_modal');
    modal.classList.add('hidden');
});

// 荷役設定登録モーダルを開く
$("[id=cargo_handling_register_modal_open]").on("click",function(){
    const modal = document.getElementById('cargo_handling_register_modal');
    modal.classList.remove('hidden');
});

// 荷役設定登録モーダルを閉じる
$("[class^=cargo_handling_register_modal_close]").on("click",function(){
    const modal = document.getElementById('cargo_handling_register_modal');
    modal.classList.add('hidden');
});

// 荷役設定登録ボタンが押下されたら
$("[id=cargo_handling_register]").on("click",function(){
    // 登録情報の要素を取得
    const cargo_handling_select = document.getElementById('cargo_handling_id');
    const cargo_handling_unit_price = document.getElementById('cargo_handling_unit_price');
    const balance_register_default_disp = document.getElementById('balance_register_default_disp');
    // 作成した要素の追加先を取得
    const cargo_handling_setting_body = document.getElementById('cargo_handling_setting_body');

    try {
        // 荷役が選択されているかチェック
        if (cargo_handling_select.value == 0){
            throw new Error('荷役が選択されていません。');
        }
        // 既に存在する荷役ではないかチェック
        if (document.querySelector('#tr_' + cargo_handling_select.value) !== null) {
            throw new Error('既に存在する荷役です。');
        }
        // 荷役単価が入力されているかチェック
        if (!cargo_handling_unit_price.value){
            throw new Error('荷役単価が入力されていません。');
        }
        // 荷役単価が数値であるかチェック
        if (isNaN(cargo_handling_unit_price.value)){
            throw new Error('荷役単価が正しくありません。');
        }
        // trタグを作成
        const cargo_handling_tr = document.createElement('tr');
        cargo_handling_tr.id = 'tr_' + cargo_handling_select.value;
        // 荷役名のtdタグを作成
        const cargo_handling_name_td = document.createElement('td');
        cargo_handling_name_td.innerHTML = cargo_handling_select.options[cargo_handling_select.selectedIndex].innerHTML;
        cargo_handling_name_td.classList.add('p-1', 'px-2', 'border');
        // 荷役単価のtdタグを作成
        const cargo_handling_unit_price_td = document.createElement('td');
        cargo_handling_unit_price_td.classList.add('p-1', 'px-2', 'border', 'text-right');
        // 荷役単価のinputタグを作成
        const cargo_handling_unit_price_input = document.createElement('input');
        cargo_handling_unit_price_input.type = 'tel';
        cargo_handling_unit_price_input.name = 'cargo_handling_unit_price[' + cargo_handling_select.value + ']';
        cargo_handling_unit_price_input.classList.add('text-sm', 'text-right', 'w-3/4', 'bg-gray-100', 'cargo_handling_unit_price');
        cargo_handling_unit_price_input.value = cargo_handling_unit_price.value;
        // 荷役単価のtdタグにinputタグを追加
        cargo_handling_unit_price_td.append(cargo_handling_unit_price_input);
        // 収支登録初期表示のtdタグを作成
        const balance_register_default_disp_td = document.createElement('td');
        balance_register_default_disp_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 収支登録初期表示のinputタグを作成
        const balance_register_default_disp_input = document.createElement('input');
        balance_register_default_disp_input.type = 'checkbox';
        balance_register_default_disp_input.name = 'balance_register_default_disp[' + cargo_handling_select.value + ']';
        balance_register_default_disp_input.classList.add('text-sm', 'bg-gray-100');
        balance_register_default_disp_input.checked = balance_register_default_disp.checked;
        // 収支登録初期表示のtdタグにinputタグを追加
        balance_register_default_disp_td.append(balance_register_default_disp_input);
        // 削除のtdタグを作成
        const cargo_handling_delete_btn_td = document.createElement('td');
        cargo_handling_delete_btn_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 削除のbuttonタグを作成
        const cargo_handling_delete_btn = document.createElement('button');
        cargo_handling_delete_btn.type = 'button';
        cargo_handling_delete_btn.id = cargo_handling_select.value;
        cargo_handling_delete_btn.classList.add('cargo_handling_setting_delete', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'p-1', 'text-xs');
        cargo_handling_delete_btn.innerHTML = '削除';
        // 削除のtdタグにbuttonタグを追加
        cargo_handling_delete_btn_td.append(cargo_handling_delete_btn);
        // 全てのタグをtrタグに追加
        cargo_handling_tr.append(cargo_handling_name_td , cargo_handling_unit_price_td, balance_register_default_disp_td, cargo_handling_delete_btn_td);
        // trタグをtbodyタグに追加
        cargo_handling_setting_body.append(cargo_handling_tr);
    } catch (e) {
        alert(e.message);
    }
});

// 荷役設定を削除
$(document).on("click", ".cargo_handling_setting_delete", function () {
    const delete_target_id = $(this).attr('id');
    const delete_target = document.getElementById('tr_' + delete_target_id);
    delete_target.remove();
});

// 保存ボタンが押下されたら
$("[id=cargo_handling_setting_save]").on("click",function(){
    const cargo_handling_setting_form = document.getElementById('cargo_handling_setting_form');
    try {
        // 荷役単価を取得して、正常な値であるかチェック
        const cargo_handling_unit_prices = document.querySelectorAll('.cargo_handling_unit_price');
        cargo_handling_unit_prices.forEach(cargo_handling_unit_price => {
            // nullでないかチェック
            if (!cargo_handling_unit_price.value){
                throw new Error('荷役単価が入力されていません。');
            }
            // 数値であるかチェック
            if (isNaN(cargo_handling_unit_price.value)){
                throw new Error('荷役単価が正しくありません。');
            }
        });
        const result = window.confirm('荷役設定を保存しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            cargo_handling_setting_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});