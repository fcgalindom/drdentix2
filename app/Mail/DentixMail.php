<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DentixMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Información Dr Dentix";

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $cita;
    protected $type;

    public function __construct($cita, $type = 2)
    {
        $this->cita = $cita;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('MailDentix')->with([
            'data' => $this->cita,
            'type_petition' => $this->type,
        ]);
    }
}
