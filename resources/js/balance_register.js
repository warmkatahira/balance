const { data } = require("autoprefixer");

const fare_list_sales = document.getElementById('fare_list_sales');                         // 要素追加先のDivタグ
const fare_list_expenses = document.getElementById('fare_list_expenses');                   // 要素追加先のDivタグ
const shipping_method_select = document.getElementById('shipping_method_select');           // 配送方法選択のセレクトボックス
const customer_select = document.getElementById('customer_select');                         // 荷主選択のセレクトボックス
const cargo_handling_select = document.getElementById('cargo_handling_select');             // 荷役選択のセレクトボックス
const cargo_handling_list = document.getElementById('cargo_handling_list');                 // 要素追加先のDivタグ
const total_fare_sales_div = document.getElementById('total_fare_sales_div');               // 運賃関連の合計divタグ
const total_fare_expenses_div = document.getElementById('total_fare_expenses_div');         // 運賃関連の合計divタグ
const total_box_quantity_sales = document.getElementById('total_box_quantity_sales');       // 個口合計のpタグ
const total_fare_sales = document.getElementById('total_fare_sales');                       // 運賃金額合計のpタグ
const total_box_quantity_expenses = document.getElementById('total_box_quantity_expenses'); // 個口合計のpタグ
const total_fare_expenses = document.getElementById('total_fare_expenses');                 // 運賃金額合計のpタグ
const total_cargo_handling_div = document.getElementById('total_cargo_handling_div');       // 運賃関連の合計divタグ
const total_operation_quantity = document.getElementById('total_operation_quantity');       // 作業数合計のpタグ
const total_cargo_handling = document.getElementById('total_cargo_handling');               // 荷役金額合計のpタグ
const storage_fee = document.getElementById('storage_fee');                                 // 保管売上のinputタグ
const storage_expenses = document.getElementById('storage_expenses');                       // 保管経費のinputタグ
const total_storage_fee = document.getElementById('total_storage_fee');                     // 保管売上合計のpタグ
const total_storage_expenses = document.getElementById('total_storage_expenses');           // 保管経費合計のpタグ
const total_working_time = document.getElementById('total_working_time');                   // 労働時間合計のpタグ
const total_labor_costs = document.getElementById('total_labor_costs');                     // 人件費合計のpタグ
const other_expenses_select = document.getElementById('other_expenses_select');             // その他経費選択のセレクトボックス
const other_expenses_list = document.getElementById('other_expenses_list');                 // 要素追加先のDivタグ
const total_other_expenses_div = document.getElementById('total_other_expenses_div');       // その他経費の合計divタグ
const total_other_expenses_amount = document.getElementById('total_other_expenses_amount'); // その他経費金額合計のpタグ
const storage_fee_detail = document.getElementById('storage_fee_detail');                   // 保管売上の詳細を表示するpタグ
const storage_expenses_detail = document.getElementById('storage_expenses_detail');         // 保管経費の詳細を表示するpタグ
const other_sales_select = document.getElementById('other_sales_select');                   // その他売上選択のセレクトボックス
const other_sales_list = document.getElementById('other_sales_list');                       // 要素追加先のDivタグ
const total_other_sales_div = document.getElementById('total_other_sales_div');             // その他売上の合計divタグ
const total_other_sales_amount = document.getElementById('total_other_sales_amount');       // その他売上金額合計のpタグ
const balance_date = document.getElementById('balance_date');                               // 収支日のinputタグ

// 登録用のモーダルを開く
$("[id=openRegisterModal]").on("click",function(){
    modal = document.getElementById('register_modal');
    modal.classList.remove('hidden');
});
// 登録用のモーダルを閉じる
$("[class^=closeRegisterModal]").on("click",function(){
    modal = document.getElementById('register_modal');
    modal.classList.add('hidden');
});

// 配送方法の追加ボタンが押下されたら
$("[id=shipping_method_add]").on("click",function(){
    // 選択した配送方法のidとなる値
    const select_id = shipping_method_select.value;
    // 選択しているインデックス番号を取得
    const select_index = shipping_method_select.selectedIndex;
    try {
        // id = 0(value = 0)ではないかチェック
        if (select_id == 0) {
            throw new Error('配送方法を選択して下さい。');
        }
        // 選択した配送方法の値をスプリット
        const select_value_split = shipping_method_select.options[select_index].innerHTML.split(':');
        // スプリットした情報から配送方法と売上・経費の単価を抽出
        const temp1 = select_value_split[0].replace('（売上', '');
        const temp2 = temp1.split('《');
        const select_shipping_method = temp2[0];
        const select_shipping_method_note = temp2[1].replace('》', '');
        const select_fare_unit_price = select_value_split[1].replace('円）（経費', '');
        const select_fare_expenses = select_value_split[2].replace('円）', '');
        // 既に存在する配送方法ではないかチェック
        if(document.getElementById(select_shipping_method + '-' + select_shipping_method_note + '-' + select_fare_unit_price  + '_fare_sales_div') != null){
            throw new Error('既に存在する配送方法です。');
        }
        // 売上の運賃情報を追加
        fare_add('sales', select_shipping_method, select_shipping_method, select_fare_unit_price, select_shipping_method_note);
        // 経費の運賃情報を追加
        fare_add('expenses', select_shipping_method, select_shipping_method, select_fare_expenses, select_shipping_method_note);
    } catch (e) {
        alert(e.message);
    }
});

