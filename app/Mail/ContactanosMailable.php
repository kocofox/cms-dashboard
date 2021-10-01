<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $subjet = "Contactenos";
    public $correos;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($correos)
    {
        //
        $this->correos= $correos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return 
         $this->view('sendmail');
    }
}
