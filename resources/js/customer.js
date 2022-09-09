var change_flg = false;         // フォームの変更を判定する変数

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

// 荷主登録ボタンが押下されたら
$("[id=customer_register_enter]").on("click",function(){
    const customer_register_form = document.getElementById('customer_register_form');
    customer_base_validation(customer_register_form, '荷主登録を実行しますか？');
});

// 基本設定の保存ボタンが押下されたら
$("[id=customer_base_info_save]").on("click",function(){
    const customer_base_info_form = document.getElementById('customer_base_info_form');
    customer_base_validation(customer_base_info_form, '設定を保存しますか？');
});

// バリデーションと処理の実行確認
function customer_base_validation(form, msg){
    const base_select = document.getElementById('base_id');
    const customer_name = document.getElementById('customer_name');
    const monthly_storage_fee = document.getElementById('monthly_storage_fee');
    const working_days = document.getElementById('working_days');
    try {
        // 拠点が選択されているか
        if (base_select.value == 0) {
            throw new Error('拠点を選択して下さい。');
        }
        // 荷主名が入力されているか
        if(customer_name.value == ''){
            throw new Error('荷主名が入力されていません。');
        }
        // 月間保管料の入力が正しいか
        if(monthly_storage_fee.value == '' || isNaN(monthly_storage_fee.value)){
            throw new Error('月間保管料が正しくありません。');
        }
        // 稼働日数の入力が正しいか
        if(working_days.value == '' || isNaN(working_days.value)){
            throw new Error('稼働日数が正しくありません。');
        }
        const result = window.confirm(msg);
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            // ここでfalseに戻しておかないとダイアログが表示されてしまう
            change_flg = false;
            form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
}

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
    const cargo_handling_note = document.getElementById('cargo_handling_note');
    // 作成した要素の追加先を取得
    const cargo_handling_setting_body = document.getElementById('cargo_handling_setting_body');

    try {
        // 荷役が選択されているかチェック
        if (cargo_handling_select.value == 0){
            throw new Error('荷役が選択されていません。');
        }
        // 荷役単価が正しいかチェック
        if (!cargo_handling_unit_price.value || isNaN(cargo_handling_unit_price.value)){
            throw new Error('荷役単価が正しくありません。');
        }
        // trタグを作成
        const cargo_handling_tr = document.createElement('tr');
        cargo_handling_tr.id = 'tr_' + cargo_handling_select.value + '-' + cargo_handling_unit_price.value + '-' + cargo_handling_note.value + '-0-add';
        // 荷役名のtdタグを作成
        const cargo_handling_name_td = document.createElement('td');
        cargo_handling_name_td.innerHTML = cargo_handling_select.options[cargo_handling_select.selectedIndex].innerHTML;
        cargo_handling_name_td.classList.add('p-1', 'px-2', 'border');
        // 荷役備考のtdタグを作成
        const cargo_handling_note_td = document.createElement('td');
        cargo_handling_note_td.classList.add('p-1', 'px-2', 'border');
        // 荷役備考のinputタグを作成
        const cargo_handling_note_input = document.createElement('input');
        cargo_handling_note_input.type = 'text';
        cargo_handling_note_input.name = 'cargo_handling_note[' + cargo_handling_select.value + '-' + cargo_handling_unit_price.value + '-' + cargo_handling_note.value + '-0-add' + ']';
        cargo_handling_note_input.classList.add('text-sm', 'w-full', 'bg-gray-100', 'cargo_handling_note');
        cargo_handling_note_input.value = cargo_handling_note.value;
        // 荷役備考のtdタグにinputタグを追加
        cargo_handling_note_td.append(cargo_handling_note_input);
        // 荷役単価のtdタグを作成
        const cargo_handling_unit_price_td = document.createElement('td');
        cargo_handling_unit_price_td.classList.add('p-1', 'px-2', 'border', 'text-right');
        // 荷役単価のinputタグを作成
        const cargo_handling_unit_price_input = document.createElement('input');
        cargo_handling_unit_price_input.name = 'cargo_handling_unit_price[' + cargo_handling_select.value + '-' + cargo_handling_unit_price.value + '-' + cargo_handling_note.value + '-0-add' + ']';
        cargo_handling_unit_price_input.classList.add('text-sm', 'text-right', 'w-3/4', 'cargo_handling_unit_price');
        cargo_handling_unit_price_input.value = cargo_handling_unit_price.value;
        cargo_handling_unit_price_input.readOnly
        // spanタグを作成
        const cargo_handling_unit_price_span = document.createElement('span');
        cargo_handling_unit_price_span.classList.add('mt-5', 'ml-1');
        cargo_handling_unit_price_span.innerHTML = '円';
        // 荷役単価のtdタグにinputタグを追加
        cargo_handling_unit_price_td.append(cargo_handling_unit_price_input, cargo_handling_unit_price_span);
        // 収支登録初期表示のtdタグを作成
        const balance_register_default_disp_td = document.createElement('td');
        balance_register_default_disp_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 収支登録初期表示のinputタグを作成
        const balance_register_default_disp_input = document.createElement('input');
        balance_register_default_disp_input.type = 'checkbox';
        balance_register_default_disp_input.name = 'balance_register_default_disp[' + cargo_handling_select.value + '-' + cargo_handling_unit_price.value + '-' + cargo_handling_note.value + '-0-add' + ']';
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
        cargo_handling_delete_btn.id = cargo_handling_select.value + '-' + cargo_handling_unit_price.value + '-' + cargo_handling_note.value + '-0-add';
        cargo_handling_delete_btn.classList.add('cargo_handling_setting_delete', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'p-1', 'text-xs');
        cargo_handling_delete_btn.innerHTML = '削除';
        // 削除のtdタグにbuttonタグを追加
        cargo_handling_delete_btn_td.append(cargo_handling_delete_btn);
        // 全てのタグをtrタグに追加
        cargo_handling_tr.append(cargo_handling_name_td, cargo_handling_note_td, cargo_handling_unit_price_td, balance_register_default_disp_td, cargo_handling_delete_btn_td);
        // trタグをtbodyタグに追加
        cargo_handling_setting_body.append(cargo_handling_tr);
        // change_flgをtrueに変更
        change_flg = true;
    } catch (e) {
        alert(e.message);
    }
});

