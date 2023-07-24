<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:add {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user that can log in to the webinterface';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $password = $this->secret('Please enter the password for the new user');
        try {
            User::create([
                'username' => $this->argument('username'),
                'password' => Hash::make($password),
            ]);
        } catch (Exception) {
            $this->error('Could not create user, does it already exist?');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
