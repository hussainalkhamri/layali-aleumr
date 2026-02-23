import { test, expect } from '@playwright/test';

test.describe('Dashboard and Insights', () => {
  test('should display key statistics and revenue correctly', async ({ page }) => {
    await page.goto('/');

    // Verify stats cards
    await expect(page.locator('div:has-text("إجمالي الفساتين")').first()).toBeVisible();
    await expect(page.locator('div:has-text("الفساتين المتاحة")').first()).toBeVisible();
    await expect(page.locator('div:has-text("الحجوزات النشطة")').first()).toBeVisible();

    // Verify revenue section
    await expect(page.locator('div:has-text("إجمالي الإيرادات")').first()).toBeVisible();
    await expect(page.locator('p:has-text("ر.ي")').first()).toBeVisible();
  });

  test('should display AI insights if available', async ({ page }) => {
    await page.goto('/');

    const insightsSection = page.locator('h3:has-text("✨ تحليلات النظام")').locator('xpath=..');
    
    // Check if there are insights or the empty state message
    const hasInsights = await insightsSection.locator('.p-3.rounded-xl').count() > 0;
    const hasEmptyMessage = await insightsSection.locator('p:has-text("لا توجد تحليلات حالياً")').isVisible();

    expect(hasInsights || hasEmptyMessage).toBeTruthy();
  });

  test('should navigate to all major modules via sidebar', async ({ page }) => {
    await page.goto('/');

    // Check sidebar links (assuming layouts.app has a sidebar)
    const links = [
      { text: 'الفساتين', url: '/dresses' },
      { text: 'الحجوزات', url: '/bookings' },
      { text: 'المصروفات', url: '/expenses' },
      { text: 'المستخدمون', url: '/users' },
    ];

    for (const link of links) {
      await page.click(`nav a:has-text("${link.text}")`);
      await expect(page).toHaveURL(link.url);
      await page.goBack();
    }
  });
});
