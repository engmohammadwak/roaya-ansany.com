<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Donation $donation,
        public bool $success
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->success
            ? '✅ عملية دفع ناجحة — ' . number_format($this->donation->amount, 2) . ' ' . $this->donation->currency
            : '❌ فشلت عملية دفع — ' . number_format($this->donation->amount, 2) . ' ' . $this->donation->currency;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.payment-notification');
    }
}