// 配送方法の追加処理
function fare_add(add_category, select_id, select_shipping_method, select_price, select_shipping_method_note) {
    // 配送方法を表示する要素を作成
    const shipping_method_name = document.createElement('input');
    shipping_method_name.classList.add('font-bold', 'text-sm', 'col-span-2', 'py-3', 'bg-transparent');
    shipping_method_name.value = select_shipping_method;
    shipping_method_name.readOnly = 'true';
    shipping_method_name.name = 'shipping_method_name_' + add_category + '[]';

    // 配送方法備考を表示する要素を作成
    const shipping_method_note = document.createElement('input');
    shipping_method_note.classList.add('font-bold', 'text-sm', 'col-start-1', 'col-span-2', 'py-3', 'bg-transparent');
    shipping_method_note.value = select_shipping_method_note;
    shipping_method_note.readOnly = 'true';
    shipping_method_note.name = 'shipping_method_note_' + add_category + '[]';

    // 個口数を入力する要素を作成
    const box_quantity = document.createElement('input');
    box_quantity.type = 'tel';
    box_quantity.id = select_id + '_box_quantity_' + add_category;
    box_quantity.name = 'box_quantity_' + add_category + '[]';
    box_quantity.placeholder = '個口';
    box_quantity.autocomplete = 'off';
    box_quantity.classList.add('text-sm', 'col-span-1', 'text-right', 'fare_amount_' + add_category + '_update', 'h-4/5', 'box_quantity_' + add_category, 'int_validation');

    // 個口数という文字を表示する要素を作成
    const box_quantity_text = document.createElement('p');
    box_quantity_text.classList.add('text-sm', 'col-span-1', 'text-left', 'pt-5', 'ml-2');
    box_quantity_text.innerHTML = '個口';

    // ×を表示する要素を作成
    const symbol_kakeru = document.createElement('p');
    symbol_kakeru.classList.add('text-base', 'col-span-1', 'py-3');
    symbol_kakeru.innerHTML = '<i class="las la-times"></i>';

    // 運賃単価を表示・入力する要素を作成
    const fare_unit_price = document.createElement('input');
    fare_unit_price.type = 'tel';
    fare_unit_price.id = select_id + '_fare_unit_price_' + add_category;
    fare_unit_price.name = 'fare_unit_price_' + add_category + '[]';
    fare_unit_price.placeholder = '単価';
    fare_unit_price.autocomplete = 'off';
    fare_unit_price.value = select_price;
    fare_unit_price.classList.add('text-sm', 'col-span-1', 'text-right', 'fare_amount_' + add_category + '_update', 'h-4/5', 'int_validation');

    // 円という文字を表示する要素を作成
    const fare_unit_price_text = document.createElement('p');
    fare_unit_price_text.classList.add('text-sm', 'col-span-1', 'text-left', 'pt-5', 'ml-2');
    fare_unit_price_text.innerHTML = '円';

    // =を表示する要素を作成
    const symbol_equal = document.createElement('p');
    symbol_equal.classList.add('text-base', 'col-span-1', 'py-3');
    symbol_equal.innerHTML = '<i class="las la-equals"></i>';

    // 金額を表示・入力する要素を作成
    const fare_amount = document.createElement('input');
    fare_amount.type = 'tel';
    fare_amount.id = select_id + '_fare_amount_' + add_category;
    fare_amount.name = 'fare_amount_' + add_category + '[]';
    fare_amount.placeholder = '金額';
    fare_amount.autocomplete = 'off';
    fare_amount.classList.add('text-sm', 'col-span-2', 'text-right', 'h-4/5', 'fare_amount_' + add_category, 'int_validation');

    // 削除ボタンの要素を作成
    const delete_btn = document.createElement('button');
    delete_btn.type = 'button';
    delete_btn.id = select_shipping_method + '-' + select_shipping_method_note + '-' + select_price + '_fare_' + add_category + '_delete_btn';
    delete_btn.innerHTML = '<i class="las la-trash la-lg"></i>';
    delete_btn.classList.add('col-span-1', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'delete_shipping_method_' + add_category, 'h-4/5');
    if (add_category == 'expenses') {
        delete_btn.classList.add('hidden');
    }

    // 円を表示する要素を複製する
    const clone_fare_unit_price_text = fare_unit_price_text.cloneNode(true);

    // 追加する要素を纏めるdivタグを作成
    const target_div = document.createElement('div');
    target_div.id = select_shipping_method + '-' + select_shipping_method_note + '-' + select_price + '_fare_' + add_category + '_div';
    target_div.classList.add('grid', 'grid-cols-12', 'col-span-12', 'border-b-2', 'border-black', 'pt-2', 'shipping_method_div');

    // divタグに作成した要素を追加
    target_div.append(shipping_method_name, shipping_method_note, box_quantity, box_quantity_text, symbol_kakeru, fare_unit_price, fare_unit_price_text, symbol_equal, fare_amount, clone_fare_unit_price_text, delete_btn);
    
    // 纏めたdivタグを追加
    if (add_category == 'sales') {
        fare_list_sales.insertBefore(target_div, total_fare_sales_div);
    }
    if (add_category == 'expenses') {
        fare_list_expenses.insertBefore(target_div, total_fare_expenses_div);
    }
}

