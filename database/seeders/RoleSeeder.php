<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $admin = Role::firstOrCreate(['name' => 'admin']);
        // $user = Role::firstOrCreate(['name' => 'user']);

        // $admin->syncPermissions(Permission::all());
        // $user->syncPermissions(Permission::where('name', 'LIKE', 'view %')->get());

    }
}
