<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stack;
use App\Models\Cat;

class thirtieth_of_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stacks:patong';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 30th month';

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
        // Get all the data from the stacks table
        $stacks = Stack::all();

        // Insert the data into the cats table
        foreach ($stacks as $stack) {
            Cat::create([
                'notices' => $stack->notices,
                'department_id' => $stack->department_id,
            ]);
        }

        return 0;
    }
}
