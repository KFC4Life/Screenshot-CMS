<?php

namespace App\Commands;

use Illuminate\Console\Command;

Use App\User;
use Larapack\CommandValidation\Validateable;

class install extends Command
{
    use Validateable;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finish the installation.';

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
            // SET APP NAME
            $app_name = $this->ask('What do you want to call this new application?');
            $this->setEnvironmentValue('APP_NAME', $app_name);

            $this->info('App name is set and is now as follows: '. env('APP_NAME'));

            $this->createUser();

            $this->info('Installation succesfully finished, you can now login.');
    }

    public function migrate()
    {

    }

    public function createUser()
    {
        $user_name = $this->ask('Whats the name of the new user you want to make?');

        $user_email = $this->ask('Whats the email of the new user you\'re creating?');

        $user_password_raw = $this->secret('Whats the password you want to attach to the new user?');

        User::create([
            'email' => $user_email,
            'name' => $user_name,
            'password' => bcrypt($user_password_raw)
        ]);
    }

    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = strtok($str, "{$envKey}=");

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}
