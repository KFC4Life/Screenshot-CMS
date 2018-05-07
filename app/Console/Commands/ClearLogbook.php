<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;

class ClearLogbook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logbook:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the logbook.';

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
     * @return mixed
     */
    public function handle()
    {
        // Get the log lines
        $log = Log::all();

        // Delete each logged action
        foreach($log as $line) {

            $line->delete();

        }

        // Return success message
        $this->info('Logbook succesfully cleared!');
    }
}
