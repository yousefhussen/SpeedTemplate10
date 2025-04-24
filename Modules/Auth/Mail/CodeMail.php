<?php

namespace Modules\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        //from users codes get the latest activation code
        $code = $this->user->codes()->latest()->first();
        return $this->view('auth::emails.code')
            ->with(['code' => $code->code, 'code_type' => $code->code_type]);
    }
}
