<?php

namespace App\Providers;

use App\Jobs\SendLendingRemindMailJob;
use Illuminate\Support\ServiceProvider;

class SendLendingRemindMailJobProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindMethod(SendLendingRemindMailJob::class.'@handle',
        function ($job, $app)
        {
            return $job->handle();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
