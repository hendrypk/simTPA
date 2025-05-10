<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Permission Seeder
        $entities = [
            'student',
            'donor',
            'employee',
            'donate',
            'transaction',
            // 'financial planning',
            'setting',
            'permission',
            'role',
            'dashboard',
            'vendor'
        ];

        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($entities as $entity) {
            $availableActions = $entity === 'dashboard' ? ['view'] : $actions;
            foreach ($availableActions as $action) {
                $permissionName = "$action $entity";
                Permission::updateOrCreate(
                    [
                        'name' => $permissionName,
                        'guard_name' => 'web',
                    ],
                    [
                        'group_name' => $entity,
                    ]
                );
            }
        }

        //Role Seeder
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        $admin->syncPermissions(Permission::all());
        $user->syncPermissions(Permission::where('name', 'LIKE', 'view %')->get());

        //User Seeder
        $user = User::updateOrCreate(
            ['email' => 'hendryputra934@gmail.com'],
            [
                'name' => 'superadmin',
                'username' => 'superadmin',
                'phone' => '085842233005',
                'password' => Hash::make('superadmin'),
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $user->assignRole($adminRole);
        }
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
