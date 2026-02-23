<?php

use App\Models\Branch;
use App\Models\Dress;
use App\Models\Role;
use App\Models\User;
use App\Models\BookingInvoice;
use App\Models\Receipt;

beforeEach(function () {
    // Setup basic roles
    $this->adminRole = Role::create([
        'name' => 'super_admin',
        'permissions' => ['manage_dresses', 'create_booking']
    ]);

    $this->branch = Branch::create(['name' => 'Main Branch', 'location' => 'Riyadh', 'is_active' => true]);

    $this->user = User::create([
        'role_id' => $this->adminRole->id,
        'branch_id' => $this->branch->id,
        'full_name' => 'Admin User',
        'username' => 'admin',
        'password' => bcrypt('password'),
        'max_discount_percent' => 10,
        'is_active' => true
    ]);
});

test('it updates dress status and creates receipt when booking is created', function () {
    $dress = Dress::create([
        'name' => 'Blue Wedding Dress',
        'dress_type' => 'Wedding',
        'current_branch_id' => $this->branch->id,
        'current_status' => 'available',
        'rental_price' => 1000,
        'is_active' => true
    ]);

    $bookingData = [
        'dress_id' => $dress->id,
        'customer_name' => 'Jane Doe',
        'customer_phone' => '0500000000',
        'contract_type' => 'rental',
        'reserved_for_date' => now()->addDays(7)->format('Y-m-d'),
        'output_date' => now()->addDays(6)->format('Y-m-d'),
        'total_amount' => 1000,
        'paid_advance' => 200,
        'remaining_amount' => 800,
        'payment_method' => 'card',
        'discount_percent' => 0,
    ];

    $this->actingAs($this->user)
        ->post(route('bookings.store'), $bookingData)
        ->assertRedirect(route('bookings.index'));

    // Check Dress status
    expect($dress->fresh()->current_status)->toBe('booked');

    // Check Receipt
    $receipt = Receipt::where('amount', 200)->first();
    expect($receipt)->not->toBeNull()
        ->and($receipt->payment_method)->toBe('card')
        ->and($receipt->receipt_nature)->toBe('deposit');
});

test('it releases dress when booking is cancelled', function () {
    $dress = Dress::create([
        'name' => 'Red Party Dress',
        'dress_type' => 'Party',
        'current_branch_id' => $this->branch->id,
        'current_status' => 'booked',
        'is_active' => true
    ]);

    $booking = BookingInvoice::create([
        'dress_id' => $dress->id,
        'customer_name' => 'Jane Doe',
        'customer_phone' => '0500000000',
        'contract_type' => 'rental',
        'reserved_for_date' => now()->addDays(7),
        'output_date' => now()->addDays(6),
        'total_amount' => 1000,
        'paid_advance' => 0,
        'remaining_amount' => 1000,
        'status' => 'active',
        'created_by' => $this->user->id,
        'branch_id' => $this->branch->id
    ]);

    $this->actingAs($this->user)
        ->put(route('bookings.update', $booking), [
            'status' => 'cancelled'
        ])
        ->assertRedirect(route('bookings.index'));

    expect($dress->fresh()->current_status)->toBe('available');
});

test('it prevents exceeding max discount percent', function () {
    $dress = Dress::create([
        'name' => 'Dress X',
        'dress_type' => 'Type X',
        'current_branch_id' => $this->branch->id,
        'current_status' => 'available',
        'is_active' => true
    ]);

    $bookingData = [
        'dress_id' => $dress->id,
        'customer_name' => 'Jane Doe',
        'customer_phone' => '0500000000',
        'contract_type' => 'rental',
        'reserved_for_date' => now()->addDays(7)->format('Y-m-d'),
        'output_date' => now()->addDays(6)->format('Y-m-d'),
        'total_amount' => 1000,
        'paid_advance' => 0,
        'remaining_amount' => 1000,
        'discount_percent' => 20, // Limit is 10
    ];

    $this->actingAs($this->user)
        ->post(route('bookings.store'), $bookingData)
        ->assertSessionHasErrors(['discount_percent']);
});
