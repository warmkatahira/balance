<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Mail\ContactThanksMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function reception(Request $request)
    {
        // メールに使用する情報を取得
        $user_name = Auth::user()->name;
        $title = $request->title;
        $content = $request->content;
        $contact_user_email = Auth::user()->email;
        // メールを送信
        Mail::send(new ContactMail($user_name, $title, $content));
        Mail::send(new ContactThanksMail($user_name, $title, $content, $contact_user_email));
        session()->flash('alert_success', '問い合わせを受け付けました。');
        return back();
    }
}
