<?php

namespace App\Console\Commands;

use App\Jobs\ReservationReminderJob;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SendReservationRemindEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-reservation-remind-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reservation Remind mails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $remindDate   = Carbon::today()->addDay(1);
        $reservations = Reservation::where('start_at', $remindDate)->with('user')->get();
        foreach ($reservations as $reservation) {
            ReservationReminderJob::dispatch($reservation);
        }
    }
}
