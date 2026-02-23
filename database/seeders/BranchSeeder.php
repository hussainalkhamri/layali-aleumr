<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create(['name' => 'فرع صنعاء - حدة',      'location' => 'حي حدة، شارع صفر، صنعاء',             'phone' => '01211111', 'whatsapp' => '967771111111']);
        Branch::create(['name' => 'فرع صنعاء - السبعين',  'location' => 'حي السبعين، جولة المصباحي، صنعاء',    'phone' => '01222222', 'whatsapp' => '967772222222']);
        Branch::create(['name' => 'فرع صنعاء - الصافية',  'location' => 'حي الصافية، شارع تعز، صنعاء',         'phone' => '01333333', 'whatsapp' => '967773333333']);
    }
}
