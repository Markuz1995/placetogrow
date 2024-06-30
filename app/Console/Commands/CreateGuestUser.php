<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateGuestUser extends Command
{
    protected $signature = 'create:guest {email} {password}';

    protected $description = 'Create a guest user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));

        $user = User::create([
            'name' => 'user',
            'email' => $email,
            'password' => $password,
        ]);

        $role = Role::firstOrCreate(['name' => 'guest']);
        $user->assignRole($role);

        $this->info('Guest user created successfully');
    }
}
