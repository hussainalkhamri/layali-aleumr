<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin    = Role::where('name', 'super_admin')->first();
        $branchManager = Role::where('name', 'branch_manager')->first();
        $employee      = Role::where('name', 'employee')->first();

        $branch1 = Branch::where('name', 'like', '%الرياض%')->first();
        $branch2 = Branch::where('name', 'like', '%جدة%')->first();

        User::create([
            'full_name'            => 'عبدالله المالكي',
            'username'             => 'admin',
            'password'             => 'admin123',
            'role_id'              => $superAdmin?->id,
            'branch_id'            => null,
            'phone'                => '0501234567',
            'is_active'            => true,
        ]);

        User::create([
            'full_name'            => 'محمد الشهري',
            'username'             => 'manager1',
            'password'             => 'manager123',
            'role_id'              => $branchManager?->id,
            'branch_id'            => $branch1?->id,
            'phone'                => '0507654321',
            'is_active'            => true,
        ]);

        User::create([
            'full_name'            => 'سارة العتيبي',
            'username'             => 'emp1',
            'password'             => 'emp123',
            'role_id'              => $employee?->id,
            'branch_id'            => $branch1?->id,
            'phone'                => '0509876543',
            'is_active'            => true,
        ]);

        User::create([
            'full_name'            => 'نورة القحطاني',
            'username'             => 'emp2',
            'password'             => 'emp123',
            'role_id'              => $employee?->id,
            'branch_id'            => $branch2?->id,
            'phone'                => '0503456789',
            'is_active'            => true,
        ]);
    }
}
