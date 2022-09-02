// detailsタグが押下されたら
$("[class^=question_detail]").on("click",function(){
    const element = document.getElementById('summary_' + $(this).attr('id'));
    // アイコンを切り替える
    if( element.classList.contains('la-plus-circle') == true ){
        element.classList.replace('la-plus-circle', 'la-minus-circle');
    }else{
        element.classList.replace('la-minus-circle', 'la-plus-circle');
    }
});

// 削除ボタンが押下された際の処理
$(document).on("click", ".question_delete", function () {
    const result = window.confirm('よくある質問を削除しますか？');
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result == true) {
        submit();
    }else {
        return false;
    }
});

// よくある質問投稿モーダルを開く
$("[id=question_register_modal_open]").on("click",function(){
    const modal = document.getElementById('question_register_modal');
    modal.classList.remove('hidden');
});

// よくある質問投稿モーダルを閉じる
$("[class^=question_register_modal_close]").on("click",function(){
    const modal = document.getElementById('question_register_modal');
    modal.classList.add('hidden');
});

// よくある質問投稿ボタンが押下されたら
$("[id=question_register]").on("click",function(){
    // 登録情報の要素を取得
    const question_title = document.getElementById('question_title');
    const answer_content = document.getElementById('answer_content');
    try {
        // 入力されているかチェック
        if (!question_title.value){
            throw new Error('タイトルが入力されていません。');
        }
        if (!answer_content.value){
            throw new Error('回答が入力されていません。');
        }
        // 文字数チェック
        if (question_title.value.length > 100){
            throw new Error('タイトルの文字数がオーバーしています。');
        }
        if (answer_content.value.length > 500){
            throw new Error('回答の文字数がオーバーしています。');
        }
        const question_register_form = document.getElementById('question_register_form');
        const result = window.confirm('よくある質問を投稿しますか？');
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true) {
            question_register_form.submit();
        }
    } catch (e) {
        alert(e.message);
        return false;
    }
});