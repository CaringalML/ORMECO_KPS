<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Machine;
use App\Models\Cat;

class every_fifthteenth_of_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machines:arduino';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 15th day of the month';

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
        $machines = Machine::all();

        foreach ($machines as $machine) {
            Cat::create([
                'notices' => $machine->notices,
                'department_id' => $machine->department_id,
            ]);
        }

        return 0;
    }
}
