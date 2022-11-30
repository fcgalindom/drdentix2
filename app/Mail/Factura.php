<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Factura extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $info;
     public $archivo;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data ,$pdf)
    {
        $this->archivo = $pdf;
        $this->info = $data;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->subject('Su factura ha sido creada')->view('correos.autor')->attach(public_path('pdfDcumentos/'.$this->archivo));
       return $this->subject('Su factura ha sido creada')->view('Factura')->attach($this->archivo);
    }
}
