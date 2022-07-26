const balance_progress_per = document.getElementById('balance_progress_per');
const sales_plan_progress_per = document.getElementById('sales_plan_progress_per');
const orange = 'rgba(246, 173, 85, 1)';
const gray = 'rgb(99, 99, 99)';

window.onload = function () {
    balance_progress_chart();
    sales_plan_progress_chart();
}

function balance_progress_chart(){
    balance_progressChart = null;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/balance_progress_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/balance_progress_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: ajax_url,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 進捗チャートを表示
            let progressContext = document.querySelector("#balance_progress_chart").getContext('2d');
            // 前回のチャートを破棄
            if (balance_progressChart != null) {
                balance_progressChart.destroy();
            }
            balance_progressChart = new Chart(progressContext, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [data['balance_progress_achieve_chart'], data['balance_progress_not_achieve_chart']],
                        backgroundColor: [orange, gray]
                    }],
                },
                options: {
                    responsive: false,
                    // マウスオーバー時に情報を表示しない
                    tooltips: { enabled: false },
                    maintainAspectRatio: false,
                }
            })
            // 進捗率を出力
            balance_progress_per.innerHTML = '収支率：' + data['balance_progress_achieve'] + '%';
        },
        error: function(){
            alert('失敗');
        }
    });
}

function sales_plan_progress_chart(){
    sales_plan_progressChart = null;
    // 環境でパスを可変させる
    if(process.env.MIX_APP_ENV === 'local'){
        var ajax_url = '/sales_plan_progress_get_ajax';
    }
    if(process.env.MIX_APP_ENV === 'pro'){
        var ajax_url = '/balance/sales_plan_progress_get_ajax';
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: ajax_url,
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 進捗チャートを表示
            let progressContext = document.querySelector("#sales_plan_progress_chart").getContext('2d');
            // 前回のチャートを破棄
            if (sales_plan_progressChart != null) {
                sales_plan_progressChart.destroy();
            }
            sales_plan_progressChart = new Chart(progressContext, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [data['sales_plan_progress_achieve_chart'], data['sales_plan_progress_not_achieve_chart']],
                        backgroundColor: [orange, gray]
                    }],
                },
                options: {
                    responsive: false,
                    // マウスオーバー時に情報を表示しない
                    tooltips: { enabled: false },
                    maintainAspectRatio: false,
                }
            })
            // 売上計画達成率を出力
            sales_plan_progress_per.innerHTML = '売上計画達成率：' + data['sales_plan_progress_achieve'] + '%';
        },
        error: function(){
            alert('失敗');
        }
    });
}