<?php

namespace Database\Seeders;

use App\Models\BookingInvoice;
use App\Models\Branch;
use App\Models\Dress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $dresses = Dress::all();
        $users = User::all();
        $branches = Branch::all();

        if ($dresses->isEmpty() || $users->isEmpty() || $branches->isEmpty()) {
            return;
        }

        $customers = [
            ['name' => 'فاطمة الزهراني', 'phone' => '0501112233'],
            ['name' => 'نوف العتيبي', 'phone' => '0554445566'],
            ['name' => 'ليلى الحربي', 'phone' => '0567778899'],
        ];

        foreach ($customers as $index => $customer) {
            $dress = $dresses->random();
            $branch = $branches->random();
            $user = $users->random();
            
            $totalAmount = $dress->rental_price;
            $paidAdvance = 500;
            $remaining = $totalAmount - $paidAdvance;

            BookingInvoice::create([
                'id' => Str::uuid(),
                'invoice_no' => 'INV-' . (2025001 + $index),
                'dress_id' => $dress->id,
                'created_by' => $user->id,
                'branch_id' => $branch->id,
                'contract_type' => 'rental',
                'customer_name' => $customer['name'],
                'customer_phone' => $customer['phone'],
                'reserved_for_date' => now()->addDays(rand(10, 30)),
                'output_date' => now()->addDays(rand(7, 9)),
                'return_date' => now()->addDays(rand(11, 13)),
                'total_amount' => $totalAmount,
                'paid_advance' => $paidAdvance,
                'remaining_amount' => $remaining,
                'discount_percent' => 0,
                'status' => 'active',
                'notes' => 'حجز تجريبي من النظام',
            ]);
        }
    }
}
