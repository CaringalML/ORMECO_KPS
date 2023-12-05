<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\House;
use App\Models\Cat;

class every_5th extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'houses:bahay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 5th day of the month';

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
        $houses = House::all();

        foreach ($houses as $house) {
            Cat::create([
                'notices' => $house->notices,
                'department_id' => $house->department_id,
            ]);
        }

        return 0;
    }
}
