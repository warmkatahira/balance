<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterMail;
use App\Models\Base;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // 拠点の情報を取得
        $bases = Base::all();
        return view('auth.register')->with([
            'bases' => $bases,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 21,
            'base_id' => $request->base_id,
        ]);

        event(new Registered($user));

        // 自動ログインさせない
        //Auth::login($user);
        // メールを送信
        Mail::send(new UserRegisterMail($request->name, $request->email));
        session()->flash('alert_success', $request->name."さんのユーザー登録が完了しました。\nシステム管理者の承認をお待ち下さい。");
        return back();
        //return redirect(RouteServiceProvider::HOME);
    }
}
