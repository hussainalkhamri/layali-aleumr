# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: bookings.spec.ts >> Bookings Management >> should update booking status
- Location: tests\e2e\bookings.spec.ts:47:3

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('table tbody tr').filter({ hasText: 'نوف العتيبي' }).first()
Timeout: 5000ms
- Expected substring  -  1
+ Received string     + 22

- مُسلَّم
+
+                         
+                             INV-2025002
+                             ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140
+                         
+                         
+                             نوف العتيبي
+                             0554445566
+                         
+                         فستان تاج الملكات
+                         04/05/2026
+                         7,500 ر.ي
+                         
+                             7,000 ر.ي
+                         
+                         
+                             نشط
+                         
+                         
+                             تعديل
+                         
+                     

Call log:
  - Expect "toContainText" with timeout 5000ms
  - waiting for locator('table tbody tr').filter({ hasText: 'نوف العتيبي' }).first()
    8 × locator resolved to <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">…</tr>
      - unexpected value "
                        
                            INV-2025002
                            ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140
                        
                        
                            نوف العتيبي
                            0554445566
                        
                        فستان تاج الملكات
                        04/05/2026
                        7,500 ر.ي
                        
                            7,000 ر.ي
                        
                        
                            نشط
                        
                        
                            تعديل
                        
                    "

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
          - button "+ حجز جديد" [ref=e69] [cursor=pointer]
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
              - option "كل الحالات"
              - option "نشط"
              - option "مستلم" [selected]
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
            - heading "تعديل الحجز" [level=3] [ref=e93]
            - button "✕" [ref=e94] [cursor=pointer]
          - generic [ref=e95]:
            - generic [ref=e96]:
              - generic [ref=e97]:
                - generic [ref=e98]: رقم الفاتورة (اختياري)
                - textbox "يترك فارغاً للتوليد التلقائي" [ref=e99]: INV-2025002
              - generic [ref=e100]:
                - generic [ref=e101]: نوع العقد *
                - combobox [ref=e102]:
                  - option "إيجار" [selected]
                  - option "بيع"
              - generic [ref=e103]:
                - generic [ref=e104]: الفستان *
                - combobox [active] [ref=e105]:
                  - option "— اختر الفستان —" [selected]
                  - option "فستان ليالي الأميرات (زفاف) — 8,000 ر.س"
                  - option "فستان سحر الليل (سهرة) — 5,000 ر.س"
                  - option "فستان زهرة الياسمين (زفاف) — 10,000 ر.س"
                  - option "فستان لمسة الذهب (ملكة) — 7,000 ر.س"
                  - option "فستان نسمة الورد (خطوبة) — 4,000 ر.س"
                  - option "فستان ملكة سبأ (زفاف) — 12,000 ر.س"
                  - option "فستان أنوار القمر (سهرة) — 6,000 ر.س"
                  - option "فستان حلم العروس (زفاف) — 9,000 ر.س"
                  - option "فستان تاج الملكات (ملكة) — [تنظيف] — 7,500 ر.س"
                  - option "فستان بريق النجوم (خطوبة) — 3,500 ر.س"
                  - option "Test Dress 1777284300864 (Updated) (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284376206 (Updated) (Updated) (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284412929 (زفاف) — 1,500 ر.س"
                  - option "Test Dress 1777284430005 (Updated) (زفاف) — 1,500 ر.س"
                  - option "Booking Test Dress 1777284678508 (زفاف) — 2,000 ر.س"
                  - option "Dress_1777284724960 (زفاف) — 2,000 ر.س"
              - generic [ref=e106]:
                - generic [ref=e107]: الحالة
                - combobox [ref=e108]:
                  - option "نشط" [selected]
                  - option "مسلم"
                  - option "مكتمل"
                  - option "ملغى"
              - generic [ref=e109]:
                - generic [ref=e110]: اسم العميل *
                - textbox [ref=e111]: نوف العتيبي
              - generic [ref=e112]:
                - generic [ref=e113]: رقم الجوال *
                - textbox [ref=e114]: "0554445566"
              - generic [ref=e115]:
                - generic [ref=e116]: تاريخ الفرح *
                - textbox [ref=e117]: 2026-05-13
              - generic [ref=e118]:
                - generic [ref=e119]: تاريخ الاستلام *
                - textbox [ref=e120]: 2026-05-04
              - generic [ref=e121]:
                - generic [ref=e122]: تاريخ الإرجاع
                - textbox [ref=e123]: 2026-05-09
              - generic [ref=e124]:
                - generic [ref=e125]: نسبة الخصم %
                - spinbutton [ref=e126]: "0"
              - generic [ref=e127]:
                - generic [ref=e128]: المبلغ الإجمالي *
                - spinbutton [ref=e129]: "7500.00"
              - generic [ref=e130]:
                - generic [ref=e131]: المبلغ المدفوع مقدماً
                - spinbutton [ref=e132]: "500.00"
              - generic [ref=e133]:
                - generic [ref=e134]: المبلغ المتبقي *
                - spinbutton [ref=e135]: "7000"
              - generic [ref=e136]:
                - generic [ref=e137]: طريقة دفع العربون
                - combobox [ref=e138]:
                  - option "نقدي" [selected]
                  - option "حوالة"
              - generic [ref=e139]:
                - generic [ref=e140]: تعديلات الفستان
                - textbox [ref=e141]
              - generic [ref=e142]:
                - generic [ref=e143]: ملاحظات
                - textbox [ref=e144]: حجز تجريبي من النظام
            - generic [ref=e145]:
              - button "إلغاء" [ref=e146] [cursor=pointer]
              - button "تحديث الحجز" [ref=e147] [cursor=pointer]
        - table [ref=e150]:
          - rowgroup [ref=e151]:
            - row "# العميل الفستان تاريخ الاستلام الإجمالي المتبقي الحالة إجراءات" [ref=e152]:
              - columnheader "#" [ref=e153]
              - columnheader "العميل" [ref=e154]
              - columnheader "الفستان" [ref=e155]
              - columnheader "تاريخ الاستلام" [ref=e156]
              - columnheader "الإجمالي" [ref=e157]
              - columnheader "المتبقي" [ref=e158]
              - columnheader "الحالة" [ref=e159]
              - columnheader "إجراءات" [ref=e160]
          - rowgroup [ref=e161]:
            - 'row "INV-2025002 ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140 نوف العتيبي 0554445566 فستان تاج الملكات 04/05/2026 7,500 ر.ي 7,000 ر.ي نشط تعديل" [ref=e162]':
              - 'cell "INV-2025002 ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140" [ref=e163]':
                - generic [ref=e164]: INV-2025002
                - text: "ID: 8c9301aa-00b9-4966-b44b-f2723e3e0140"
              - cell "نوف العتيبي 0554445566" [ref=e165]:
                - paragraph [ref=e166]: نوف العتيبي
                - paragraph [ref=e167]: "0554445566"
              - cell "فستان تاج الملكات" [ref=e168]
              - cell "04/05/2026" [ref=e169]
              - cell "7,500 ر.ي" [ref=e170]
              - cell "7,000 ر.ي" [ref=e171]
              - cell "نشط" [ref=e172]
              - cell "تعديل" [ref=e173]:
                - button "تعديل" [ref=e174] [cursor=pointer]
            - 'row "INV-2025003 ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a ليلى الحربي 0567778899 فستان تاج الملكات 05/05/2026 7,500 ر.ي 7,000 ر.ي نشط تعديل" [ref=e175]':
              - 'cell "INV-2025003 ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a" [ref=e176]':
                - generic [ref=e177]: INV-2025003
                - text: "ID: 8f0e7ba9-4da3-46f0-8c67-fcb53b5f700a"
              - cell "ليلى الحربي 0567778899" [ref=e178]:
                - paragraph [ref=e179]: ليلى الحربي
                - paragraph [ref=e180]: "0567778899"
              - cell "فستان تاج الملكات" [ref=e181]
              - cell "05/05/2026" [ref=e182]
              - cell "7,500 ر.ي" [ref=e183]
              - cell "7,000 ر.ي" [ref=e184]
              - cell "نشط" [ref=e185]
              - cell "تعديل" [ref=e186]:
                - button "تعديل" [ref=e187] [cursor=pointer]
            - 'row "INV-2025001 ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc فاطمة الزهراني 0501112233 فستان ليالي الأميرات 03/05/2026 8,000 ر.ي 7,500 ر.ي نشط تعديل" [ref=e188]':
              - 'cell "INV-2025001 ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc" [ref=e189]':
                - generic [ref=e190]: INV-2025001
                - text: "ID: cee0bfcd-c3ed-454b-b4ba-e7eb668a62dc"
              - cell "فاطمة الزهراني 0501112233" [ref=e191]:
                - paragraph [ref=e192]: فاطمة الزهراني
                - paragraph [ref=e193]: "0501112233"
              - cell "فستان ليالي الأميرات" [ref=e194]
              - cell "03/05/2026" [ref=e195]
              - cell "8,000 ر.ي" [ref=e196]
              - cell "7,500 ر.ي" [ref=e197]
              - cell "نشط" [ref=e198]
              - cell "تعديل" [ref=e199]:
                - button "تعديل" [ref=e200] [cursor=pointer]
          - rowgroup [ref=e201]:
            - 'row "الإجمالي الكلي: 23,000 ر.ي 21,500 ر.ي" [ref=e202]':
              - cell "الإجمالي الكلي:" [ref=e203]
              - cell "23,000 ر.ي" [ref=e204]
              - cell "21,500 ر.ي" [ref=e205]
              - cell [ref=e206]
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
  20 |     await page.selectOption('select[name="dress_id"]', { label: new RegExp(dressName) });
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
> 62 |     await expect(updatedRow).toContainText('مُسلَّم');
     |                              ^ Error: expect(locator).toContainText(expected) failed
  63 |   });
  64 | });
  65 | 
```