// 選択された配送方法を削除
$(document).on("click", ".delete_shipping_method_sales", function () {
    const target_id = id_get($(this));
    const delete_target_div_sales = document.getElementById(target_id + '_fare_sales_div');
    const delete_target_div_expenses = document.getElementById(target_id + '_fare_expenses_div');
    delete_target_div_sales.remove();
    delete_target_div_expenses.remove();
    total_fare_sales_update();
    total_fare_expenses_update();
});

// 個口と運賃単価が変更された際の金額更新処理
$(document).on("change", ".fare_amount_sales_update", function () {
    const target_id = id_get($(this));
    const target_box_quantity_sales = document.getElementById(target_id + '_box_quantity_sales');
    const target_fare_unit_price_sales = document.getElementById(target_id + '_fare_unit_price_sales');
    const target_fare_amount_sales = document.getElementById(target_id + '_fare_amount_sales');
    target_fare_amount_sales.value = target_box_quantity_sales.value * target_fare_unit_price_sales.value;
    total_fare_sales_update();
    const target_box_quantity_expenses = document.getElementById(target_id + '_box_quantity_expenses');
    target_box_quantity_expenses.value = target_box_quantity_sales.value
    fare_amount_expenses_update(target_id);
    total_fare_expenses_update();
});

// 金額が変更された際の合計の更新
$(document).on("change", ".fare_amount_sales", function () {
    total_fare_sales_update();
});

// 運賃関連の合計を更新
function total_fare_sales_update(){
    // 個口合計を更新
    let box_quantity_sum = 0;
    const box_quantity_element = document.getElementsByClassName('box_quantity_sales');
    for( let i = 0 ; i < box_quantity_element.length ; i ++ ) {
        box_quantity_sum += isNaN(box_quantity_element[i].value) ? 0 : Number(box_quantity_element[i].value);
    }
    total_box_quantity_sales.innerHTML = box_quantity_sum.toLocaleString();
    // 運賃金額合計を更新
    let fare_amount_sum = 0;
    const fare_amount_element = document.getElementsByClassName('fare_amount_sales');
    for( let i = 0 ; i < fare_amount_element.length ; i ++ ) {
        fare_amount_sum += isNaN(fare_amount_element[i].value) ? 0 : Number(fare_amount_element[i].value);
    }
    total_fare_sales.innerHTML = fare_amount_sum.toLocaleString();
}

// 個口と運賃単価が変更された際の金額更新処理
$(document).on("change", ".fare_amount_expenses_update", function () {
    const target_id = id_get($(this));
    fare_amount_expenses_update(target_id);
    total_fare_expenses_update();
});

function fare_amount_expenses_update(target_id){
    const target_box_quantity_expenses = document.getElementById(target_id + '_box_quantity_expenses');
    const target_fare_unit_price_expenses = document.getElementById(target_id + '_fare_unit_price_expenses');
    const target_fare_amount_expenses = document.getElementById(target_id + '_fare_amount_expenses');
    target_fare_amount_expenses.value = target_box_quantity_expenses.value * target_fare_unit_price_expenses.value;
}

// 金額が変更された際の合計の更新
$(document).on("change", ".fare_amount_expenses", function () {
    total_fare_expenses_update();
});

// 運賃関連の合計を更新
function total_fare_expenses_update(){
    // 個口合計を更新
    let box_quantity_sum = 0;
    const box_quantity_element = document.getElementsByClassName('box_quantity_expenses');
    for( let i = 0 ; i < box_quantity_element.length ; i ++ ) {
        box_quantity_sum += isNaN(box_quantity_element[i].value) ? 0 : Number(box_quantity_element[i].value);
    }
    total_box_quantity_expenses.innerHTML = box_quantity_sum.toLocaleString();
    // 運賃金額合計を更新
    let fare_amount_sum = 0;
    const fare_amount_element = document.getElementsByClassName('fare_amount_expenses');
    for( let i = 0 ; i < fare_amount_element.length ; i ++ ) {
        fare_amount_sum += isNaN(fare_amount_element[i].value) ? 0 : Number(fare_amount_element[i].value);
    }
    total_fare_expenses.innerHTML = fare_amount_sum.toLocaleString();
}

