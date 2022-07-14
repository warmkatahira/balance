var salesChart = null;
var expensesChart = null;
window.onload = function () {
    const url = location.href;
    const url_split = url.split('=');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/balance/balance_get_ajax/' + url_split[1],
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 売上チャートを表示
            let salesContext = document.querySelector("#sales_chart").getContext('2d');
            // 前回のチャートを破棄
            if (salesChart != null) {
                salesChart.destroy();
            }
            salesChart = new Chart(salesContext, {
                type: 'doughnut',
                data: {
                    labels: ['荷役', '運賃', '保管'],
                    datasets: [{
                        data: [data['cargo_handling_sum_sales'], data['fare_sum_sales'], data['balance']['storage_fee']],
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
                    labels: ['人件費', '運賃', '他経費'],
                    datasets: [{
                        data: [data['labor_costs_sum_expenses'], data['fare_sum_expenses'], data['other_expense_amount_sum_expenses']],
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
        },
        error: function(){
            alert('失敗');
        }
    });
}