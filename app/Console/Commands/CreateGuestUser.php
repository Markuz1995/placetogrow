<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateGuestUser extends Command
{
    protected $signature = 'create:guest';

    protected $description = 'Create a guest user';

    public function handle()
    {
        $name = $this->askForNonEmptyInput('Enter the name of the guest user');
        $email = $this->askForNonEmptyInput('Enter the email address of the guest user');
        $password = $this->askForNonEmptyInput('Enter the password for the guest user');

        $hashedPassword = bcrypt($password);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        $role = Role::firstOrCreate(['name' => 'guest']);
        $user->assignRole($role);

        $this->info('Guest user created successfully');
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
