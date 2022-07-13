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

// 編集用のモーダルを開く
var salesChart = null;
var expensesChart = null;
$("[class^=openEditModal]").on("click",function(){
    const balance_id = $(this).attr('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/balance_get_ajax/' + balance_id,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 売上チャートを表示
            let salesContext = document.querySelector("#sales_chart").getContext('2d')
            // 前回のチャートを破棄
            if (salesChart != null) {
                salesChart.destroy();
            }
            salesChart = new Chart(salesContext, {
                type: 'doughnut',
                data: {
                    labels: ['荷役', '運賃', '保管'],
                    datasets: [{
                        data: [data['balance']['cargo_handling_fee'], data['balance']['shipping_fee'], data['balance']['storage_fee']],
                        backgroundColor: ["rgba(65,105,225,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)"]
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '売上チャート(合計:' + data['balance']['sales'].toLocaleString() + ')',
                    },
                }
            })
            // 経費チャートを表示
            let expensesContext = document.querySelector("#expenses_chart").getContext('2d')
            // 前回のチャートを破棄
            if (expensesChart != null) {
                expensesChart.destroy();
            }
            expensesChart = new Chart(expensesContext, {
                type: 'doughnut',
                data: {
                    labels: ['人件費', '本管費', '他経費'],
                    datasets: [{
                        data: [data['balance']['labor_costs'], data['balance']['ho_management_costs'], data['balance']['other_costs']],
                        backgroundColor: ["rgba(255,0,0,1)", "rgba(0,0,0,1)", "rgba(255,215,0,1)"]
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '経費チャート(合計:' + data['balance']['expenses'].toLocaleString() + ')',
                    },
                }
            })
            // 各種値を画面に追加
            balance_date = document.getElementById('balance_date');
            balance_date.innerHTML = data['balance']['balance_date'];
            base_name = document.getElementById('base_name');
            base_name.innerHTML = data['balance']['base_name'];
            customer_name = document.getElementById('customer_name');
            customer_name.innerHTML = data['balance']['customer_name'];
            cargo_handling_fee = document.getElementById('cargo_handling_fee');
            cargo_handling_fee.innerHTML = data['balance']['cargo_handling_fee'].toLocaleString();
            shipping_fee = document.getElementById('shipping_fee');
            shipping_fee.innerHTML = data['balance']['shipping_fee'].toLocaleString();
            storage_fee = document.getElementById('storage_fee');
            storage_fee.innerHTML = data['balance']['storage_fee'].toLocaleString();
            labor_costs = document.getElementById('labor_costs');
            labor_costs.innerHTML = data['balance']['labor_costs'].toLocaleString();
            ho_management_costs = document.getElementById('ho_management_costs');
            ho_management_costs.innerHTML = data['balance']['ho_management_costs'].toLocaleString();
            other_costs = document.getElementById('other_costs');
            other_costs.innerHTML = data['balance']['other_costs'].toLocaleString();
            sales = document.getElementById('sales');
            sales.innerHTML = data['balance']['sales'].toLocaleString();
            expenses = document.getElementById('expenses');
            expenses.innerHTML = data['balance']['expenses'].toLocaleString();
            profit = document.getElementById('profit');
            profit.innerHTML = data['balance']['profit'].toLocaleString();
            profit_rate = document.getElementById('profit_rate');
            profit_rate.innerHTML = data['balance']['profit'] === 0 ? 0 : ((data['balance']['profit'] / data['balance']['sales']) * 100).toFixed(2);;
            balance_note = document.getElementById('balance_note');
            balance_note.innerHTML = data['balance']['balance_note'] === null ? '' : data['balance']['balance_note'].replace(/\n/g, "<br>");
            // 赤字の場合のクラスを追加・削除する
            if (data['balance']['profit'] < 0) {
                profit.classList.remove('border-black');
                profit.classList.add('text-red-400', 'font-bold', 'border-red-400');
                profit_rate.classList.add('text-red-400', 'font-bold');
            } else {
                profit.classList.remove('text-red-400', 'font-bold', 'border-red-400');
                profit.classList.add('border-black');
                profit_rate.classList.remove('text-red-400', 'font-bold');
            }
            // モーダルを表示
            modal = document.getElementById('edit_modal');
            modal.classList.remove('hidden');
        },
        error: function(){
            alert('失敗');
        }
    });
});
// 編集用のモーダルを閉じる
$("[class^=closeEditModal]").on("click",function(){
    modal = document.getElementById('edit_modal');
    modal.classList.add('hidden');
});