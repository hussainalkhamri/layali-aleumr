# هيكلية المشروع (Project Structure) - نظام "ليالي العُمر"

استخدام **Laravel 12** مع **Blade** و **TailwindCSS** يعتبر خياراً مُمتازاً، سريع الإنتاجية (Rapid Development)، وآمناً جداً بفضل منظومة Laravel المتكاملة (Monolith). هذا يغيّر هيكلية المشروع ليكون في مستودع (Repository) واحد ويقلل من تعقيد الـ APIs وصيانة تطبيقين.

## 1. المستودع المركزي (Laravel 12 Monolith)

```text
layali-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Web/ (واجهات المتصفح الداخلي والنظام)
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── RoleController.php (إدارة الـ RBAC)
│   │   │   │   ├── DressController.php
│   │   │   │   ├── BookingController.php
│   │   │   │   ├── ReceiptController.php
│   │   │   │   ├── BranchController.php
│   │   │   │   └── InsightController.php (لعرض تحليلات Gemini)
│   │   │   └── PublicSite/ (الموقع العام للعملاء)
│   │   │       └── HomeController.php (الصفحة الرئيسية والكتالوج والتواصل)
│   │   ├── Middleware/
│   │   │   ├── RbacChecker.php (Spatie Permission Middleware)
│   │   │   └── BranchScopeMiddleware.php (لضمان رؤية המوظف لبيانات فرعه فقط - OBAC)
│   ├── Models/
│   │   ├── User.php
│   │   ├── Dress.php
│   │   ├── BookingInvoice.php
│   │   ├── Receipt.php
│   │   └── SystemInsight.php (لحفظ نصائح Gemini)
│   ├── Services/ (Business Logic)
│   │   ├── BookingManager.php (يفحص التعارض في התواريخ ويقوم بالـ Lock)
│   │   ├── GeminiAiClient.php (مسؤول عن إرسال الطلبات لـ Gemini API)
│   │   └── FinanceCalculator.php
│   └── Console/Commands/
│       └── GenerateAiInsights.php (مهمة مجدولة لطلب التحليلات من Gemini)
├── database/
│   ├── migrations/
│   └── seeders/ (مثل RoleSeeder, AdminSeeder)
├── resources/
│   ├── css/
│   │   └── app.css (Tailwind Directives)
│   ├── js/
│   │   └── app.js (Alpine.js للمكونات التفاعلية كالقوائم والتبويبات)
│   └── views/ (قوالب Blade)
│       ├── layouts/
│       │   ├── app.blade.php (التخطيط الأساسي المتجاوب للنظام)
│       │   ├── guest.blade.php (لصفحة الدخول للنظام)
│       │   └── public.blade.php (التخطيط الخاص بالموقع العام - SEO Friendly)
│       ├── components/ (مكونات Blade قابلة لإعادة الاستخدام)
│       │   ├── button.blade.php
│       │   ├── modal.blade.php
│       │   └── status-badge.blade.php
│       ├── pages/
│       │   ├── public/ (صفحات الموقع العام التسويقي)
│       │   │   ├── home.blade.php (الصفحة الرئيسية)
│       │   │   ├── catalog.blade.php (معرض الفساتين العام)
│       │   │   └── contact.blade.php (خرائط الفروع والتواصل)
│       │   ├── dashboard/
│       │   │   ├── admin.blade.php (يحتوي إحصائيات الإدارة وإشعارات AI)
│       │   │   └── employee.blade.php (أزرار للموبايل)
│       │   ├── dresses/
│       │   │   ├── index.blade.php (فلترة بحث الفساتين - Livewire مفيد هنا)
│       │   │   └── show.blade.php
│       │   ├── bookings/
│       │   │   ├── create.blade.php (خطوات تأكيد الطلب)
│       │   │   └── invoice-print.blade.php (نسخة معدة للطابعة الحرارية)
│       │   └── settings/
│       │       └── roles.blade.php
├── routes/
│   ├── web.php (المسارات الأساسية لصفحات Blade بالموقع والنظام)
│   └── console.php (لجدولة مهام Gemini)
├── tailwind.config.js
└── composer.json
```

## ملاحظات حول تقنيات الواجهة الأمامية (Frontend Tech)
- **Blade Components**: لترتيب الأنظمة وبناء مكون UI مرة واحدة.
- **Tailwind CSS**: للتصميم المتجاوب (Mobile First).
- **Alpine.js**: لسهولة فتح النوافذ المنبثقة (Modals) والقوائم المنسدلة دون كتابة JavaScript معقد.
- **Livewire 3 (اختياري مرجح)**: ينصح بشدة استخدامه في صفحة `bookings.create` نظراً للحاجة لاختيار (تاريخ) ثم إرسال طلب للسيرفر لجلب (الفساتين المتاحة) بلمح البصر دون تحديث الصفحة بالكامل (No Page Reload). المزيج (Laravel + Livewire + Tailwind) هو الأمثل لهذا المشروع.
