<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin {email} {password}';

    protected $description = 'Create an admin user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $email = (string) $this->argument('email');
        $password = bcrypt((string) $this->argument('password'));

        $user = User::create([
            'name' => 'admin',
            'email' => $email,
            'password' => $password,
        ]);

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($role);

        $this->info('Admin user created successfully');
    }
}