// 荷主が変更されたら、荷役/配送方法のプルダウンを更新、保管関連を算出
$("[id=customer_select]").on("change",function(){
    // 荷主IDを取得
    const customer_id = customer_select.value;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/balance_register_customer_data_get_ajax/' + customer_id;
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/balance_register_customer_data_get_ajax/' + customer_id;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 荷役の要素を全て削除
            $('.cargo_handling_div').remove();
            // 荷役選択のセレクトボックスをクリア
            for (let i = cargo_handling_select.childElementCount; i > 0; i--) {
                cargo_handling_select.remove(i);
            }
            data['cargo_handling_settings'].forEach(function(element){
                // 収支登録初期表示がONの荷役を表示させる
                if (element['balance_register_default_disp'] == 1) {
                    cargo_handling_add(element['cargo_handling_name'], element['cargo_handling_name'], element['cargo_handling_unit_price'], (element['cargo_handling_note'] == null ? '' : element['cargo_handling_note']));
                }
            });
            // 荷役のプルダウンを更新
            cargo_handling_option_update();
            // 荷役合計を更新
            total_cargo_handling_update();
            // 配送方法の要素を全て削除
            $('.shipping_method_div').remove();
            // 配送方法選択のセレクトボックスをクリア
            for (let i = shipping_method_select.childElementCount; i > 0; i--) {
                shipping_method_select.remove(i);
            }
            // 選択した荷主に登録してある配送方法をオプションに追加
            data['shipping_methods'].forEach(function(element){
                const shipping_method_op = document.createElement('option');
                shipping_method_op.value = element['shipping_method_id'];
                shipping_method_op.innerHTML = element['shipping_company'] + '【' + element['shipping_method'] + '】《' + (element['shipping_method_note'] == null ? '' : element['shipping_method_note']) + '》（売上:' + element['fare_unit_price'] + '円）（経費:' + element['fare_expense'] + '円）';
                shipping_method_select.append(shipping_method_op);
            });
            // 保管売上の算出詳細を出力
            storage_fee_detail.innerHTML = '';
            if(data['storage_fee'] != 0){
                storage_fee_detail.innerHTML = (data['customer']['monthly_storage_fee'] !== null ? data['customer']['monthly_storage_fee'].toLocaleString() + '円 / ' : '設定なし / ')
                                                + (data['customer']['working_days'] !== null ? data['customer']['working_days'] + '日 = ' : '設定なし = ')
                                                + data['storage_fee'].toLocaleString() + '円';
            }
            // 保管売上を出力
            storage_fee.value = data['storage_fee'];
            total_storage_fee.innerHTML = Number(storage_fee.value).toLocaleString();
            // 保管経費の算出詳細を出力
            storage_expenses_detail.innerHTML = '';
            if(data['storage_expenses'] != 0){
                storage_expenses_detail.innerHTML = (data['customer']['monthly_storage_expenses'] !== null ? data['customer']['monthly_storage_expenses'].toLocaleString() + '円 / ' : '設定なし / ')
                                                + (data['customer']['working_days'] !== null ? data['customer']['working_days'] + '日 = ' : '設定なし = ')
                                                + data['storage_expenses'].toLocaleString() + '円';
            }
            // 保管経費を出力
            storage_expenses.value = data['storage_expenses'];
            total_storage_expenses.innerHTML = Number(storage_expenses.value).toLocaleString();

            // 月額設定されている売上を稼働日数で割る
            data['monthly_sales_settings'].forEach(function(element){
                other_sales_amount = Math.floor(element['sales_amount'] / data['customer']['working_days']);
                monthly_sales_detail = element['sales_amount'].toLocaleString() + '円 / ' + data['customer']['working_days'] + '日 = ' + other_sales_amount.toLocaleString() + '円';
                add_other_sales(element['sales_item_id'], element['sales_item_name'], monthly_sales_detail, other_sales_amount);
            });
            total_other_sales_update();
        },
        error: function(){
            alert('失敗');
        }
    });
});

// 荷役の追加ボタンが押下されたら
$("[id=cargo_handling_add]").on("click",function(){
    // 選択した荷役のidとなる値
    const select_id = cargo_handling_select.value;
    // 選択しているインデックス番号を取得する
    const select_index = cargo_handling_select.selectedIndex;
    try {
        // id = 0(value = 0)ではないかチェック
        if (select_id == 0) {
            throw new Error('荷役を選択して下さい。');
        }
        // 選択した荷役の値をスプリット
        var select_value_split = cargo_handling_select.options[select_index].innerHTML.split('【');
        // スプリットした値を変数に格納
        const cargo_handling_name_value = select_value_split[0];
        var select_value_split = select_value_split[1].split('】（単価:');
        const cargo_handling_note_value = select_value_split[0];
        const cargo_handling_unit_price_value = select_value_split[1].replace('円）', '');
        // 既に存在する荷役ではないかチェック
        if(document.getElementById(cargo_handling_name_value + '-' + cargo_handling_unit_price_value  + '-' + cargo_handling_note_value + '_cargo_handling_div') != null){
            throw new Error('既に存在する荷役です。');
        }
        // 荷役要素を追加
        cargo_handling_add(cargo_handling_name_value, cargo_handling_name_value, cargo_handling_unit_price_value, cargo_handling_note_value);
        // 荷役のプルダウンを更新
        cargo_handling_option_update();
    } catch (e) {
        alert(e.message);
    }
});

