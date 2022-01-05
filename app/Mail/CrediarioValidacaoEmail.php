<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Crediario;

class CrediarioValidacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $crediario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct(Crediario $crediario)
    {
        $this->crediario = $crediario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.crediario.validacao')->subject('Seu cadastro foi validado.');
    }
}
