# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: bookings.spec.ts >> Bookings Management >> should create a complete booking with automatic calculations
- Location: tests\e2e\bookings.spec.ts:4:3

# Error details

```
Error: page.selectOption: options[0].label: expected string, got object
```

# Page snapshot

```yaml
- generic [ref=e2]:
  - complementary [ref=e3]:
    - generic [ref=e4]:
      - img "نظام ليالي العُمر" [ref=e6]
      - paragraph [ref=e8]: نظام ليالي العُمر
    - navigation [ref=e9]:
      - link "⊞ لوحة التحكم" [ref=e10] [cursor=pointer]:
        - /url: http://localhost:8000
        - generic [ref=e11]: ⊞
        - generic [ref=e12]: لوحة التحكم
      - link "👗 الفساتين" [ref=e13] [cursor=pointer]:
        - /url: http://localhost:8000/dresses
        - generic [ref=e14]: 👗
        - generic [ref=e15]: الفساتين
      - link "📋 الحجوزات" [ref=e16] [cursor=pointer]:
        - /url: http://localhost:8000/bookings
        - generic [ref=e17]: 📋
        - generic [ref=e18]: الحجوزات
      - link "🧾 الإيصالات" [ref=e19] [cursor=pointer]:
        - /url: http://localhost:8000/receipts
        - generic [ref=e20]: 🧾
        - generic [ref=e21]: الإيصالات
      - link "💸 المصروفات" [ref=e22] [cursor=pointer]:
        - /url: http://localhost:8000/expenses
        - generic [ref=e23]: 💸
        - generic [ref=e24]: المصروفات
      - link "📅 التقويم" [ref=e25] [cursor=pointer]:
        - /url: http://localhost:8000/calendar
        - generic [ref=e26]: 📅
        - generic [ref=e27]: التقويم
      - link "🏬 الفروع" [ref=e28] [cursor=pointer]:
        - /url: http://localhost:8000/branches
        - generic [ref=e29]: 🏬
        - generic [ref=e30]: الفروع
      - link "👤 المستخدمون" [ref=e31] [cursor=pointer]:
        - /url: http://localhost:8000/users
        - generic [ref=e32]: 👤
        - generic [ref=e33]: المستخدمون
      - link "🔑 الأدوار" [ref=e34] [cursor=pointer]:
        - /url: http://localhost:8000/roles
        - generic [ref=e35]: 🔑
        - generic [ref=e36]: الأدوار
      - link "📝 سجل العمليات" [ref=e37] [cursor=pointer]:
        - /url: http://localhost:8000/audit-logs
        - generic [ref=e38]: 📝
        - generic [ref=e39]: سجل العمليات
      - link "✨ تحليلات AI" [ref=e40] [cursor=pointer]:
        - /url: http://localhost:8000/insights
        - generic [ref=e41]: ✨
        - generic [ref=e42]: تحليلات AI
    - generic [ref=e43]:
      - generic [ref=e44]:
        - generic [ref=e45]: ع
        - generic [ref=e46]:
          - paragraph [ref=e47]: عبدالله المالكي
          - paragraph [ref=e48]: الإدارة العامة
      - button "🚪 تسجيل الخروج" [ref=e50] [cursor=pointer]:
        - generic [ref=e51]: 🚪
        - generic [ref=e52]: تسجيل الخروج
  - generic [ref=e53]:
    - banner [ref=e54]:
      - button [ref=e55] [cursor=pointer]:
        - img [ref=e56]
      - generic [ref=e58]:
        - generic [ref=e59]: إدارة الحجوزات
        - button "تبديل المظهر" [ref=e60] [cursor=pointer]:
          - img [ref=e61]
    - main [ref=e63]:
      - generic [ref=e64]:
        - generic [ref=e65]:
          - button "طباعة" [ref=e66] [cursor=pointer]:
            - img [ref=e67]
            - text: طباعة
          - button "+ حجز جديد" [active] [ref=e69] [cursor=pointer]
        - generic [ref=e71]:
          - generic [ref=e72]:
            - generic [ref=e73]: البحث (الاسم، الجوال، رقم الفاتورة)
            - textbox "ابحث..." [ref=e74]
          - generic [ref=e75]:
            - generic [ref=e76]: الفرع
            - combobox [ref=e77]:
              - option "كل الفروع" [selected]
              - option "فرع صنعاء - حدة"
              - option "فرع صنعاء - السبعين"
              - option "فرع صنعاء - الصافية"
          - generic [ref=e78]:
            - generic [ref=e79]: الحالة
            - combobox [ref=e80]:
              - option "كل الحالات" [selected]
              - option "نشط"
              - option "مستلم"
              - option "مكتمل"
              - option "ملغي"
          - generic [ref=e81]:
            - generic [ref=e82]: من تاريخ
            - textbox [ref=e83]
          - generic [ref=e84]:
            - generic [ref=e85]: إلى تاريخ
            - textbox [ref=e86]
          - button "بحث" [ref=e88] [cursor=pointer]
        - generic [ref=e91]:
          - generic [ref=e92]:
            - heading "حجز جديد" [level=3] [ref=e93]
            - button "✕" [ref=e94] [cursor=pointer]
          - generic [ref=e95]:
            - generic [ref=e96]:
              - generic [ref=e97]:
                - generic [ref=e98]: رقم الفاتورة (اختياري)
                - textbox "يترك فارغاً للتوليد التلقائي" [ref=e99]
              - generic [ref=e100]:
                - generic [ref=e101]: نوع العقد *
                - combobox [ref=e102]:
                  - option "إيجار" [selected]
                  - option "بيع"
              - generic [ref=e103]:
                - generic [ref=e104]: الفستان *
                - combobox [ref=e105]:
                  - option "— اختر الفستان —" [selected]
                  - option "فستان ليالي الأميرات (زفاف) — 8,000 ر.س"
                  - option "فستان سحر الليل (سهرة) — 5,000 ر.س"
                  - option "فستان زهرة الياسمين (زفاف) — 10,000 ر.س"
                  - option "فستان لمسة الذهب (ملكة) — 7,000 ر.س"
                  - option "فستان نسمة الورد (خطوبة) — 4,000 ر.س"
                  - option "فستان ملكة سبأ (زفاف) — 12,000 ر.س"
                  - option "فستان أنوار القمر (سهرة) — 6,000 ر.س"
                  - option "فستان حلم العروس (زفاف) — 9,000 ر.س"
                  - option "فستان تاج الملكات (ملكة) — [تنظيف] — 7,500 ر.س" [disabled]
                  - option "فستان بريق النجوم (خطوبة) — 3,500 ر.س"
                  - option "Test Dress 1777284300864 (Updated) (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284376206 (Updated) (Updated) (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284412929 (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284430005 (Updated) (زفاف) — 1,500 ر.س"
                  - option "Booking Test Dress 1777284678508 (زفاف) — 2,000 ر.س"
                  - option "Dress_1777284724960 (زفاف) — 2,000 ر.س"
                  - option "Dress_1777287263218 (زفاف) — 2,000 ر.س"
              - generic [ref=e106]:
                - generic [ref=e107]: اسم العميل *
                - textbox [ref=e108]
              - generic [ref=e109]:
                - generic [ref=e110]: رقم الجوال *
                - textbox [ref=e111]
              - generic [ref=e112]:
                - generic [ref=e113]: تاريخ الفرح *
                - textbox [ref=e114]
              - generic [ref=e115]:
                - generic [ref=e116]: تاريخ الاستلام *
                - textbox [ref=e117]
              - generic [ref=e118]:
                - generic [ref=e119]: تاريخ الإرجاع
                - textbox [ref=e120]
              - generic [ref=e121]:
                - generic [ref=e122]: نسبة الخصم %
                - spinbutton [ref=e123]: "0"
              - generic [ref=e124]:
                - generic [ref=e125]: المبلغ الإجمالي *
                - spinbutton [ref=e126]: "0"
              - generic [ref=e127]:
                - generic [ref=e128]: المبلغ المدفوع مقدماً
                - spinbutton [ref=e129]: "0"
              - generic [ref=e130]:
                - generic [ref=e131]: المبلغ المتبقي *
                - spinbutton [ref=e132]: "0"
              - generic [ref=e133]:
                - generic [ref=e134]: طريقة دفع العربون
                - combobox [ref=e135]:
                  - option "نقدي" [selected]
                  - option "حوالة"
              - generic [ref=e136]:
                - generic [ref=e137]: تعديلات الفستان
                - textbox [ref=e138]
              - generic [ref=e139]:
                - generic [ref=e140]: ملاحظات
                - textbox [ref=e141]
            - generic [ref=e142]:
              - button "إلغاء" [ref=e143] [cursor=pointer]
              - button "حفظ الحجز" [ref=e144] [cursor=pointer]
        - table [ref=e147]:
          - rowgroup [ref=e148]:
            - row "# العميل الفستان تاريخ الاستلام الإجمالي المتبقي الحالة إجراءات" [ref=e149]:
              - columnheader "#" [ref=e150]
              - columnheader "العميل" [ref=e151]
              - columnheader "الفستان" [ref=e152]
              - columnheader "تاريخ الاستلام" [ref=e153]
              - columnheader "الإجمالي" [ref=e154]
              - columnheader "المتبقي" [ref=e155]
              - columnheader "الحالة" [ref=e156]
              - columnheader "إجراءات" [ref=e157]
          - rowgroup [ref=e158]:
            - 'row "INV-2025002 ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140 نوف العتيبي 0554445566 فستان تاج الملكات 04/05/2026 7,500 ر.ي 7,000 ر.ي نشط تعديل" [ref=e159]':
              - 'cell "INV-2025002 ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140" [ref=e160]':
                - generic [ref=e161]: INV-2025002
                - text: "ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140"
              - cell "نوف العتيبي 0554445566" [ref=e162]:
                - paragraph [ref=e163]: نوف العتيبي
                - paragraph [ref=e164]: "0554445566"
              - cell "فستان تاج الملكات" [ref=e165]
              - cell "04/05/2026" [ref=e166]
              - cell "7,500 ر.ي" [ref=e167]
              - cell "7,000 ر.ي" [ref=e168]
              - cell "نشط" [ref=e169]
              - cell "تعديل" [ref=e170]:
                - button "تعديل" [ref=e171] [cursor=pointer]
            - 'row "INV-2025003 ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a ليلى الحربي 0567778899 فستان تاج الملكات 05/05/2026 7,500 ر.ي 7,000 ر.ي نشط تعديل" [ref=e172]':
              - 'cell "INV-2025003 ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a" [ref=e173]':
                - generic [ref=e174]: INV-2025003
                - text: "ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a"
              - cell "ليلى الحربي 0567778899" [ref=e175]:
                - paragraph [ref=e176]: ليلى الحربي
                - paragraph [ref=e177]: "0567778899"
              - cell "فستان تاج الملكات" [ref=e178]
              - cell "05/05/2026" [ref=e179]
              - cell "7,500 ر.ي" [ref=e180]
              - cell "7,000 ر.ي" [ref=e181]
              - cell "نشط" [ref=e182]
              - cell "تعديل" [ref=e183]:
                - button "تعديل" [ref=e184] [cursor=pointer]
            - 'row "INV-2025001 ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc فاطمة الزهراني 0501112233 فستان ليالي الأميرات 03/05/2026 8,000 ر.ي 7,500 ر.ي نشط تعديل" [ref=e185]':
              - 'cell "INV-2025001 ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc" [ref=e186]':
                - generic [ref=e187]: INV-2025001
                - text: "ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc"
              - cell "فاطمة الزهراني 0501112233" [ref=e188]:
                - paragraph [ref=e189]: فاطمة الزهراني
                - paragraph [ref=e190]: "0501112233"
              - cell "فستان ليالي الأميرات" [ref=e191]
              - cell "03/05/2026" [ref=e192]
              - cell "8,000 ر.ي" [ref=e193]
              - cell "7,500 ر.ي" [ref=e194]
              - cell "نشط" [ref=e195]
              - cell "تعديل" [ref=e196]:
                - button "تعديل" [ref=e197] [cursor=pointer]
          - rowgroup [ref=e198]:
            - 'row "الإجمالي الكلي: 23,000 ر.ي 21,500 ر.ي" [ref=e199]':
              - cell "الإجمالي الكلي:" [ref=e200]
              - cell "23,000 ر.ي" [ref=e201]
              - cell "21,500 ر.ي" [ref=e202]
              - cell [ref=e203]
```

