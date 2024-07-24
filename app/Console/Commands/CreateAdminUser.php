<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin';

    protected $description = 'Create an admin user';

    public function handle(): void
    {
        $name = $this->askForNonEmptyInput('Enter the name of the admin user');
        $email = $this->askForNonEmptyInput('Enter the email address of the admin user');
        $password = $this->askForNonEmptyInput('Enter the password for the admin user');

        $hashedPassword = bcrypt($password);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole($role);

        $this->info('Admin user created successfully');
    }

    /**
     * Ask for non-empty input.
     */
    private function askForNonEmptyInput(string $question): string
    {
        do {
            $input = $this->ask($question);
            if (empty($input)) {
                $this->error('This field is required.');
            }
        } while (empty($input));

        return $input;
    }
}
