<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\tartozasok;
use Illuminate\Mail\Mailables\Attachment;


class DebtMail extends Mailable
{
    use Queueable, SerializesModels;

     public tartozasok $tartozas;

    /**
     * Create a new message instance.
     */
    public function __construct(tartozasok $tartozas)
    {
        $this->tartozas = $tartozas;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Új tartozási kérelem',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.debts-mail',
            with: [
                "tartozas"  => $this->tartozas
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
}
