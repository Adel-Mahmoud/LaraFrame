<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Auth\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'view dashboard',
        
            // Users
            'view users',
            'create user',
            'edit user',
            'delete user',
        
            // Roles & Permissions
            'view roles',
            'create role',
            'edit role',
            'delete role',
        
            'view permissions',
            'create permission',
            'edit permission',
            'delete permission',
        
            // Settings
            'view settings',
            'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

		$roles = ['super-admin','admin'];

		foreach ($roles as $roleName) {
			Role::firstOrCreate(['name' => $roleName]);
		}

		$allPermissions = Permission::pluck('name')->toArray();
		Role::where('name','super-admin')->first()?->syncPermissions($allPermissions);

		$user = Admin::firstOrCreate(
			['email' => 'a@a.com'],
			[
				'name'     => 'Adel Mahmoud',
				'password' => Hash::make('00000000'),
			]
		);

		if (!$user->hasRole('super-admin')) {
			$user->assignRole('super-admin');
		}
	}
}
