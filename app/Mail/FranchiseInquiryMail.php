<?php

namespace App\Mail;

use App\Models\FranchiseInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FranchiseInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public FranchiseInquiry $inquiry
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle candidature franchise — '.$this->inquiry->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.franchise-inquiry',
        );
    }
}
