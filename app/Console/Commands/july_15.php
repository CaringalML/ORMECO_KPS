<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Computer;
use App\Models\Cat;

class july_15 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computers:bintana';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 15th day of July';

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
        // Get all the data from the computers table
        $computersData = Computer::all();

        // Insert the data into the cats table
        foreach ($computersData as $computer) {
            Cat::create([
                'notices' => $computer->notices,
                'department_id' => $computer->department_id,
            ]);
        }

        return 0;
    }
}
