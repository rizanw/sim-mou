<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WillExpireDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $documents;
    public $curDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($documents)
    {
        $this->documents = $documents;
        $this->curDate = Carbon::now()->timezone('Asia/Jakarta');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Reminder: Document(s) that will be expired soon!")->markdown('emails.willExpireDocument')
            ->with('documents', $this->documents)
            ->with('curDate', $this->curDate);
    }
}
