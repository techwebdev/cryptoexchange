<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CheckPayment::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('payment:btc')->everyMinute();
        // $schedule->exec('payment:btc')->everyMinute();
        // $schedule->command('payment:btc')->cron('* * * * *');
        // $schedule->command('inspire')->hourly();
        // $schedule->exec('node /home/forge/script.js')->daily();
        // $schedule->command(CheckPayment::class)->everyMinute();
        // $schedule->command('payment:btc')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
