<?php

namespace App\Console\Commands;

use App\User;
use App\Models\Screenshot;
use Illuminate\Console\Command;

class AssignUserToUnassignedScreenshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'screenshots:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will assign a user to screenshots without a user assigned to it. (Temporary command, will be removed in v2 or v3)';

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

        $choices = [];
        foreach($users as $user) {
            array_push($choices, $user->email);
        }

        $email = $this->choice('To which user would to like to assign all screenshots without a user to?', $choices);

        $user = User::where('email', '=', $email)
            ->first();

        $screenshots = Screenshot::where('user_id', '=', null)
            ->update([
                'user_id' => $user->id,
            ]);

        $this->info('Succesfully updated the unassigned screenshots!');
    }
}
