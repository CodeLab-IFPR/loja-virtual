<?php

namespace App\Mail;

use App\Models\Contato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoContato extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Contato $contato
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmação de Contato - Shalom',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contato.confirmacao',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}