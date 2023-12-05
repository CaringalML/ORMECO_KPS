<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Chair;
use App\Models\Cat;

class january_15 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chairs:upuan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 15th day of January';

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
        // Get all the data from the chairs table
        $chairs = Chair::all();

        // Insert the data into the cats table
        foreach ($chairs as $chair) {
            Cat::create([
                'notices' => $chair->notices,
                'department_id' => $chair->department_id,
            ]);
        }

        return 0;
    }
}
