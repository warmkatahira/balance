const modal = document.getElementById('message_templete_register_modal');
const templete_select = document.getElementById('templete');
const title = document.getElementById('title');
const content = document.getElementById('content');

// テンプレート登録モーダルを開く
$("[id=message_templete_register_modal_open]").on("click",function(){
    modal.classList.remove('hidden');
});

// テンプレート登録モーダルを閉じる
$("[class^=message_templete_register_modal_close]").on("click",function(){
    modal.classList.add('hidden');
});

// テンプレート登録ボタンが押下されたら
$("[id=message_templete_register]").on("click",function(){
    const register_name = document.getElementById('register_name');
    const register_content = document.getElementById('register_content');
    const message_templete_register_form = document.getElementById('message_templete_register_form');
    try {
        // 件名が入力されているか
        if (register_name.value == 0) {
            throw new Error('テンプレート名を入力して下さい。');
        }
        // 文字数チェック
        if (register_content.value.length > 500){
            throw new Error('メッセージ内容の文字数がオーバーしています。');
        }
        const result = window.confirm('テンプレート登録を行いますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            message_templete_register_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});

// テンプレート選択が変更されたら
$("[id=templete]").on("change",function(){
    // テンプレートIDを取得
    const templete_id = templete_select.value;
    // idが0以外で処理を実行
    if(templete_id != 0){
        // 環境でパスを可変させる
        if(process.env.MIX_APP_ENV === 'local'){
            var ajax_url = '/message_templete_get_ajax/' + templete_id;
        }
        if(process.env.MIX_APP_ENV === 'pro'){
            var ajax_url = '/balance/message_templete_get_ajax/' + templete_id;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: ajax_url,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                // テンプレートの内容を反映
                title.value = data['message_templete']['templete_title'];
                content.value = data['message_templete']['templete_content'];
            },
            error: function(){
                alert('失敗');
            }
        });
    }
});

// 送信ボタンが押下されたら
$("[id=message_confirm]").on("click",function(){
    const message_form = document.getElementById('message_form');
    try {
        // 件名が入力されているか
        if (title.value == '') {
            throw new Error('件名を入力して下さい。');
        }
        // メッセージ内容が入力されているか
        if(content.value == ''){
            throw new Error('メッセージ内容を入力して下さい。');
        }
        const result = window.confirm('メッセージを送信しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            message_form.submit();
        }else {
            return false;
        }
    } catch (e) {
        alert(e.message);
    }
});