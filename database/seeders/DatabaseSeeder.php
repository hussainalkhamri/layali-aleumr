<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            DressSeeder::class,
            BookingInvoiceSeeder::class,
            ReceiptSeeder::class,
            ExpenseSeeder::class,
            AuditLogSeeder::class,
            SystemInsightSeeder::class,
        ]);
    }
}
