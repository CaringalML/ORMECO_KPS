<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Cat;

class every_10th_of_the_month extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:bible';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will notify users every 10th day of the month';

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
        // Get all the data from the books table
        $books = Book::all();

        // Insert the data into the cats table
        foreach ($books as $book) {
            Cat::create([
                'notices' => $book->notices,
                'department_id' => $book->department_id,
            ]);
        }

        return 0;
    }
}