// 荷役設定保存ボタンが押下されたら
$("[id=cargo_handling_setting_save]").on("click",function(){
    const cargo_handling_setting_form = document.getElementById('cargo_handling_setting_form');
    try {
        // 荷役単価を取得して、正常な値であるかチェック
        const cargo_handling_unit_prices = document.querySelectorAll('.cargo_handling_unit_price');
        cargo_handling_unit_prices.forEach(cargo_handling_unit_price => {
            // 荷役単価が正しいかチェック
            if (!cargo_handling_unit_price.value || isNaN(cargo_handling_unit_price.value)){
                throw new Error('荷役単価が正しくありません。');
            }
        });
        const result = window.confirm('設定を保存しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            // ここでfalseに戻しておかないとダイアログが表示されてしまう
            change_flg = false;
            cargo_handling_setting_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});

// 荷役設定を削除する
$(document).on("click", ".cargo_handling_setting_delete", function () {
    // DOM要素を削除
    const delete_target_id = $(this).attr('id');
    const delete_target = document.getElementById('tr_' + delete_target_id);
    delete_target.remove();

    // 削除対象のidをスプリット
    const split_id = delete_target_id.split('-');

    // 荷役単価のinputタグを作成
    const cargo_handling_unit_price_input = document.createElement('input');
    cargo_handling_unit_price_input.type = 'hidden';
    cargo_handling_unit_price_input.name = 'cargo_handling_unit_price[---' + split_id[3] + '-del' + ']';

    // inputタグをtbodyタグに追加
    cargo_handling_setting_body.append(cargo_handling_unit_price_input);

    // change_flgをtrueに変更
    change_flg = true;
});

// 配送方法設定登録モーダルを開く
$("[id=shipping_method_register_modal_open]").on("click",function(){
    const modal = document.getElementById('shipping_method_register_modal');
    modal.classList.remove('hidden');
});

// 配送方法設定登録モーダルを閉じる
$("[class^=shipping_method_register_modal_close]").on("click",function(){
    const modal = document.getElementById('shipping_method_register_modal');
    modal.classList.add('hidden');
});

// 配送方法設定登録ボタンが押下されたら
$("[id=shipping_method_register]").on("click",function(){
    // 登録情報の要素を取得
    const shipping_method_select = document.getElementById('shipping_method_id');
    const shipping_method_note = document.getElementById('shipping_method_note');
    const fare_unit_price = document.getElementById('fare_unit_price');
    const fare_expense = document.getElementById('fare_expense');
    // 作成した要素の追加先を取得
    const shipping_method_setting_body = document.getElementById('shipping_method_setting_body');
    try {
        // 配送方法が選択されているかチェック
        if (shipping_method_select.value == 0){
            throw new Error('配送方法が選択されていません。');
        }
        // 運賃単価が正しいかチェック
        if (!fare_unit_price.value || isNaN(fare_unit_price.value)){
            throw new Error('運賃単価が正しくありません。');
        }
        // 運賃経費が正しいかチェック
        if (!fare_expense.value || isNaN(fare_expense.value)){
            throw new Error('経費単価が正しくありません。');
        }
        // プルダウンの値をスプリットし、運送会社と配送方法を取得
        const select_value = shipping_method_select.options[shipping_method_select.selectedIndex].innerHTML.split('【');
        const shipping_company = select_value[0];
        const shipping_method = select_value[1].replace('】', '');
        // trタグを作成
        const shipping_method_tr = document.createElement('tr');
        shipping_method_tr.id = 'tr_' + shipping_method_select.value + '-' + shipping_method_note.value + '-' + fare_unit_price.value + '-' + fare_expense.value + '-0-add';
        // 運送会社のtdタグを作成
        const shipping_company_td = document.createElement('td');
        shipping_company_td.innerHTML = shipping_company;
        shipping_company_td.classList.add('p-1', 'px-2', 'border');
        // 配送方法のtdタグを作成
        const shipping_method_td = document.createElement('td');
        shipping_method_td.innerHTML = shipping_method;
        shipping_method_td.classList.add('p-1', 'px-2', 'border');
        // 配送方法備考のtdタグを作成
        const shipping_method_note_td = document.createElement('td');
        shipping_method_note_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 配送方法備考のinputタグを作成
        const shipping_method_note_input = document.createElement('input');
        shipping_method_note_input.type = 'text';
        shipping_method_note_input.name = 'shipping_method_note[' + shipping_method_select.value + '-' + shipping_method_note.value + '-' + fare_unit_price.value + '-' + fare_expense.value + '-0-add' + ']';
        shipping_method_note_input.classList.add('text-sm', 'bg-gray-100', 'w-full');
        shipping_method_note_input.value = shipping_method_note.value;
        // 配送方法備考のtdタグにinputタグを追加
        shipping_method_note_td.append(shipping_method_note_input);
        // 運賃単価のtdタグを作成
        const fare_unit_price_td = document.createElement('td');
        fare_unit_price_td.classList.add('p-1', 'px-2', 'border', 'text-right');
        // 運賃単価のinputタグを作成
        const fare_unit_price_input = document.createElement('input');
        fare_unit_price_input.type = 'tel';
        fare_unit_price_input.name = 'fare_unit_price[' + shipping_method_select.value + '-' + shipping_method_note.value + '-' + fare_unit_price.value + '-' + fare_expense.value + '-0-add' + ']';
        fare_unit_price_input.classList.add('text-sm', 'text-right', 'w-3/4', 'bg-gray-100', 'fare_unit_price');
        fare_unit_price_input.value = fare_unit_price.value;
        // spanタグを作成
        const fare_unit_price_span = document.createElement('span');
        fare_unit_price_span.classList.add('mt-5', 'ml-1');
        fare_unit_price_span.innerHTML = '円';
        // 運賃単価のtdタグにinputタグを追加
        fare_unit_price_td.append(fare_unit_price_input, fare_unit_price_span);
        // 経費単価のtdタグを作成
        const fare_expense_td = document.createElement('td');
        fare_expense_td.classList.add('p-1', 'px-2', 'border', 'text-right');
        // 経費単価のinputタグを作成
        const fare_expense_input = document.createElement('input');
        fare_expense_input.type = 'tel';
        fare_expense_input.name = 'fare_expense[' + shipping_method_select.value + '-' + shipping_method_note.value + '-' + fare_unit_price.value + '-' + fare_expense.value + '-0-add' + ']';
        fare_expense_input.classList.add('text-sm', 'text-right', 'w-3/4', 'bg-gray-100', 'fare_expense');
        fare_expense_input.value = fare_expense.value;
        // spanタグを作成
        const fare_expense_span = document.createElement('span');
        fare_expense_span.classList.add('mt-5', 'ml-1');
        fare_expense_span.innerHTML = '円';
        // 経費単価のtdタグにinputタグを追加
        fare_expense_td.append(fare_expense_input, fare_expense_span);
        // 削除のtdタグを作成
        const shipping_method_delete_btn_td = document.createElement('td');
        shipping_method_delete_btn_td.classList.add('p-1', 'px-2', 'border', 'text-center');
        // 削除のbuttonタグを作成
        const shipping_method_delete_btn = document.createElement('button');
        shipping_method_delete_btn.type = 'button';
        shipping_method_delete_btn.id = shipping_method_select.value + '-' + shipping_method_note.value + '-' + fare_unit_price.value + '-' + fare_expense.value + '-0-add';
        shipping_method_delete_btn.classList.add('shipping_method_setting_delete', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'p-1', 'text-xs');
        shipping_method_delete_btn.innerHTML = '削除';
        // 削除のtdタグにbuttonタグを追加
        shipping_method_delete_btn_td.append(shipping_method_delete_btn);
        // 全てのタグをtrタグに追加
        shipping_method_tr.append(shipping_company_td , shipping_method_td, shipping_method_note_td, fare_unit_price_td, fare_expense_td, shipping_method_delete_btn_td);
        // trタグをtbodyタグに追加
        shipping_method_setting_body.append(shipping_method_tr);
        // change_flgをtrueに変更
        change_flg = true;
    } catch (e) {
        alert(e.message);
    }
});

// 配送方法設定を削除
$(document).on("click", ".shipping_method_setting_delete", function () {
    // DOM要素を削除
    const delete_target_id = $(this).attr('id');
    const delete_target = document.getElementById('tr_' + delete_target_id);
    delete_target.remove();

    // 削除対象のidをスプリット
    const split_id = delete_target_id.split('-');

    // 運賃単価のinputタグを作成
    const fare_unit_price_input = document.createElement('input');
    fare_unit_price_input.type = 'hidden';
    fare_unit_price_input.name = 'fare_unit_price[----' + split_id[4] + '-del' + ']';

    // inputタグをtbodyタグに追加
    shipping_method_setting_body.append(fare_unit_price_input);

    // change_flgをtrueに変更
    change_flg = true;
});

// 配送方法設定保存ボタンが押下されたら
$("[id=shipping_method_setting_save]").on("click",function(){
    const shipping_method_setting_form = document.getElementById('shipping_method_setting_form');
    try {
        // 運賃単価を取得して、正常な値であるかチェック
        const fare_unit_prices = document.querySelectorAll('.fare_unit_price');
        fare_unit_prices.forEach(fare_unit_price => {
            // 運賃単価が正しいかチェック
            if (!fare_unit_price.value || isNaN(fare_unit_price.value)){
                throw new Error('運賃単価が正しくありません。');
            }
        });
        // 経費単価を取得して、正常な値であるかチェック
        const fare_expenses = document.querySelectorAll('.fare_expense');
        fare_expenses.forEach(fare_expense => {
            // 経費単価が正しいかチェック
            if (!fare_expense.value || isNaN(fare_expense.value)){
                throw new Error('経費単価が正しくありません。');
            }
        });
        const result = window.confirm('設定を保存しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            // ここでfalseに戻しておかないとダイアログが表示されてしまう
            change_flg = false;
            shipping_method_setting_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});

// 検索ボタンが押下されたら
$("[id=balance_list_search]").on("click",function(){
    // ここでfalseに戻しておかないとダイアログが表示されてしまう
    change_flg = false;
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
$("form").change(function(){
    // change_flgをtrueに変更
    change_flg = true;
});