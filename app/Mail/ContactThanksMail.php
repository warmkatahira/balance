<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, $title, $content, $contact_user_email)
    {
        // 使用する情報を取得
        $this->user_name = $user_name;
        $this->title = $title;
        $this->content = $content;
        $this->contact_user_email = $contact_user_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->contact_user_email)
            ->subject('【日次収支システム】問い合わせを受け付けました')
            ->view('contact.thanks_mail')
            ->with([
                'user_name' => $this->user_name,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