// 荷役要素追加処理部分
function cargo_handling_add(add_id, cargo_handling_name_value, cargo_handling_unit_price_value, cargo_handling_note_value){
    // 荷役を表示する要素を作成
    const cargo_handling_name = document.createElement('input');
    cargo_handling_name.classList.add('font-bold', 'text-sm', 'col-span-2', 'py-3', 'bg-transparent');
    cargo_handling_name.value = cargo_handling_name_value;
    cargo_handling_name.readOnly = 'true';
    cargo_handling_name.name = 'cargo_handling_name[]';
    
    // 作業数を入力する要素を作成
    const operation_quantity = document.createElement('input');
    operation_quantity.type = 'tel';
    operation_quantity.id = add_id + '-' + cargo_handling_unit_price_value + '-' + cargo_handling_note_value + '_operation_quantity';
    operation_quantity.name = 'operation_quantity[]';
    operation_quantity.placeholder = '作業数';
    operation_quantity.autocomplete = 'off';
    operation_quantity.classList.add('text-sm', 'col-span-1', 'text-right', 'cargo_handling_amount_update', 'h-4/5', 'operation_quantity', 'int_validation');

    // 作業という文字を表示する要素を作成
    const operation_quantity_text = document.createElement('p');
    operation_quantity_text.classList.add('text-sm', 'col-span-1', 'text-left', 'pt-5', 'ml-2');
    operation_quantity_text.innerHTML = '作業';

    // ×を表示する要素を作成
    const symbol_kakeru = document.createElement('p');
    symbol_kakeru.classList.add('text-base', 'col-span-1', 'py-3');
    symbol_kakeru.innerHTML = '<i class="las la-times"></i>';
    
    // 荷役単価を表示・入力する要素を作成
    const cargo_handling_unit_price = document.createElement('input');
    cargo_handling_unit_price.type = 'tel';
    cargo_handling_unit_price.id = add_id + '-' + cargo_handling_unit_price_value + '-' + cargo_handling_note_value + '_cargo_handling_unit_price';
    cargo_handling_unit_price.name = 'cargo_handling_unit_price[]';
    cargo_handling_unit_price.placeholder = '単価';
    cargo_handling_unit_price.autocomplete = 'off';
    cargo_handling_unit_price.value = cargo_handling_unit_price_value;
    cargo_handling_unit_price.classList.add('text-sm', 'col-span-1', 'text-right', 'cargo_handling_amount_update', 'h-4/5', 'int_validation');

    // 円という文字を表示する要素を作成
    const cargo_handling_unit_price_text = document.createElement('p');
    cargo_handling_unit_price_text.classList.add('text-sm', 'col-span-1', 'text-left', 'pt-5', 'ml-2');
    cargo_handling_unit_price_text.innerHTML = '円';
    
    // =を表示する要素を作成
    const symbol_equal = document.createElement('p');
    symbol_equal.classList.add('text-base', 'col-span-1', 'py-3');
    symbol_equal.innerHTML = '<i class="las la-equals"></i>';
    
    // 金額を表示・入力する要素を作成
    const cargo_handling_amount = document.createElement('input');
    cargo_handling_amount.type = 'tel';
    cargo_handling_amount.id = add_id + '-' + cargo_handling_unit_price_value + '-' + cargo_handling_note_value + '_cargo_handling_amount';
    cargo_handling_amount.name = 'cargo_handling_amount[]';
    cargo_handling_amount.placeholder = '金額';
    cargo_handling_amount.autocomplete = 'off';
    cargo_handling_amount.classList.add('text-sm', 'col-span-2', 'text-right', 'h-4/5', 'cargo_handling_amount', 'int_validation');

    // 削除ボタンの要素を作成
    const delete_btn = document.createElement('button');
    delete_btn.type = 'button';
    delete_btn.id = add_id + '-' + cargo_handling_unit_price_value + '-' + cargo_handling_note_value + '_delete_btn';
    delete_btn.innerHTML = '<i class="las la-trash la-lg"></i>';
    delete_btn.classList.add('col-span-1', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'delete_cargo_handling', 'h-4/5');
    
    // 円を表示する要素を複製する
    const clone_cargo_handling_unit_price_text = cargo_handling_unit_price_text.cloneNode(true);

    // 荷役備考を表示する要素を作成
    const cargo_handling_note = document.createElement('input');
    cargo_handling_note.classList.add('font-bold', 'text-sm', 'col-start-1', 'col-span-2', 'py-3', 'bg-transparent');
    cargo_handling_note.value = cargo_handling_note_value;
    cargo_handling_note.readOnly = 'true';
    cargo_handling_note.name = 'cargo_handling_note[]';

    // 追加する要素を纏めるdivタグを作成
    const target_div = document.createElement('div');
    target_div.id = add_id + '-' + cargo_handling_unit_price_value + '-' + cargo_handling_note_value + '_cargo_handling_div';
    target_div.classList.add('grid', 'grid-cols-12', 'col-span-12', 'border-b-2', 'border-black', 'pt-2', 'cargo_handling_div');

    // divタグに作成した要素を追加
    target_div.append(cargo_handling_name, cargo_handling_note, operation_quantity, operation_quantity_text, symbol_kakeru, cargo_handling_unit_price, cargo_handling_unit_price_text, symbol_equal, cargo_handling_amount, clone_cargo_handling_unit_price_text, delete_btn);
    
    // 纏めたdivタグを追加
    cargo_handling_list.insertBefore(target_div, total_cargo_handling_div);
}

// 選択された荷役を削除
$(document).on("click", ".delete_cargo_handling", function () {
    const target_id = id_get($(this));
    const delete_target_div = document.getElementById(target_id + '_cargo_handling_div');
    delete_target_div.remove();
    total_cargo_handling_update();
    // 荷役のプルダウンを更新
    cargo_handling_option_update();
});

