import { test, expect } from '@playwright/test';

test.describe('Expenses Management', () => {
  test('should create a new expense and see it in the total', async ({ page }) => {
    await page.goto('/expenses');

    // Get current total if exists
    const tfoot = page.locator('tfoot');
    let initialTotal = 0;
    if (await tfoot.isVisible()) {
        const text = await tfoot.locator('td').nth(1).textContent();
        initialTotal = parseFloat(text!.replace(/[^0-9.]/g, ''));
    }

    // Add new expense
    await page.click('button:has-text("+ مصروف جديد")');
    const amount = 250.50;
    const desc = `Test Expense ${Date.now()}`;
    
    await page.fill('input[name="amount"]', amount.toString());
    await page.fill('textarea[name="description"]', desc);
    await page.click('button[type="submit"]:has-text("حفظ")');

    // Verify in table
    await expect(page.locator('table')).toContainText(desc);

    // Verify total updated
    const newTotalText = await page.locator('tfoot td').nth(1).textContent();
    const newTotal = parseFloat(newTotalText!.replace(/[^0-9.]/g, ''));
    expect(newTotal).toBeCloseTo(initialTotal + amount, 2);
  });

  test('should filter expenses by date', async ({ page }) => {
    await page.goto('/expenses');

    const today = new Date().toISOString().split('T')[0];
    await page.fill('input[name="date_from"]', today);
    await page.fill('input[name="date_to"]', today);
    await page.click('button[type="submit"]:has-text("تصفية")');

    // If there's an expense today, it should be visible. 
    // This is more of a smoke test for the filter button.
    await expect(page.locator('form')).toBeVisible();
  });
});
