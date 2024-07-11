<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\Mailables\Attachment;

class SendImageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $imagePath;
    public $imageName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($imagePath, $imageName)
    {
        $this->imagePath = $imagePath;
        $this->imageName = $imageName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send_image')
                    ->attach($this->imagePath, [
                        'as' => $this->imageName,
                        'mime' => 'image/png',
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Image Mail',
        );
    }


   
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_image',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
          
        ];
    }
}
