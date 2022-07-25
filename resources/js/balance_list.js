const search_category_select = document.getElementById('search_category_select');
const base_select = document.getElementById('base_select');
const customer_select = document.getElementById('customer_select');
const base = document.getElementById('base');
const customer = document.getElementById('customer');
const date_category_select = document.getElementById('date_category_select');
const date_period_from = document.getElementById('date_period_from');
const date_period_to = document.getElementById('date_period_to');

// 検索区分が変更されたら、拠点と荷主のプルダウンの表示/非表示を切り替え
$("[id=search_category_select]").on("change",function(){
    // 選択しているインデックス番号を取得し、プルダウンの値を取得
    const select_index = search_category_select.selectedIndex;
    const select_value = search_category_select.options[select_index].innerHTML;
    // 全社だったら拠点=非表示、荷主=非表示
    if(select_value == '全社'){
        base.classList.add('hidden');
        customer.classList.add('hidden');
        base_select.disabled = true;
        customer_select.disabled = true;
    }
    // 拠点だったら拠点=表示、荷主=非表示
    if(select_value == '拠点'){
        base.classList.remove('hidden');
        customer.classList.add('hidden');
        base_select.disabled = false;
        customer_select.disabled = true;
    }
    // 荷主だったら拠点=表示、荷主=表示
    if(select_value == '荷主'){
        base.classList.remove('hidden');
        customer.classList.remove('hidden');
        base_select.disabled = false;
        customer_select.disabled = false;
    }
});

// 日付区分が変更されたら、日付期間のTypeを変更
$("[id=date_category_select]").on("change",function(){
    // 選択しているインデックス番号を取得し、プルダウンの値を取得
    const select_index = date_category_select.selectedIndex;
    const select_value = date_category_select.options[select_index].innerHTML;
    // 変更時の初期値を今日（今月）に設定する為の処理
    const now_date = new Date();
    const year = now_date.getFullYear();
    const month = ('00' + (now_date.getMonth()+1)).slice(-2);
    const day = ('00' + now_date.getDate()).slice(-2);
    if(select_value == '月別'){
        date_period_from.setAttribute( 'type', 'month');
        date_period_to.setAttribute( 'type', 'month');
        date_period_from.value = year + '-' + month;
        date_period_to.value = year + '-' + month;
    }
    if(select_value == '日別'){
        date_period_from.setAttribute( 'type', 'date');
        date_period_to.setAttribute( 'type', 'date');
        date_period_from.value = year + '-' + month + '-' + day;
        date_period_to.value = year + '-' + month + '-' + day;
    }
});

// 拠点区分が変更されたら、荷主を変更
$("[id=base_select]").on("change",function(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/get_customer_ajax/' + base_select.value,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 荷主区分のプルダウンをクリア
            for (let i = customer_select.childElementCount; i > 0; i--) {
                customer_select.remove(i);
            }
            // 取得してきた荷主をオプションに追加
            data['customers'].forEach(function(element){
                const customer_select_op = document.createElement('option');
                customer_select_op.value = element['customer_id'];
                customer_select_op.innerHTML = element['customer_name'];
                customer_select.append(customer_select_op);
            });
        },
        error: function(){
            alert('失敗');
        }
    });
});

// 削除ボタンが押下された際の処理
$(document).on("click", ".balance_delete", function () {
    const result = window.confirm('収支削除を実行しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    }else {
        return false;
    }
});