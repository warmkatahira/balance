<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Base;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserStatusChangeMail;

class UserController extends Controller
{
    public function index()
    {   
        $roles = Role::all();
        $users = User::orderBy('id', 'asc')->get();
        $bases = Base::all();
        return view('user.index')->with([
            'users' => $users,
            'roles' => $roles,
            'bases' => $bases,
        ]);
    }

    public function update(Request $request)
    {
        // 情報を更新 
        for($i = 0; $i < count($request->user_id); $i++) {
            // 更新する対象を取得
            $user = User::find($request->user_id[$i]);
            $user->base_id = $request->base[$i];
            $user->name = $request->name[$i];
            $user->email = $request->email[$i];
            $user->role_id = $request->role[$i];
            $user->status = $request->status[$i];
            // statusが更新されているか判定(ステータスが変更されていて、無効から有効に変わった場合はメールを送る)
            $mail_send_flg = $user->isDirty("status") == true && $user->status == '1' ? True : False;
            $user->save();
            // フラグがTrueなら、メールを送信
            if($mail_send_flg == True){
                // メールを送信
                Mail::send(new UserStatusChangeMail($user->name, $user->email));
            }
        }
        return back();
    }
}
