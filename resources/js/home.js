const balance_progress_per = document.getElementById('balance_progress_per');
const sales_plan_progress_per = document.getElementById('sales_plan_progress_per');
const congrats_balance_progress = document.getElementById('congrats_balance_progress');
const congrats_sales_plan_progress = document.getElementById('congrats_sales_plan_progress');

const orange = 'rgba(246, 173, 85, 1)';
const gray = 'rgb(99, 99, 99)';
const red = 'rgb(229, 48, 110)';

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
                        // 達成率が100オーバーしているかどうかで表示を変更
                        data: data['balance_progress_achieve_100_over'] == 0 ? [data['balance_progress_achieve_chart'], data['balance_progress_not_achieve_chart']] : [data['balance_progress_achieve_100_over'], data['balance_progress_achieve_chart']],
                        backgroundColor: data['balance_progress_achieve_100_over'] == 0 ? [orange, gray] : [red, orange]
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
            // 達成率が100%以上であれば、画像を表示
            if(data['balance_progress_achieve'] >= 100){
                congrats_balance_progress.classList.remove("hidden");
            }
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
                        // 達成率が100オーバーしているかどうかで表示を変更
                        data: data['sales_plan_progress_achieve_100_over'] == 0 ? [data['sales_plan_progress_achieve_chart'], data['sales_plan_progress_not_achieve_chart']] : [data['sales_plan_progress_achieve_100_over'], data['sales_plan_progress_achieve_chart']],
                        backgroundColor: data['sales_plan_progress_achieve_100_over'] == 0 ? [orange, gray] : [red, orange]
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
            // 達成率が100%以上であれば、画像を表示
            if(data['sales_plan_progress_achieve'] >= 100){
                congrats_sales_plan_progress.classList.remove("hidden");
            }
        },
        error: function(){
            alert('失敗');
        }
    });
}