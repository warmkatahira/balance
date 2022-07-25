const progress_per = document.getElementById('progress_per');
const amber = 'rgba(255, 160, 0, 1)';
const gray = 'rgb(99, 99, 99)';

progressChart = null;
window.onload = function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },    
        url: '/balance_progress_get_ajax',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            // 進捗チャートを表示
            let progressContext = document.querySelector("#progress_chart").getContext('2d');
            // 前回のチャートを破棄
            if (progressChart != null) {
                progressChart.destroy();
            }
            progressChart = new Chart(progressContext, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [data['balance_progress_achieve_chart'], data['balance_progress_not_achieve_chart']],
                        backgroundColor: [amber, gray]
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
            progress_per.innerHTML = '進捗率：' + data['balance_progress_achieve'] + '%';
        },
        error: function(){
            alert('失敗');
        }
    });
}