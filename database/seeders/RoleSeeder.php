<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'super_admin',
            'permissions' => [
                'manage_branches', 'manage_users', 'manage_roles', 'manage_dresses',
                'create_booking', 'edit_booking', 'cancel_booking', 'create_receipt',
                'view_reports', 'view_audit', 'view_insights',
                'override_late_edits', 'view_all_branches', 'create_expense',
            ],
        ]);

        Role::create([
            'name' => 'branch_manager',
            'permissions' => [
                'manage_dresses', 'create_booking', 'edit_booking', 'cancel_booking',
                'create_receipt', 'view_reports',
                'override_late_edits', 'create_expense',
            ],
        ]);

        Role::create([
            'name' => 'employee',
            'permissions' => [
                'create_booking', 'create_receipt', 'create_expense',
            ],
        ]);
    }
}
