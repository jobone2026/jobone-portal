<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * NOTE: Server runs on UTC. IST = UTC+5:30
     */
    protected function schedule(Schedule $schedule): void
    {
        // ── Health check: 6:55 AM IST = 01:25 UTC ──────────────────────────
        $schedule->command('health:check')
            ->dailyAt('01:25')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Health check failed at 6:55 AM IST (01:25 UTC)');
            });

        // ── Sitemap: 2:00 AM IST = 20:30 UTC (prev day) ────────────────────
        $schedule->command('sitemap:generate')
            ->dailyAt('20:30')
            ->withoutOverlapping();

        // ── Cache cleanup: 2:30 AM IST = 21:00 UTC (prev day) ───────────────
        $schedule->command('cache:cleanup --max-size=100')
            ->dailyAt('21:00')
            ->withoutOverlapping();

        // ── Deadline alerts: 8:00 AM IST = 02:30 UTC ────────────────────────
        // Sends alerts for deadlines expiring today, tomorrow, +2, +3 days
        $schedule->command('notify:deadline-alerts --days=0,1,2,3')
            ->dailyAt('02:30')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Deadline alert (8AM IST / 02:30 UTC) failed');
            });

        // ── Midday deadline reminder: 12:00 PM IST = 06:30 UTC ──────────────
        // Reminds for TODAY-only deadlines
        $schedule->command('notify:deadline-alerts --days=0')
            ->dailyAt('06:30')
            ->withoutOverlapping()
            ->onFailure(function () {
                \Log::error('Midday deadline alert (12PM IST / 06:30 UTC) failed');
            });
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
