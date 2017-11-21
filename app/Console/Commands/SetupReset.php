<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\User;

class SetupReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In case the setup goes wrong you can reset the installation process.';

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
        // Truncate Settings and Users table
        Setting::query()->truncate();
        User::query()->truncate();

        // Send message
        $this->info('Done, you can now reinstall your application with php artisan setup:run.');
    }
}
