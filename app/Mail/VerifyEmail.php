<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $url;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $url, $token)
    {
        $this->name = $name;
        $this->url = $url;
        $this->token = $token;
    }


    public function build()
    {
        return $this->subject("Verifica tu correo electrónico")
            ->view('email.verify-email')
            ->with([
                'name' => $this->name,
                'url' => $this->url,
                'token' => $this->token,
            ]);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifica tu correo electrónico',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verify-email',
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