<?php

namespace Database\Seeders;

use App\Models\SystemInsight;
use Illuminate\Database\Seeder;

class SystemInsightSeeder extends Seeder
{
    public function run(): void
    {
        SystemInsight::create([
            'title'   => 'فستان بطيء الحركة في فرع الدمام',
            'content' => "فستان 'تاج الملكات' لم يتم تأجيره منذ 45 يوماً في فرع الدمام. يُنصح بنقله إلى فرع الرياض حيث الطلب أعلى على الفساتين الملكية.",
            'level'   => 'WARNING',
        ]);

        SystemInsight::create([
            'title'   => 'موسم الأعراس قادم',
            'content' => 'بناءً على بيانات العام الماضي، من المتوقع ارتفاع الطلب بنسبة 40% خلال الشهرين القادمين. يُنصح بتجهيز ميزانية إضافية للتنظيف والصيانة.',
            'level'   => 'INFO',
        ]);

        SystemInsight::create([
            'title'   => 'فستان يقترب من حد الاستخدام',
            'content' => "فستان 'زهرة الياسمين' وصل إلى 45 مرة استخدام من أصل 50. يُنصح بمراجعة حالته وتقييم مدى صلاحيته للاستمرار في التأجير.",
            'level'   => 'CRITICAL',
        ]);
    }
}
