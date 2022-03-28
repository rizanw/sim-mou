<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpireDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $documents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Today's Expired Document!")
            ->markdown('emails.expireDocument')
            ->with('documents', $this->documents);
    }
}
