var xAxisLabelMinWidth = 15; // データ当たりの幅を設定
var width = 100*xAxisLabelMinWidth; // グラフ全体の幅を計算
document.getElementById('sales_chart_daily').style.width = width+"px"; //　グラフの幅を設定
document.getElementById('sales_chart_daily').style.height = "500px"; //htmlと同じ高さを設定


var salesChart_daily = null;
var salesChart_monthly = null;
var expensesChart_monthly = null;
window.onload = function () {
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/balance_list_customer_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/balance_list_customer_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: ajax_url,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 日別チャートを表示
            let salesContext_daily = document.querySelector("#sales_chart_daily").getContext('2d');
            // 前回のチャートを破棄
            if (salesChart_daily != null) {
                salesChart_daily.destroy();
            }
            salesChart_daily = new Chart(salesContext_daily, {
                type: 'bar',
                data: {
                    labels: data['date'],
                    datasets: [
                        {
                            id: "s",
                            label: "売上",
                            data: data['sales'],
                            backgroundColor: "rgba(65,105,225,1)",
                            pointHoverRadius: 5,
                            yAxisID: "y-left",
                        },
                        {
                            id: "e",
                            label: "経費",
                            data: data['expenses'],
                            backgroundColor: "rgba(219,39,91,0.5)",
                            pointHoverRadius: 5,
                            yAxisID: "y-left",
                        },
                        {
                            id: "p",
                            label: "利益",
                            data: data['profit'],
                            backgroundColor: "rgba(246, 173, 85, 1)",
                            pointHoverRadius: 5,
                            yAxisID: "y-left",
                        },
                        {
                            label: '利益率',
                            type: "line",
                            fill: false,
                            data: data['profit_per'],
                            borderColor: "rgb(0, 161, 32)",
                            yAxisID: "y-right",
                            pointStyle: 'rectRounded',
                            pointRadius: 8,
                            hoverRadius: 8,
                            backgroundColor: "rgb(0, 161, 32)",
                            tension: 0,
                        },
                    ],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '日別収支チャート',
                    },
                    scales:{
                        yAxes:[//グラフ縦軸（Y軸）設定
                            {
                                id: 'y-left',
                                position: 'left',
                                ticks:{
                                    callback: function(label, index, labels) { /* ここです */
                                        return label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') +' 円';
                                    }
                                }
                            },
                            {
                                id: 'y-right',
                                position: 'right',
                                ticks:{
                                    callback: function(label, index, labels) {
                                        return label +' %';
                                    },
                                    max: 50,
                                    min: -50,
                                    stepSize: 5
                                }
                            }
                        ],
                        xAxes:[//棒グラフ横（X軸）設定
                            {
                                barPercentage:0.5,//バーの太さ
                            }
                        ]
                    },
                    tooltips: { 
                        callbacks: {
                            label: function(tooltipItem, data){
                                if(tooltipItem.datasetIndex == 3){
                                    return tooltipItem.yLabel +' %';
                                }else{
                                    return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') +' 円';
                                }
                            }
                        }
                    }
                }
            })
            // 月別売上チャートを表示
            let salesContext_monthly = document.querySelector("#sales_chart_monthly").getContext('2d');
            // 前回のチャートを破棄
            if (salesChart_monthly != null) {
                salesChart_monthly.destroy();
            }
            salesChart_monthly = new Chart(salesContext_monthly, {
                type: 'doughnut',
                data: {
                    labels: ['荷役', '運賃', '保管', '他売上'],
                    datasets: [{
                        data: [data['total_cargo_handling_amount'], data['total_fare_sales_amount'], data['total_storage_fee'], data['total_other_sales_amount']],
                        backgroundColor: ["rgba(65,105,225,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                        hoverBackgroundColor: ["rgba(65,105,225,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"]
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '月別売上チャート(合計:' + Number(data['total_sales']).toLocaleString() + ' 円)',
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
            // 月別経費チャートを表示
            let expensesContext_monthly = document.querySelector("#expenses_chart_monthly").getContext('2d')
            // 前回のチャートを破棄
            if (expensesChart_monthly != null) {
                expensesChart_monthly.destroy();
            }
            expensesChart_monthly = new Chart(expensesContext_monthly, {
                type: 'doughnut',
                data: {
                    labels: ['人件費', '運賃', '保管', '他経費'],
                    datasets: [{
                        data: [data['total_labor_costs'], data['total_fare_expenses_amount'], data['total_storage_expenses'], data['total_other_expenses_amount']],
                        backgroundColor: ["rgba(255,0,0,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"],
                        hoverBackgroundColor: ["rgba(255,0,0,1)", "rgba(219,39,91,0.5)", "rgba(60,179,113,1)", "rgb(186 230 253)"]
                    }],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '月別経費チャート(合計:' + Number(data['total_expenses']).toLocaleString() + ' 円)',
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