window.onload = function(){
    total_fare_sales_update();
    total_fare_expenses_update();
    total_cargo_handling_update();
    total_labor_costs_update();
    total_other_sales_update();
    total_other_expenses_update();
    cargo_handling_option_update();
}

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

// 荷役のプルダウンを更新
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
                if(document.getElementById(element['cargo_handling_name'] + '-' + element['cargo_handling_unit_price']  + '-' + (element['cargo_handling_note'] == null ? '' : element['cargo_handling_note']) + '_cargo_handling_div') == null){
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