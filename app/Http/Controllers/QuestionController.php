<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('question.index')->with([
            'questions' => $questions,
        ]);
    }

    public function register(Request $request)
    {
        // 権限があるか確認
        if(Auth::user()->role_id != 1){
            session()->flash('alert_danger', '権限がありません。');
            return back();
        }
        // 投稿処理
        $question = new Question();
        $question->create([
            'question_title' => $request->question_title,
            'answer_content' => $request->answer_content,
        ]);
        session()->flash('alert_success', '投稿が完了しました。');
        return back();
    }

    public function delete(Request $request)
    {
        // 権限があるか確認
        if(Auth::user()->role_id != 1){
            session()->flash('alert_danger', '権限がありません。');
            return back();
        }
        // 削除対象を取得
        $question = Question::where('question_id', $request->question_id)->first();
        // 削除を実施
        $question->delete();
        session()->flash('alert_success', '削除が完了しました。');
        return back();
    }
}
