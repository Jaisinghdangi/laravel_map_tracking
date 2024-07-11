<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPDFEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $pathToFile;

    /**
     * Create a new message instance.
     */
    public function __construct($pathToFile)
    {
        $this->pathToFile = $pathToFile;
   }

    public function build()
{
    return $this->view('emails.sendpdf')
                ->attach($this->pathToFile, [
                    'as' => 'invoice.pdf',
                    'mime' => 'application/pdf',
                ]);
}
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send P D F Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sendpdf',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
