<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\every_1st_week_saturday_of_month;
use App\Console\Commands\every_5th;
use App\Console\Commands\every_8th_of_the_month;
use App\Console\Commands\every_10th_of_the_month;
use App\Console\Commands\every_20th_of_the_ff_month;
use App\Console\Commands\every_fifthteenth_of_month;
use App\Console\Commands\january_15;
use App\Console\Commands\july_15;
use App\Console\Commands\monthly;
use App\Console\Commands\thirtieth_of_month;
use App\Console\Commands\weekly;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\every_1st_week_saturday_of_month::class,
        Commands\every_5th::class,
        Commands\every_8th_of_the_month::class,
        Commands\every_10th_of_the_month::class,
        Commands\every_20th_of_the_ff_month::class,
        Commands\every_fifthteenth_of_month::class,
        Commands\january_15::class,
        Commands\july_15::class,
        Commands\monthly::class,
        Commands\thirtieth_of_month::class,
        Commands\weekly::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('dogs:bruce')->monthlyOn(1, '07:00')->saturdays()->runInBackground();
        $schedule->command('houses:bahay')->monthlyOn(5, '07:00')->runInBackground();
        $schedule->command('cars:lexus')->monthlyOn(8, '07:00')->runInBackground();
        $schedule->command('books:bible')->monthlyOn(10, '07:00')->runInBackground();
        $schedule->command('pens:ballpen')->monthlyOn(20, '07:00')->runInBackground();
        $schedule->command('machines:arduino')->monthlyOn(15, '07:00')->runInBackground();
        $schedule->command('chairs:upuan')->monthlyOn(15, '07:00')->when(function () {
            return date('m') == '01';
        })->runInBackground();
        $schedule->command('computers:bintana')->monthlyOn(15, '07:00')->when(function () {
            return date('m') == '07';
        })->runInBackground();
        $schedule->command('bats:paniki')->monthly()->at('07:00')->runInBackground();
        $schedule->command('stacks:patong')->monthlyOn(30, '07:00')->runInBackground();
        $schedule->command('rats:silka')->weekly()->mondays()->at('07:00')->runInBackground();
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
