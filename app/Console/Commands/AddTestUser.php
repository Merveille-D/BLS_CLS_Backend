<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-user {firstname} {lastname} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = new \App\Models\User();
        $user->firstname = $this->argument('firstname');
        $user->lastname = $this->argument('lastname');
        $user->email = $this->argument('email');
        $user->password = Hash::make('password');
        $user->save();

        $this->info('User created successfully');
    }
}
