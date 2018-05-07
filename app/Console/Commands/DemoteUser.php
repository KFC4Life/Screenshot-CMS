<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class DemoteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:demote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove someone\'s admin rights.';

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
        $users = User::role('admin')->get();
        if(count($users) >! 0) {
            return $this->info('There are no users with admin rights found!');
        }

        $choices = [];
        foreach($users as $user) {
            array_push($choices, $user->email);
        }

        $email = $this->choice('Which user do you want to demote?', $choices);

        $user = User::where('email', '=', $email)
            ->first();

        $user->removeRole('admin');
        $this->info('Admin rights succesfully deleted, user demoted!');
    }
}
