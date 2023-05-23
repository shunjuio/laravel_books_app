<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Jobs\SendLendingRemindMailJob;

class SendLendingRemindMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $lendings;

    /**
     * Create a new message instance.
     */
    /**
     * @param \Illuminate\Database\Eloquent\Collection $lendings
     */
    public function __construct(Collection $lendings)
    {
        $this->lendings = $lendings;
    }

    /**
     * Get the message envelope.
     * //     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【お知らせ】本の返却日をご確認ください',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        foreach ($this->lendings as $lending) {
            $lending->book->image = storage_path('app/public/' . $lending->book->image_path);
        }

        return new Content(
            view: 'lendings.mail',
            with: [
                'lendings' => $this->lendings,
            ],
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
