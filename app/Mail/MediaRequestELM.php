<?php

namespace App\Mail;

// use App\Mail\MediaRequest;
use App\Models\MediaRequests;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class MediaRequestELM extends Mailable
{
    use Queueable, SerializesModels;

    public $userEmail, $orderNumber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public MediaRequests $mediaRequests,
        public User $user

    ) {

        $this->userEmail = $user->email;
        $this->orderNumber = $mediaRequests->order_number;
    }


    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: $this->userEmail,
            to: 'hello@eyelookmedia.com',
            subject: ('Canadian Tire Ad Request# ' . $this->orderNumber)

        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.media-request',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
