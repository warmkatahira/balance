var salesChart = null;
var expensesChart = null;
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
            // 売上チャートを表示
            let salesContext = document.querySelector("#sales_chart").getContext('2d');
            // 前回のチャートを破棄
            if (salesChart != null) {
                salesChart.destroy();
            }
            salesChart = new Chart(salesContext, {
                type: 'line',
                data: {
                    labels: data['date'],
                    datasets: [
                        {
                            label: "売上",
                            data: data['sales'],
                            borderColor: "rgba(65,105,225,1)",
                            backgroundColor: "rgba(65,105,225,0)",
                            pointHoverRadius: 5,
                        },
                        {
                            label: "経費",
                            data: data['expenses'],
                            borderColor: "rgba(219,39,91,0.5)",
                            backgroundColor: "rgba(219,39,91,0)",
                            pointHoverRadius: 5,
                        },
                        {
                            label: "利益",
                            data: data['profit'],
                            borderColor: "rgba(246, 173, 85, 1)",
                            backgroundColor: "rgba(246, 173, 85, 0)",
                            pointHoverRadius: 5,
                        },
                    ],
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '収支チャート',
                    },
                    scales:{
                        yAxes:[//グラフ縦軸（Y軸）設定
                            {
                                ticks:{
                                    
                                    callback: function(value){
                                        return  value +  '円'//数字＋%で表示			
                                }
                            }
                            }
                        ],
                        xAxes:[//棒グラフ横（X軸）設定
                            {
                                barPercentage:0.5,//バーの太さ
                            }
                        ]
                    },
                }
            })
        },
        error: function(){
            alert('失敗');
        }
    });
}