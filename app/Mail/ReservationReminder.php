<?php

namespace App\Mail;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Reservation $reservation,
    )
    {
        $reservation->display_start_at = Carbon::parse($reservation->start_at)->format('Y-m-d');
        $reservation->display_end_at = Carbon::parse($reservation->end_at)->format('Y-m-d');

    }

    /**
     * Get the message envelope.
     */
    public function envelope() : Envelope
    {
        return new Envelope(
            from: new Address('example@example.com', 'Book Manager'),
            subject: 'Reservation Reminder',
        );
    }


    /**
     * Get the message content definition.
     */
    public function content() : Content
    {
        return new Content(
            view: 'emails.reservation.reminder',
            with: [
                'bookTitle'            => $this->reservation->book->title,
                'reservationStartDate' => $this->reservation->display_start_at,
                'reservationEndDate'   => $this->reservation->display_end_at,
                'userName'             => $this->reservation->user->name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments() : array
    {
        return [];
    }
}
