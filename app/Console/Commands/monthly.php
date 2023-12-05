<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bat;
use App\Models\Cat;

class monthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bats:paniki';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every month';

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
        // Get all the data from the bats table
        $bats = Bat::all();

        // Insert the data into the cats table
        foreach ($bats as $bat) {
            Cat::create([
                'notices' => $bat->notices,
                'department_id' => $bat->department_id,
            ]);
        }

        return 0;
    }
}
