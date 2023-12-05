<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cat;
use App\Models\Dog;

class every_1st_week_saturday_of_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dogs:bruce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 1st week Saturday of the month';

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
        // Retrieve all rows from the dogs table
        $dogs = Dog::all();

        // Insert data into the cats table
        foreach ($dogs as $dog) {
            Cat::create([
                'notices' => $dog->notices,
                'department_id' => $dog->department_id,
            ]);
        }

        return 0;
    }
}
