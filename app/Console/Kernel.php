<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\ResetQueues::class,
    ];


    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('queues:reset')->dailyAt('02:00');
        $schedule->command('queues:reset')->dailyAt('14:00');
        $schedule->command('queues:reset')->dailyAt('20:00');
    }


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
