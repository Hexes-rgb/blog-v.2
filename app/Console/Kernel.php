<?php

namespace App\Console;

use App\Console\Commands\SendingNewPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        Commands\SendingNewPostsCommand::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SendingNewPostsCommand::class)->dailyAt('12:00');
        // $schedule->command(SendingNewPostsCommand::class)->evenInMaintenanceMode()->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
