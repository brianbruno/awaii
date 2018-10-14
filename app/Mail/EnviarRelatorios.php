<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarRelatorios extends Mailable
{
    use Queueable, SerializesModels;

    public $attach;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attach)
    {
        $this->attach = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $email = $this->view('emails.relatoriosgerenciais')
            ->subject('Relatórios Awaii App');
        foreach($this->attach as $filePath){
            $email->attachFromStorage($filePath);
        }
        return $email;
    }
}
