<?php

namespace App\Console\Commands;

use App\Jobs\SendLendingRemindMailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendLendingRemindMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:lending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send LendingRemindMail Command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $remindDate = Carbon::tomorrow();
        $users = User::with(['nowLendings' => function ($query) use ($remindDate) {
            $query->where('end_at', $remindDate);
        }])->get();

        foreach ($users as $user) {
            if ($user->nowLendings->count() > 0)
                SendLendingRemindMailJob::dispatch($user);
        }
    }
}
