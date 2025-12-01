<?php

namespace Database\Seeders;

use App\Domains\Auth\Models\Admin;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
	public function run(): void
	{
		$permissions = [
			'view dashboard',
			'view users','create user','edit user','delete user',
			'view roles','create role','edit role','delete role',
			'view permissions','create permission','edit permission','delete permission',
			'view settings','edit settings',
			'view services','create service','edit service','delete service',
			'view visits','create visit','edit visit','delete visit',
			'view reservations','create reservation','edit reservation','delete reservation',
			'view patients','create patient','edit patient','delete patient',
			'view drugs','create drug','edit drug','delete drug','import drugs','export drugs',
			'view examinations','create examination','edit examination','delete examination','print prescription',
			'view reports','generate reports',
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
