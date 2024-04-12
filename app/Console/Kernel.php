<?php

declare(strict_types=1);

namespace App\Console;

use App\Actions\DailyRecord\PlaceDailyRecord;
use App\Actions\DailyRecord\SyncUncreatedDailyRecord;
use App\Actions\Profile\SaveProfile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected $commands = [
        SaveProfile::class,
        PlaceDailyRecord::class,
        SyncUncreatedDailyRecord::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('profile:hourly-sync 20')->hourly();
        $schedule->command('record:daily-sync')->dailyAt("23:30");
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
