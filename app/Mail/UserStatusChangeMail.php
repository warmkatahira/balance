<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserStatusChangeMail extends Mailable
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
        $to = array($this->email);
        return $this->to($to)
            ->subject('【日次収支システム】ユーザー登録承認完了メール')
            ->view('auth.user-status-change')
            ->with([
                'user_name' => $this->user_name,
            ]);
    }
}
