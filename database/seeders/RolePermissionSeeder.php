<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    use RefreshDatabase;

    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        Role::create(['name' => 'guest']);

        Permission::create(['name' => 'manage microsites']);

        $adminRole->givePermissionTo('manage microsites');
    }
}