function cargo_handling_option_update(){
    // 荷主IDを取得
    const customer_id = customer_select.value;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/balance_register_customer_data_get_ajax/' + customer_id;
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/balance_register_customer_data_get_ajax/' + customer_id;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 荷役選択のセレクトボックスをクリア
            for (let i = cargo_handling_select.childElementCount; i > 0; i--) {
                cargo_handling_select.remove(i);
            }
            // 選択した荷主に登録してある荷役をオプションに追加
            data['cargo_handling_settings'].forEach(function(element){
                // 現在登録上に表示されていない荷役のみをオプションに追加
                if(document.getElementById(element['cargo_handling_name'] + '-' + element['cargo_handling_unit_price'] + '-' + (element['cargo_handling_note'] == null ? '' : element['cargo_handling_note']) + '_cargo_handling_div') == null){
                    const cargo_handling_op = document.createElement('option');
                    cargo_handling_op.value = element['cargo_handling_id'];
                    cargo_handling_op.innerHTML = element['cargo_handling_name'] + '【' + (element['cargo_handling_note'] == null ? '' : element['cargo_handling_note']) + '】（単価:' + element['cargo_handling_unit_price'] + '円）';
                    cargo_handling_select.append(cargo_handling_op);
                }
            });
        },
        error: function(){
            alert('失敗');
        }
    });
}

// 作業数と荷役単価が変更された際の金額更新処理
$(document).on("change", ".cargo_handling_amount_update", function () {
    const target_id = id_get($(this));
    const target_operation_quantity = document.getElementById(target_id + '_operation_quantity');
    const target_cargo_handling_unit_price = document.getElementById(target_id + '_cargo_handling_unit_price');
    const target_cargo_handling_amount = document.getElementById(target_id + '_cargo_handling_amount');
    target_cargo_handling_amount.value = target_operation_quantity.value * target_cargo_handling_unit_price.value;
    total_cargo_handling_update();
});

// 金額が変更された際の合計の更新
$(document).on("change", ".cargo_handling_amount", function () {
    total_cargo_handling_update();
});

// 荷役関連の合計を更新
function total_cargo_handling_update(){
    // 作業合計を更新
    let operation_quantity_sum = 0;
    const operation_quantity_element = document.getElementsByClassName('operation_quantity');
    for( let i = 0 ; i < operation_quantity_element.length ; i ++ ) {
        operation_quantity_sum += isNaN(operation_quantity_element[i].value) ? 0 : Number(operation_quantity_element[i].value);
    }
    total_operation_quantity.innerHTML = operation_quantity_sum.toLocaleString();
    // 荷役金額合計を更新
    let cargo_handling_amount_sum = 0;
    const cargo_handling_amount_element = document.getElementsByClassName('cargo_handling_amount');
    for( let i = 0 ; i < cargo_handling_amount_element.length ; i ++ ) {
        cargo_handling_amount_sum += isNaN(cargo_handling_amount_element[i].value) ? 0 : Number(cargo_handling_amount_element[i].value);
    }
    total_cargo_handling.innerHTML = cargo_handling_amount_sum.toLocaleString();
}

// 保管売上が変更された際の金額更新処理
$(document).on("change", ".storage_fee", function () {
    total_storage_fee.innerHTML = Number(storage_fee.value).toLocaleString();
});

// 保管経費が変更された際の金額更新処理
$(document).on("change", ".storage_expenses", function () {
    total_storage_expenses.innerHTML = Number(storage_expenses.value).toLocaleString();
});

// 人件費が変更された際の更新処理
$(document).on("change", ".labor_costs_update", function () {
    const target_id = id_get($(this));
    const target_working_time = document.getElementById(target_id + '_working_time');
    const target_hourly_wage = document.getElementById(target_id + '_hourly_wage');
    const target_labor_costs = document.getElementById(target_id + '_labor_costs');
    target_labor_costs.value = target_working_time.value * target_hourly_wage.value;
    total_labor_costs_update();
});

// 人件費関連の合計を更新
function total_labor_costs_update(){
    // 時間合計を更新
    let working_time_sum = 0;
    const working_time_element = document.getElementsByClassName('working_time');
    for( let i = 0 ; i < working_time_element.length ; i ++ ) {
        working_time_sum += isNaN(working_time_element[i].value) ? 0 : Number(working_time_element[i].value);
    }
    total_working_time.innerHTML = working_time_sum.toLocaleString();
    // 金額合計を更新
    let labor_costs_sum = 0;
    const labor_costs_element = document.getElementsByClassName('labor_costs');
    for( let i = 0 ; i < labor_costs_element.length ; i ++ ) {
        labor_costs_sum += isNaN(labor_costs_element[i].value) ? 0 : Number(labor_costs_element[i].value);
    }
    total_labor_costs.innerHTML = labor_costs_sum.toLocaleString();
}

// 金額が変更された際の合計の更新
$(document).on("change", ".labor_costs", function () {
    total_labor_costs_update();
});

// 処理対象のidを取得する処理
function id_get(target){
    const split = target.attr('id').split('_');
    return split[0];
}

