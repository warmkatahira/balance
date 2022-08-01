var salesChart = null;
var expensesChart = null;
window.onload = function () {
    const url = location.href;
    const url_split = url.split('=');
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/balance_detail_get_ajax/' + url_split[1];
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/balance_detail_get_ajax/' + url_split[1];
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: ajax_url,
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
                    labels: ['荷役', '運賃', '保管', '他売上'],
                    datasets: [{
                        data: [data['cargo_handling_sum'], data['fare_sales_sum'], data['balance']['storage_fee'], data['other_sales_amount_sum']],
                        backgroundColor: ["rgba(65,105,225,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                        hoverBackgroundColor: ["rgba(65,105,225,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '売上チャート(合計:' + data['balance']['sales'].toLocaleString() + ' 円)',
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data){
                                return data.datasets[0]['data'][tooltipItem.index].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') +' 円';
                            }
                        }
                    }
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
                    labels: ['人件費', '運賃', '保管', '他経費'],
                    datasets: [{
                        data: [data['labor_costs_sum'], data['fare_expenses_sum'], data['balance']['storage_expenses'], data['other_expenses_amount_sum']],
                        backgroundColor: ["rgba(255,0,0,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                        hoverBackgroundColor: ["rgba(255,0,0,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '経費チャート(合計:' + data['balance']['expenses'].toLocaleString() + ' 円)',
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data){
                                return data.datasets[0]['data'][tooltipItem.index].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') +' 円';
                            }
                        }
                    }
                }
            })
        },
        error: function(){
            alert('失敗');
        }
    });
}