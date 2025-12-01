<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
	public function run(): void
	{
		// Define permissions per domain/module
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

			// Services
			'view services',
			'create service',
			'edit service',
			'delete service',

			// Visits
			'view visits',
			'create visit',
			'edit visit',
			'delete visit',

			// Reservations
			'view reservations',
			'create reservation',
			'edit reservation',
			'delete reservation',

			// Patients
			'view patients',
			'create patient',
			'edit patient',
			'delete patient',

			// Drugs
			'view drugs',
			'create drug',
			'edit drug',
			'delete drug',
			'import drugs',
			'export drugs',

			// Examinations
			'view examinations',
			'create examination',
			'edit examination',
			'delete examination',
			'print prescription',

			// Reports
			'view reports',
			'generate reports',
		];

		// Create permissions if not exists
		foreach ($permissions as $permission) {
			Permission::firstOrCreate(['name' => $permission]);
		}

		// Create roles
		$roles = [
			'super-admin',
			'admin',
			'doctor',
			'receptionist',
			'pharmacist',
			'reporter',
		];

		foreach ($roles as $roleName) {
			Role::firstOrCreate(['name' => $roleName]);
		}

		// Assign permissions to roles
		$allPermissions = Permission::pluck('name')->toArray();

		// super-admin gets everything
		Role::where('name', 'super-admin')->first()?->syncPermissions($allPermissions);

		// Admin
		$adminPermissions = [
			'view dashboard',
			// Users
			'view users', 'create user', 'edit user', 'delete user',
			// Roles & Permissions
			'view roles', 'create role', 'edit role', 'delete role',
			'view permissions', 'create permission', 'edit permission', 'delete permission',
			// Settings
			'view settings', 'edit settings',
			// Core modules
			'view services', 'create service', 'edit service', 'delete service',
			'view visits', 'create visit', 'edit visit', 'delete visit',
			'view patients', 'create patient', 'edit patient', 'delete patient',
			'view drugs', 'create drug', 'edit drug', 'delete drug', 'import drugs', 'export drugs',
			'view examinations', 'create examination', 'edit examination', 'delete examination', 'print prescription',
			// Reports
			'view reports', 'generate reports',
		];
		Role::where('name', 'admin')->first()?->syncPermissions($adminPermissions);

		// Doctor
		$doctorPermissions = [
			'view dashboard',
			'view patients', 'create patient', 'edit patient',
			'view visits', 'create visit', 'edit visit',
			'view examinations', 'create examination', 'edit examination', 'print prescription',
			'view drugs',
			'view reports',
		];
		Role::where('name', 'doctor')->first()?->syncPermissions($doctorPermissions);

		// Receptionist
		$receptionistPermissions = [
			'view dashboard',
			'view patients', 'create patient', 'edit patient',
			'view visits', 'create visit', 'edit visit',
			'view services',
			'view reports',
		];
		Role::where('name', 'receptionist')->first()?->syncPermissions($receptionistPermissions);

		// Pharmacist
		$pharmacistPermissions = [
			'view dashboard',
			'view drugs', 'edit drug',
			'view examinations', 'print prescription',
		];
		Role::where('name', 'pharmacist')->first()?->syncPermissions($pharmacistPermissions);

		// Reporter (read-only reporting)
		$reporterPermissions = [
			'view dashboard',
			'view reports', 'generate reports',
		];
		Role::where('name', 'reporter')->first()?->syncPermissions($reporterPermissions);
	}
}
