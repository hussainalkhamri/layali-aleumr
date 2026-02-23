import { test, expect } from '@playwright/test';

test.describe('Dresses Management', () => {
  test('should create a new dress', async ({ page }) => {
    await page.goto('/dresses');

    // Open add modal
    await page.click('button:has-text("+ إضافة فستان")');
    await expect(page.locator('h3:has-text("إضافة فستان جديد")')).toBeVisible();

    // Fill form
    const dressName = `Test Dress ${Date.now()}`;
    await page.fill('input[name="name"]', dressName);
    await page.fill('input[name="dress_type"]', 'زفاف');
    await page.fill('input[name="color"]', 'أبيض');
    await page.fill('input[name="rental_price"]', '1500');
    
    // Save
    await page.click('button[type="submit"]:has-text("حفظ")');

    // Verify in table
    await expect(page.locator('table')).toContainText(dressName);
  });

  test('should edit an existing dress', async ({ page }) => {
    await page.goto('/dresses');

    // Find first edit button
    const firstRow = page.locator('table tbody tr').first();
    const oldName = await firstRow.locator('td').first().textContent();
    
    await firstRow.locator('button:has-text("تعديل")').click();

    // Update name
    const newName = `${oldName} (Updated)`;
    await page.fill('input[name="name"]', newName);
    await page.click('button[type="submit"]:has-text("حفظ")');

    // Verify change
    await expect(page.locator('table')).toContainText(newName);
  });

  test('should filter dresses by status', async ({ page }) => {
    await page.goto('/dresses');

    await page.selectOption('select[name="status"]', 'available');
    await page.click('button[type="submit"]:has-text("تصفية")');

    // All visible rows should have 'متاح' status label
    const statusLabels = page.locator('table tbody tr td span');
    const counts = await statusLabels.count();
    for (let i = 0; i < counts; i++) {
        await expect(statusLabels.nth(i)).toHaveText('متاح');
    }
  });
});
