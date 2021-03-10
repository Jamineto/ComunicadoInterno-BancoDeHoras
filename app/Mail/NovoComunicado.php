<?php

namespace App\Mail;

use App\Models\Comunicado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovoComunicado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comunicado $comunicado)
    {
        $this->comunicado = $comunicado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('comunicado@santacasapv.com')
                    ->with(['autor' => $this->comunicado->autor->name, 'assunto' => $this->comunicado->assunto,'id' => $this->comunicado->id])
                    ->markdown('email.novo-comunicado');
    }
}
