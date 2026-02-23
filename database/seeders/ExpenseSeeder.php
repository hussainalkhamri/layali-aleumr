<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();
        $users = User::all();

        if ($branches->isEmpty() || $users->isEmpty()) {
            return;
        }

        $expenseTypes = [
            'مستلزمات تنظيف',
            'كهرباء ومياه',
            'صيانة فساتين',
            'أدوات مكتبية',
            'رواتب إضافية',
        ];

        foreach (range(1, 10) as $i) {
            Expense::create([
                'id' => Str::uuid(),
                'branch_id' => $branches->random()->id,
                'logged_by' => $users->random()->id,
                'amount' => rand(50, 500),
                'description' => $expenseTypes[array_rand($expenseTypes)] . ' - مصروف رقم ' . $i,
            ]);
        }
    }
}
