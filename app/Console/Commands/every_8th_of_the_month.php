<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cat;
use App\Models\Car;

class every_8th_of_the_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cars:lexus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 8th day of the month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all cars from the cars table
        $cars = Car::all();

        // Loop through each car and insert its data into the cats table
        foreach ($cars as $car) {
            Cat::create([
                'notices' => $car->notices,
                'department_id' => $car->department_id,
            ]);
        }

        return 0;
    }
}
