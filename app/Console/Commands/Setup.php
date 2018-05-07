<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\User;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

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
        $this->createUser();

        Setting::create([
            'name' => 'upload_key',
            'value' => str_random(20),
        ]);

        $this->info('Installation succesfully finished, you can now login.');
    }

    public function createUser()
    {
        $user_email = $this->ask('Whats the email of the new user you want to create?');

        $user_password_raw = $this->secret('Whats the password you want to attach to the new user?');

        $user_name = $this->ask('Whats the name of the new user you\'re creating?');

        $user = User::create([
            'email' => $user_email,
            'name' => $user_name,
            'password' => bcrypt($user_password_raw),
            'api_token' => str_random(20),
        ]);

        $user->assignRole('admin');
    }
}