// その他経費の追加ボタンが押下されたら
$("[id=other_expenses_add]").on("click",function(){
    // 選択した荷役のidとなる値
    const select_id = other_expenses_select.value;
    // 選択しているインデックス番号を取得
    const select_index = other_expenses_select.selectedIndex;
    // 選択した経費の値を取得
    const select_value = other_expenses_select.options[select_index].innerHTML;

    try {
        // id = 0(value = 0)ではないかチェック
        if (select_id == 0) {
            throw new Error('経費を選択して下さい。');
        }
        // 既に存在する経費ではないかチェック
        if(document.getElementById(select_value + '_other_expenses_div') != null){
            throw new Error('既に存在する経費です。');
        }
        
        // 経費を表示する要素を作成
        const other_expenses_name = document.createElement('input');
        other_expenses_name.classList.add('font-bold', 'text-sm', 'col-span-2', 'py-3', 'bg-transparent');
        other_expenses_name.value = select_value;
        other_expenses_name.readOnly = 'true';
        other_expenses_name.name = 'other_expenses_name[]';
        
        // 経費備考を入力する要素を作成
        const other_expenses_note = document.createElement('input');
        other_expenses_note.type = 'tel';
        other_expenses_note.id = select_value + '_other_expenses_note';
        other_expenses_note.name = 'other_expenses_note[]';
        other_expenses_note.placeholder = '備考';
        other_expenses_note.autocomplete = 'off';
        other_expenses_note.classList.add('text-sm', 'col-span-2', 'col-start-4', 'h-4/5');

        // 経費金額を入力する要素を作成
        const other_expenses_amount = document.createElement('input');
        other_expenses_amount.type = 'tel';
        other_expenses_amount.id = select_value + '_other_expenses_amount';
        other_expenses_amount.name = 'other_expenses_amount[]';
        other_expenses_amount.placeholder = '金額';
        other_expenses_amount.autocomplete = 'off';
        other_expenses_amount.classList.add('text-sm', 'col-span-2', 'col-start-9', 'text-right', 'other_expenses_amount_update', 'h-4/5', 'other_expenses_amount', 'int_validation');
    
        // 円という文字を表示する要素を作成
        const other_expenses_amount_text = document.createElement('p');
        other_expenses_amount_text.classList.add('text-sm', 'col-span-1', 'col-start-11', 'text-left', 'pt-5', 'ml-2');
        other_expenses_amount_text.innerHTML = '円';

        // 削除ボタンの要素を作成
        const delete_btn = document.createElement('button');
        delete_btn.type = 'button';
        delete_btn.id = select_value + '_other_expenses_delete_btn';
        delete_btn.innerHTML = '<i class="las la-trash la-lg"></i>';
        delete_btn.classList.add('col-span-1', 'col-start-12', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'delete_other_expenses', 'h-4/5');
        
        // 追加する要素を纏めるdivタグを作成
        const target_div = document.createElement('div');
        target_div.id = select_value + '_other_expenses_div';
        target_div.classList.add('grid', 'grid-cols-12', 'col-span-12', 'border-b-2', 'border-black', 'pt-2');

        // divタグに作成した要素を追加
        target_div.append(other_expenses_name, other_expenses_note, other_expenses_amount, other_expenses_amount_text, delete_btn);

        // 纏めたdivタグを追加
        other_expenses_list.insertBefore(target_div, total_other_expenses_div);

    } catch (e) {
        alert(e.message);
    }
});

// 金額が変更された際の金額更新処理
$(document).on("change", ".other_expenses_amount_update", function () {
    total_other_expenses_update();
});

// 選択された経費を削除
$(document).on("click", ".delete_other_expenses", function () {
    const target_id = id_get($(this));
    const delete_target_div = document.getElementById(target_id + '_other_expenses_div');
    delete_target_div.remove();
    total_other_expenses_update();
});

// その他経費の合計金額更新処理
function total_other_expenses_update()
{
    // 金額合計を更新
    let other_expenses_amount_sum = 0;
    const other_expenses_amount_element = document.getElementsByClassName('other_expenses_amount');
    for( let i = 0 ; i < other_expenses_amount_element.length ; i ++ ) {
        other_expenses_amount_sum += isNaN(other_expenses_amount_element[i].value) ? 0 : Number(other_expenses_amount_element[i].value);
    }
    total_other_expenses_amount.innerHTML = other_expenses_amount_sum.toLocaleString();
}

// その他売上の追加ボタンが押下されたら
$("[id=other_sales_add]").on("click",function(){
    // 選択した荷役のidとなる値
    const select_id = other_sales_select.value;
    // 選択しているインデックス番号を取得
    const select_index = other_sales_select.selectedIndex;
    // 選択した経費の値を取得
    const select_value = other_sales_select.options[select_index].innerHTML;
    add_other_sales(select_id, select_value, '', '');
});

