<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Dress;
use Illuminate\Database\Seeder;

class DressSeeder extends Seeder
{
    public function run(): void
    {
        $b1 = Branch::where('name', 'like', '%حدة%')->first()?->id;
        $b2 = Branch::where('name', 'like', '%السبعين%')->first()?->id;
        $b3 = Branch::where('name', 'like', '%الصافية%')->first()?->id;

        $dresses = [
            ['name'=>'فستان ليالي الأميرات',  'dress_type'=>'زفاف',   'color'=>'أبيض ناصع',  'chest_size'=>'90','waist_size'=>'70','rental_price'=>8000, 'sale_price'=>25000,'branch'=>$b1,'catalog'=>true],
            ['name'=>'فستان سحر الليل',        'dress_type'=>'سهرة',   'color'=>'أسود ملكي',  'chest_size'=>'88','waist_size'=>'68','rental_price'=>5000, 'sale_price'=>15000,'branch'=>$b1,'catalog'=>true],
            ['name'=>'فستان زهرة الياسمين',    'dress_type'=>'زفاف',   'color'=>'أبيض عاجي',  'chest_size'=>'92','waist_size'=>'72','rental_price'=>10000,'sale_price'=>35000,'branch'=>$b1,'catalog'=>true],
            ['name'=>'فستان لمسة الذهب',       'dress_type'=>'ملكة',   'color'=>'ذهبي',       'chest_size'=>'86','waist_size'=>'66','rental_price'=>7000, 'sale_price'=>20000,'branch'=>$b2,'catalog'=>true],
            ['name'=>'فستان نسمة الورد',        'dress_type'=>'خطوبة',  'color'=>'وردي فاتح',  'chest_size'=>'84','waist_size'=>'64','rental_price'=>4000, 'sale_price'=>12000,'branch'=>$b2,'catalog'=>true],
            ['name'=>'فستان ملكة سبأ',         'dress_type'=>'زفاف',   'color'=>'أبيض مطرز',  'chest_size'=>'94','waist_size'=>'74','rental_price'=>12000,'sale_price'=>40000,'branch'=>$b2,'catalog'=>true],
            ['name'=>'فستان أنوار القمر',       'dress_type'=>'سهرة',   'color'=>'فضي',        'chest_size'=>'88','waist_size'=>'68','rental_price'=>6000, 'sale_price'=>18000,'branch'=>$b3,'catalog'=>true],
            ['name'=>'فستان حلم العروس',       'dress_type'=>'زفاف',   'color'=>'أبيض لؤلؤي', 'chest_size'=>'90','waist_size'=>'70','rental_price'=>9000, 'sale_price'=>30000,'branch'=>$b3,'catalog'=>true],
            ['name'=>'فستان تاج الملكات',      'dress_type'=>'ملكة',   'color'=>'بنفسجي ملكي','chest_size'=>'86','waist_size'=>'66','rental_price'=>7500, 'sale_price'=>22000,'branch'=>$b3,'catalog'=>false,'status'=>'cleaning'],
            ['name'=>'فستان بريق النجوم',      'dress_type'=>'خطوبة',  'color'=>'سماوي',      'chest_size'=>'82','waist_size'=>'62','rental_price'=>3500, 'sale_price'=>10000,'branch'=>$b1,'catalog'=>true],
        ];

        foreach ($dresses as $d) {
            Dress::create([
                'name'                => $d['name'],
                'dress_type'          => $d['dress_type'],
                'color'               => $d['color'],
                'chest_size'          => $d['chest_size'],
                'waist_size'          => $d['waist_size'],
                'rental_price'        => $d['rental_price'],
                'sale_price'          => $d['sale_price'],
                'current_branch_id'   => $d['branch'],
                'show_in_catalog'     => $d['catalog'],
                'current_status'      => $d['status'] ?? 'available',
                'max_usage_limit'     => 50,
                'current_usage_count' => rand(0, 15),
                'cleaning_days'       => 2,
                'is_active'           => true,
            ]);
        }
    }
}
