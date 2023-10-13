<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $email_data;
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    public function build()
    {
        $data = $this->email_data;
        //dd($data);
        $return = $this->subject($this->email_data['subject'])
            ->view('mail.template', compact("data"));

        if (isset($this->email_data['attachments']) && !empty($this->email_data['attachments'])) {
            $return->attach($this->email_data['attachments']);
        }

        return $return;
    }

    /**
     * Get the message envelope.
     */
    /*public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Custom Mail',
        );
    }*/

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    /*public function attachments(): array
    {
        return [];
    }*/
}
