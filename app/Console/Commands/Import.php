<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Models\Screenshot;
use Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Symfony\Component\Console\Helper\ProgressBar;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'screenshots:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import\'s screenshots.';

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
        // Load the folder
        $files = Storage::files('public/screenshots/');

        $bar = $this->output->createProgressBar(count($files));
        $user = User::role('admin')->first();

        $bar->start();

        foreach($files as $file) {

            switch(mime_content_type('storage/app/'.$file)) {
                case 'image/jpeg':
                    $name = basename($file, '.jpg');
                    break;
                case 'image/png':
                    $name = basename($file, '.png');
                    break;
                case 'image/gif':
                    $name = basename($file, '.gif');
                    break;
                default:
                    $name = basename($file);
                    break;
            }

            $file_time = filemtime('storage/app/'.$file);
            $time = Carbon::createFromTimestamp($file_time)->toDateTimeString();

            if($db_result = Screenshot::withTrashed()->where('name', '=', $name)->count() > 0) {
                // Do nothing
            } else {
                // Insert into the database

                Screenshot::create([
                    'name' => $name,
                    'type' => mime_content_type('storage/app/'.$file),
                    'full_name' => basename($file),
                    'created_at' => $time,
                    'updated_at' => $time,
                    'user_id' => $user->id,
                ]);

            }
            $bar->advance();

        }
        $bar->finish();
        $this->info('Importing completed.');

    }
}
