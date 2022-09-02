<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $email)
    {
        // 使用する情報を取得
        $this->user_name = $user_name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to = array('t.katahira@warm.co.jp');
        return $this->to($to)
            ->subject('ユーザー登録完了メール')
            ->view('auth.user-register')
            ->with([
                'user_name' => $this->user_name,
                'email' => $this->email,
            ]);
    }
}
