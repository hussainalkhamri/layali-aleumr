<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) return;

        $actions = ['CREATE', 'UPDATE', 'DELETE'];
        $tables = ['dresses', 'bookings', 'expenses', 'users'];

        foreach (range(1, 15) as $i) {
            AuditLog::create([
                'id' => Str::uuid(),
                'user_id' => $users->random()->id,
                'action_type' => $actions[array_rand($actions)],
                'table_name' => $tables[array_rand($tables)],
                'record_id' => (string) Str::uuid(),
                'old_values' => null,
                'new_values' => ['sample' => 'data ' . $i],
            ]);
        }
    }
}
