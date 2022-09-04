<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $title, $content)
    {
        // 使用する情報を取得
        $this->user_name = $user_name;
        $this->title = $title;
        $this->content = $content;
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
            ->subject('【日次収支システム】問い合わせがきました')
            ->view('contact.reception_mail')
            ->with([
                'user_name' => $this->user_name,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
