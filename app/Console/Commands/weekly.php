<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rat;
use App\Models\Cat;

class weekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rats:silka';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every week';

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
        // Get all the data from the rats table
        $rats = Rat::all();

        // Insert the data into the cats table
        foreach ($rats as $rat) {
            Cat::create([
                'notices' => $rat->notices,
                'department_id' => $rat->department_id,
            ]);
        }

        return 0;
    }
}
