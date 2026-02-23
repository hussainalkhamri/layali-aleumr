import { test, expect } from '@playwright/test';

test.describe('Bookings Management', () => {
  test('should create a complete booking with automatic calculations', async ({ page }) => {
    // 1. Create a fresh dress to avoid conflicts
    await page.goto('/dresses');
    await page.click('button:has-text("+ إضافة فستان")');
    const dressName = `Dress_${Date.now()}`;
    await page.fill('input[name="name"]', dressName);
    await page.fill('input[name="dress_type"]', 'زفاف');
    await page.fill('input[name="rental_price"]', '2000');
    await page.click('button[type="submit"]:has-text("حفظ")');
    await expect(page.locator('table')).toContainText(dressName);

    // 2. Go to bookings
    await page.goto('/bookings');
    await page.click('button:has-text("+ حجز جديد")');
    
    // 3. Select the new dress
    await page.selectOption('select[name="dress_id"]', { label: new RegExp(dressName) });
    
    // 4. Fill customer details
    const customerName = `Client_${Date.now()}`;
    await page.fill('input[name="customer_name"]', customerName);
    await page.fill('input[name="customer_phone"]', '0500000000');

    // 5. Set dates
    const nextWeek = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
    await page.fill('input[name="reserved_for_date"]', nextWeek);
    await page.fill('input[name="output_date"]', nextWeek);

    // 6. Calc check
    await page.fill('input[name="discount_percent"]', '10');
    await page.fill('input[name="paid_advance"]', '500');
    
    // Wait for Alpine.js calculation (2000 - 10% = 1800. 1800 - 500 = 1300)
    await expect(page.locator('input[name="remaining_amount"]')).toHaveValue('1300');

    // 7. Submit
    await page.click('button[type="submit"]:has-text("حفظ الحجز")');
    await page.waitForURL('**/bookings');

    // 8. Verify in table
    await expect(page.locator('table')).toContainText(customerName);
  });

  test('should update booking status', async ({ page }) => {
    await page.goto('/bookings');

    // Find any row that has "نشط" status
    const activeRow = page.locator('table tbody tr', { hasText: 'نشط' }).first();
    const customerName = await activeRow.locator('td').nth(1).locator('p').first().textContent();
    
    await activeRow.locator('button:has-text("تعديل")').click();

    // Change status to delivered
    await page.selectOption('select[name="status"]', 'delivered');
    await page.click('button[type="submit"]:has-text("تحديث الحجز")');

    // Verify status label changed for THIS specific customer
    const updatedRow = page.locator('table tbody tr', { hasText: customerName! }).first();
    await expect(updatedRow).toContainText('مُسلَّم');
  });
});
