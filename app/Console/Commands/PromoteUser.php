<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class PromoteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:promote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give admin rights to a user';

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
        $users = User::all();
        if(count($users) >! 0) {
            return $this->info('There are no users found!');
        }

        $choices = [];
        foreach($users as $user) {
            array_push($choices, $user->email);
        }

        $email = $this->choice('Which user do you want to assign admin rights to?', $choices);

        $user = User::where('email', '=', $email)
            ->first();

        $user->assignRole('admin');
        $this->info('Admin rights succesfully given!');
    }
}
