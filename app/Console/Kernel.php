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
        Commands\GenerateLogos::class,
        Commands\GenerateURLs::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send Logs via email
        $schedule->call(function() {
            \Mail::queue('emails.logs', [], function($message) {
                $message->to(config('mail.from.address'), config('mail.from.name'))->subject('Polenta - Logs générés pour le ' . date('d/m/Y'));

                $message->attach(storage_path() . '/logs/laravel-' . date('Y-m-d') . '.log');
            });
        })->daily()->at('23:00')
        ->when(function() {
            return \App::environment('production') && file_exists(storage_path() . '/logs/laravel-' . date('Y-m-d') . '.log');
        });

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
    }
}
