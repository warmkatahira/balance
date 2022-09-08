<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MessageTemplete;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMail;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::all();
        $message_templetes = MessageTemplete::all();
        return view('message.index')->with([
            'users' => $users,
            'message_templetes' => $message_templetes,
        ]);
    }

    public function register(Request $request)
    {
        // 権限があるか確認
        if(Auth::user()->role_id != 1){
            session()->flash('alert_danger', '権限がありません。');
            return back();
        }
        // 登録処理
        $message_templete = new MessageTemplete();
        $message_templete->create([
            'templete_name' => $request->register_name,
            'templete_title' => $request->register_title,
            'templete_content' => $request->register_content,
        ]);
        session()->flash('alert_success', '登録が完了しました。');
        return back();
    }

    public function message_templete_get_ajax($templete_id)
    {
        // 情報を取得
        $message_templete = MessageTemplete::where('message_templete_id', $templete_id)->first();
        // 結果を返す
        return response()->json([
            'message_templete' => $message_templete,
        ]);
    }

    public function send(Request $request)
    {
        // 宛先が全員だった場合
        if($request->to == 'all'){
            $users = User::all();
            foreach($users as $user){
                $this->send_part($user->id, $request);
            }
        }
        // 宛先が個人だった場合
        if($request->to != 'all'){
            $this->send_part($request->to, $request);
        }
        session()->flash('alert_success', 'メッセージを送信しました。');
        return back();
    }

    function send_part($user_id, $request)
    {
        // メールに使用する情報を取得
        $user = User::where('id', $user_id)->first();
        $title = $request->title;
        $content = $request->content;
        // メールを送信
        Mail::send(new MessageMail($user->name, $user->email, $title, $content));
        return;
    }
}
