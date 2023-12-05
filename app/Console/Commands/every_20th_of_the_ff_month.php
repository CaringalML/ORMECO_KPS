<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pen;
use App\Models\Cat;

class every_20th_of_the_ff_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pens:ballpen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 20th day of the month';

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
        // Retrieve data from the pens table
        $pens = Pen::all();

        // Insert the data into the cats table
        foreach ($pens as $pen) {
            Cat::create([
                'notices' => $pen->notices,
                'department_id' => $pen->department_id,
            ]);
        }

        return 0;
    }
}
