<?php

use App\Models\Branch;
use App\Models\Dress;
use App\Models\Role;
use App\Models\User;
use App\Models\BookingInvoice;

beforeEach(function () {
    $this->adminRole = Role::create([
        'name' => 'super_admin',
        'permissions' => ['view_all_branches']
    ]);

    $this->managerRole = Role::create([
        'name' => 'branch_manager',
        'permissions' => ['manage_dresses']
    ]);

    $this->branchA = Branch::create(['name' => 'Branch A', 'location' => 'Loc A', 'is_active' => true]);
    $this->branchB = Branch::create(['name' => 'Branch B', 'location' => 'Loc B', 'is_active' => true]);

    $this->managerA = User::create([
        'role_id' => $this->managerRole->id,
        'branch_id' => $this->branchA->id,
        'full_name' => 'Manager A',
        'username' => 'manager_a',
        'password' => bcrypt('password'),
        'is_active' => true
    ]);
});

test('manager in branch A cannot see dresses from branch B', function () {
    $dressA = Dress::create([
        'name' => 'Dress A',
        'dress_type' => 'Type A',
        'current_branch_id' => $this->branchA->id,
        'current_status' => 'available',
        'is_active' => true
    ]);

    $dressB = Dress::create([
        'name' => 'Dress B',
        'dress_type' => 'Type B',
        'current_branch_id' => $this->branchB->id,
        'current_status' => 'available',
        'is_active' => true
    ]);

    $this->actingAs($this->managerA)
        ->get(route('dresses.index'))
        ->assertSee('Dress A')
        ->assertDontSee('Dress B');
});

test('super admin can see all dresses from all branches', function () {
    $superAdmin = User::create([
        'role_id' => $this->adminRole->id,
        'full_name' => 'Super Admin',
        'username' => 'super',
        'password' => bcrypt('password'),
        'is_active' => true
    ]);

    Dress::create([
        'name' => 'Dress A',
        'dress_type' => 'Type A',
        'current_branch_id' => $this->branchA->id,
        'current_status' => 'available',
        'is_active' => true
    ]);

    Dress::create([
        'name' => 'Dress B',
        'dress_type' => 'Type B',
        'current_branch_id' => $this->branchB->id,
        'current_status' => 'available',
        'is_active' => true
    ]);

    $this->actingAs($superAdmin)
        ->get(route('dresses.index'))
        ->assertSee('Dress A')
        ->assertSee('Dress B');
});
