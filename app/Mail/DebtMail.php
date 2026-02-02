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

    //https://laravel.com/docs/12.x/mail
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
        //     from: new Address('sigmawallet01@gmail.com', 'WalletMaster'),
        subject: 'Új tartozási kérelem',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.debt-mail',
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
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('img/logo.png'))
        ];
    }
}