# Test source

```ts
  1  | import { test, expect } from '@playwright/test';
  2  | 
  3  | test.describe('Bookings Management', () => {
  4  |   test('should create a complete booking with automatic calculations', async ({ page }) => {
  5  |     // 1. Create a fresh dress to avoid conflicts
  6  |     await page.goto('/dresses');
  7  |     await page.click('button:has-text("+ إضافة فستان")');
  8  |     const dressName = `Dress_${Date.now()}`;
  9  |     await page.fill('input[name="name"]', dressName);
  10 |     await page.fill('input[name="dress_type"]', 'زفاف');
  11 |     await page.fill('input[name="rental_price"]', '2000');
  12 |     await page.click('button[type="submit"]:has-text("حفظ")');
  13 |     await expect(page.locator('table')).toContainText(dressName);
  14 | 
  15 |     // 2. Go to bookings
  16 |     await page.goto('/bookings');
  17 |     await page.click('button:has-text("+ حجز جديد")');
  18 |     
  19 |     // 3. Select the new dress
> 20 |     await page.selectOption('select[name="dress_id"]', { label: new RegExp(dressName) });
     |                ^ Error: page.selectOption: options[0].label: expected string, got object
  21 |     
  22 |     // 4. Fill customer details
  23 |     const customerName = `Client_${Date.now()}`;
  24 |     await page.fill('input[name="customer_name"]', customerName);
  25 |     await page.fill('input[name="customer_phone"]', '0500000000');
  26 | 
  27 |     // 5. Set dates
  28 |     const nextWeek = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
  29 |     await page.fill('input[name="reserved_for_date"]', nextWeek);
  30 |     await page.fill('input[name="output_date"]', nextWeek);
  31 | 
  32 |     // 6. Calc check
  33 |     await page.fill('input[name="discount_percent"]', '10');
  34 |     await page.fill('input[name="paid_advance"]', '500');
  35 |     
  36 |     // Wait for Alpine.js calculation (2000 - 10% = 1800. 1800 - 500 = 1300)
  37 |     await expect(page.locator('input[name="remaining_amount"]')).toHaveValue('1300');
  38 | 
  39 |     // 7. Submit
  40 |     await page.click('button[type="submit"]:has-text("حفظ الحجز")');
  41 |     await page.waitForURL('**/bookings');
  42 | 
  43 |     // 8. Verify in table
  44 |     await expect(page.locator('table')).toContainText(customerName);
  45 |   });
  46 | 
  47 |   test('should update booking status', async ({ page }) => {
  48 |     await page.goto('/bookings');
  49 | 
  50 |     // Find any row that has "نشط" status
  51 |     const activeRow = page.locator('table tbody tr', { hasText: 'نشط' }).first();
  52 |     const customerName = await activeRow.locator('td').nth(1).locator('p').first().textContent();
  53 |     
  54 |     await activeRow.locator('button:has-text("تعديل")').click();
  55 | 
  56 |     // Change status to delivered
  57 |     await page.selectOption('select[name="status"]', 'delivered');
  58 |     await page.click('button[type="submit"]:has-text("تحديث الحجز")');
  59 | 
  60 |     // Verify status label changed for THIS specific customer
  61 |     const updatedRow = page.locator('table tbody tr', { hasText: customerName! }).first();
  62 |     await expect(updatedRow).toContainText('مُسلَّم');
  63 |   });
  64 | });
  65 | 
```