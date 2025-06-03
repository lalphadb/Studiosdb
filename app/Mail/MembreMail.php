<?php

namespace App\Mail;

use App\Models\Membre;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembreMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Membre $membre,
        public string $subject,
        public string $messageContent,
        public ?string $template = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        $view = $this->template ? "emails.membres.{$this->template}" : 'emails.membres.custom';
        
        return new Content(
            view: $view,
            with: [
                'membre' => $this->membre,
                'messageContent' => $this->messageContent,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