function add_other_sales(select_id, select_value, monthly_sales_detail_value, other_sales_amount_value){
    
    try {
        // id = 0(value = 0)ではないかチェック
        if (select_id == 0) {
            throw new Error('売上を選択して下さい。');
        }
        // 既に存在する経費ではないかチェック
        if(document.getElementById(select_value + '_other_sales_div') != null){
            throw new Error('既に存在する売上です。');
        }
        
        // 売上を表示する要素を作成
        const other_sales_name = document.createElement('input');
        other_sales_name.classList.add('font-bold', 'text-sm', 'col-span-2', 'py-3', 'bg-transparent');
        other_sales_name.value = select_value;
        other_sales_name.readOnly = 'true';
        other_sales_name.name = 'other_sales_name[]';

        // 売上備考を入力する要素を作成
        const other_sales_note = document.createElement('input');
        other_sales_note.type = 'tel';
        other_sales_note.id = select_value + '_other_sales_note';
        other_sales_note.name = 'other_sales_note[]';
        other_sales_note.placeholder = '備考';
        other_sales_note.autocomplete = 'off';
        other_sales_note.classList.add('text-sm', 'col-span-2', 'col-start-4', 'h-4/5');

        // （月額売上用）算出式を表示する要素を作成
        const monthly_sales_detail = document.createElement('p');
        monthly_sales_detail.classList.add('font-bold', 'text-sm', 'col-start-7', 'col-span-2', 'py-3');
        monthly_sales_detail.innerHTML = monthly_sales_detail_value;
        
        // 売上金額を入力する要素を作成
        const other_sales_amount = document.createElement('input');
        other_sales_amount.type = 'tel';
        other_sales_amount.id = select_value + '_other_sales_amount';
        other_sales_amount.name = 'other_sales_amount[]';
        other_sales_amount.placeholder = '金額';
        other_sales_amount.autocomplete = 'off';
        other_sales_amount.classList.add('text-sm', 'col-span-2', 'col-start-9', 'text-right', 'other_sales_amount_update', 'h-4/5', 'other_sales_amount', 'int_validation');
        if(monthly_sales_detail_value != ''){
            other_sales_amount.value = other_sales_amount_value;
        }

        // 円という文字を表示する要素を作成
        const other_sales_amount_text = document.createElement('p');
        other_sales_amount_text.classList.add('text-sm', 'col-span-1', 'col-start-11', 'text-left', 'pt-5', 'ml-2');
        other_sales_amount_text.innerHTML = '円';

        // 削除ボタンの要素を作成
        const delete_btn = document.createElement('button');
        delete_btn.type = 'button';
        delete_btn.id = select_value + '_other_sales_delete_btn';
        delete_btn.innerHTML = '<i class="las la-trash la-lg"></i>';
        delete_btn.classList.add('col-span-1', 'col-start-12', 'bg-red-600', 'text-white', 'hover:bg-gray-400', 'delete_other_sales', 'h-4/5');
        
        // 追加する要素を纏めるdivタグを作成
        const target_div = document.createElement('div');
        target_div.id = select_value + '_other_sales_div';
        target_div.classList.add('grid', 'grid-cols-12', 'col-span-12', 'border-b-2', 'border-black', 'pt-2');

        // divタグに作成した要素を追加
        target_div.append(other_sales_name, other_sales_note, monthly_sales_detail, other_sales_amount, other_sales_amount_text, delete_btn);

        // 纏めたdivタグを追加
        other_sales_list.insertBefore(target_div, total_other_sales_div);

    } catch (e) {
        alert(e.message);
    }
}

// 金額が変更された際の金額更新処理
$(document).on("change", ".other_sales_amount_update", function () {
    total_other_sales_update();
});

// 選択された経費を削除
$(document).on("click", ".delete_other_sales", function () {
    const target_id = id_get($(this));
    const delete_target_div = document.getElementById(target_id + '_other_sales_div');
    delete_target_div.remove();
    total_other_sales_update();
});

// その他売上の合計金額更新処理
function total_other_sales_update()
{
    // 金額合計を更新
    let other_sales_amount_sum = 0;
    const other_sales_amount_element = document.getElementsByClassName('other_sales_amount');
    for( let i = 0 ; i < other_sales_amount_element.length ; i ++ ) {
        other_sales_amount_sum += isNaN(other_sales_amount_element[i].value) ? 0 : Number(other_sales_amount_element[i].value);
    }
    total_other_sales_amount.innerHTML = other_sales_amount_sum.toLocaleString();
}

// 登録ボタンが押下されたら
$("[id=register_enter]").on("click",function(){
    validation('register', '収支登録を実行しますか？');
});

// 修正ボタンが押下されたら
$("[id=modify_enter]").on("click",function(){
    validation('modify', '収支修正を実行しますか？');
});

function validation($category, $msg){
    const balance_register_form = document.getElementById('balance_register_form');
    const regex = /^[0-9]{4}\-(0[1-9]|1[0-2])\-(0[1-9]|[12][0-9]|3[01])$/;
    try {
        // 荷主が選択されているか
        if(customer_select.value == 0){
            throw new Error('荷主を選択して下さい。');
        }
        // 収支日が選択されているか
        if(regex.test(balance_date.value) == false){
            throw new Error('収支日を選択して下さい。');
        }
        // 荷役単価を取得して、正常な値であるかチェック
        const int_validations = document.querySelectorAll('.int_validation');
        int_validations.forEach(int_validation => {
            // 時給が正しいかチェック
            if (isNaN(int_validation.value)){
                throw new Error('入力が正しくありません。');
            }
        });
        
        // 環境でパスを可変させる
        if(process.env.MIX_APP_ENV === 'local'){
            var ajax_url = '/balance_register_validation_ajax/' + customer_select.value + '/' + balance_date.value;
        }
        if(process.env.MIX_APP_ENV === 'pro'){
            var ajax_url = '/balance/balance_register_validation_ajax/' + customer_select.value + '/' + balance_date.value;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: ajax_url,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                // 既に登録されている収支でないか確認
                if(data['balance'] != null && $category == 'register'){
                    alert('既に登録されている収支です。');
                    return false;
                }
                const result = window.confirm($msg);
                // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
                if(result == true) {
                    balance_register_form.submit();
                }
            },
            error: function(){
                alert('失敗');
            }
        });
    } catch (e) {
        alert(e.message);
        return false;
    }
}