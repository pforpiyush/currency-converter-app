<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        /**
         * A schedular that consumes the queued job batches every 15 minutes
         * 
         * Initially wanted to schedule just the `ConversrionHistoryRateJob()` job
         * every fifteen minutes, but the data generation is reliant on data from
         * request so batched the jobs and call artisan command to consume queue
         * every fifteen minutes 
         */
        $schedule->command('queue:work --stop-when-empty --tries=3')
             ->everyFifteenMinutes()
             ->withoutOverlapping()
             ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
