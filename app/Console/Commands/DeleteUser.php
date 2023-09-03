<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes an existing user that can log in to the webinterface';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $username = $this->argument('username');

        if ($this->ask("Are you sure you want to delete the user '$username' (y/n)")) {
            try {
                $user = User::where('username', $username)->firstOrFail();
            } catch (Exception) {
                $this->error('Could not find an user with this username');
                return Command::FAILURE;
            }

            $user->delete();
        }

        return Command::SUCCESS;
    }
}
