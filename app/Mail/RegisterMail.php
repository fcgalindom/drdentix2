<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $patient;
    protected $user;

    public function __construct($patient, $user)
    {
        $this->patient = $patient;
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('MailDentix', [
            'patient' => $this->patient,
            'user' => $this->user,
            'type_petition' => 4,
        ]);
    }
}
