# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: expenses.spec.ts >> Expenses Management >> should filter expenses by date
- Location: tests\e2e\expenses.spec.ts:33:3

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: locator('form')
Expected: visible
Timeout: 5000ms
Error: element(s) not found

Call log:
  - Expect "toBeVisible" with timeout 5000ms
  - waiting for locator('form')

```

# Page snapshot

```yaml
- generic [ref=e2]:
  - generic [ref=e4]:
    - generic [ref=e5]:
      - img [ref=e7]
      - generic [ref=e10]: Internal Server Error
    - button "Copy as Markdown" [ref=e11] [cursor=pointer]:
      - img [ref=e12]
      - generic [ref=e15]: Copy as Markdown
  - generic [ref=e18]:
    - generic [ref=e19]:
      - heading "Illuminate\\Database\\QueryException" [level=1] [ref=e20]
      - generic [ref=e22]: vendor\laravel\framework\src\Illuminate\Database\Connection.php:841
      - paragraph [ref=e23]: "SQLSTATE[42S22]: Column not found: 1054 Unknown column 'expense_date' in 'where clause' (Connection: mysql, Host: 127.0.0.1, Port: 3306, Database: layali_aleumr, SQL: select * from `expenses` where `expense_date` >= 2026-04-27 and `expense_date` <= 2026-04-27 order by `created_at` desc)"
    - generic [ref=e24]:
      - generic [ref=e25]:
        - generic [ref=e26]:
          - generic [ref=e27]: LARAVEL
          - generic [ref=e28]: 13.5.0
        - generic [ref=e29]:
          - generic [ref=e30]: PHP
          - generic [ref=e31]: 8.5.5
      - generic [ref=e32]:
        - img [ref=e33]
        - text: UNHANDLED
      - generic [ref=e36]: CODE 42S22
    - generic [ref=e38]:
      - generic [ref=e39]:
        - img [ref=e40]
        - text: "500"
      - generic [ref=e43]:
        - img [ref=e44]
        - text: GET
      - generic [ref=e47]: http://localhost:8000/expenses?branch_id=&date_from=2026-04-27&date_to=2026-04-27&search=
      - button [ref=e48] [cursor=pointer]:
        - img [ref=e49]
  - generic [ref=e53]:
    - generic [ref=e54]:
      - generic [ref=e55]:
        - img [ref=e57]
        - heading "Exception trace" [level=3] [ref=e60]
        - link "1 previous exception" [ref=e61] [cursor=pointer]:
          - /url: "#previous-exceptions"
      - generic [ref=e62]:
        - generic [ref=e64] [cursor=pointer]:
          - img [ref=e65]
          - generic [ref=e69]: 7 vendor frames
          - button [ref=e70]:
            - img [ref=e71]
        - generic [ref=e75]:
          - generic [ref=e76] [cursor=pointer]:
            - generic [ref=e79]:
              - code [ref=e83]:
                - generic [ref=e84]: Illuminate\Database\Eloquent\Builder->get()
              - generic [ref=e86]: app\Http\Controllers\ExpenseController.php:37
            - button [ref=e88]:
              - img [ref=e89]
          - code [ref=e97]:
            - generic [ref=e98]: "32 }"
            - generic [ref=e99]: "33 if ($request->filled('date_to')) {"
            - generic [ref=e100]: 34 $query->where('expense_date', '<=', $request->date_to);
            - generic [ref=e101]: "35 }"
            - generic [ref=e102]: "36"
            - generic [ref=e103]: 37 $expenses = $query->latest()->get();
            - generic [ref=e104]: 38 $totalAmount = $expenses->sum('amount');
            - generic [ref=e105]: 39 $branches = \App\Models\Branch::where('is_active', true)->get();
            - generic [ref=e106]: "40"
            - generic [ref=e107]: 41 return view('pages.expenses', compact('expenses', 'branches', 'totalAmount'));
            - generic [ref=e108]: "42 }"
            - generic [ref=e109]: "43"
            - generic [ref=e110]: 44 public function store(StoreExpenseRequest $request)
            - generic [ref=e111]: "45 {"
            - generic [ref=e112]: 46 $user = Auth::user();
            - generic [ref=e113]: 47 $expense = Expense::create(array_merge($request->validated(), [
            - generic [ref=e114]: 48 'branch_id' => $user->branch_id,
            - generic [ref=e115]: "49"
        - generic [ref=e117] [cursor=pointer]:
          - img [ref=e118]
          - generic [ref=e122]: 49 vendor frames
          - button [ref=e123]:
            - img [ref=e124]
        - generic [ref=e129] [cursor=pointer]:
          - generic [ref=e132]:
            - code [ref=e136]:
              - generic [ref=e137]: Illuminate\Foundation\Application->handleRequest(object(Illuminate\Http\Request))
            - generic [ref=e139]: public\index.php:22
          - button [ref=e141]:
            - img [ref=e142]
        - generic [ref=e147] [cursor=pointer]:
          - img [ref=e148]
          - generic [ref=e152]: 1 vendor frame
          - button [ref=e153]:
            - img [ref=e154]
    - generic [ref=e158]:
      - generic [ref=e159]:
        - img [ref=e161]
        - heading "Previous exception" [level=3] [ref=e164]
      - generic [ref=e168] [cursor=pointer]:
        - generic [ref=e169]:
          - heading "PDOException" [level=4] [ref=e170]
          - paragraph [ref=e171]: "SQLSTATE[42S22]: Column not found: 1054 Unknown column 'expense_date' in 'where clause'"
        - button [ref=e172]:
          - img [ref=e173]
    - generic [ref=e177]:
      - generic [ref=e178]:
        - generic [ref=e179]:
          - img [ref=e181]
          - heading "Queries" [level=3] [ref=e183]
        - generic [ref=e185]: 1-2 of 2
      - generic [ref=e186]:
        - generic [ref=e187]:
          - generic [ref=e188]:
            - generic [ref=e189]:
              - img [ref=e190]
              - generic [ref=e192]: mysql
            - code [ref=e196]:
              - generic [ref=e197]: "select * from `users` where `id` = '019dc98a-ef5b-7218-b8de-6e4a583a8597' limit 1"
          - generic [ref=e198]: 2.48ms
        - generic [ref=e199]:
          - generic [ref=e200]:
            - generic [ref=e201]:
              - img [ref=e202]
              - generic [ref=e204]: mysql
            - code [ref=e208]:
              - generic [ref=e209]: "select * from `roles` where `roles`.`id` in ('019dc98a-eaf4-71dc-b827-0db504ac2944')"
          - generic [ref=e210]: 0.58ms
  - generic [ref=e212]:
    - generic [ref=e213]:
      - heading "Headers" [level=2] [ref=e214]
      - generic [ref=e215]:
        - generic [ref=e216]:
          - generic [ref=e217]: host
          - generic [ref=e219]: localhost:8000
        - generic [ref=e220]:
          - generic [ref=e221]: connection
          - generic [ref=e223]: keep-alive
        - generic [ref=e224]:
          - generic [ref=e225]: sec-ch-ua
          - generic [ref=e227]: "\"HeadlessChrome\";v=\"147\", \"Not.A/Brand\";v=\"8\", \"Chromium\";v=\"147\""
        - generic [ref=e228]:
          - generic [ref=e229]: sec-ch-ua-mobile
          - generic [ref=e231]: "?0"
        - generic [ref=e232]:
          - generic [ref=e233]: sec-ch-ua-platform
          - generic [ref=e235]: "\"Windows\""
        - generic [ref=e236]:
          - generic [ref=e237]: upgrade-insecure-requests
          - generic [ref=e239]: "1"
        - generic [ref=e240]:
          - generic [ref=e241]: user-agent
          - generic [ref=e243]: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.7727.15 Safari/537.36
        - generic [ref=e244]:
          - generic [ref=e245]: accept-language
          - generic [ref=e247]: en-US
        - generic [ref=e248]:
          - generic [ref=e249]: accept
          - generic [ref=e251]: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7
        - generic [ref=e252]:
          - generic [ref=e253]: sec-fetch-site
          - generic [ref=e255]: same-origin
        - generic [ref=e256]:
          - generic [ref=e257]: sec-fetch-mode
          - generic [ref=e259]: navigate
        - generic [ref=e260]:
          - generic [ref=e261]: sec-fetch-user
          - generic [ref=e263]: "?1"
        - generic [ref=e264]:
          - generic [ref=e265]: sec-fetch-dest
          - generic [ref=e267]: document
        - generic [ref=e268]:
          - generic [ref=e269]: referer
          - generic [ref=e271]: http://localhost:8000/expenses
        - generic [ref=e272]:
          - generic [ref=e273]: accept-encoding
          - generic [ref=e275]: gzip, deflate, br, zstd
        - generic [ref=e276]:
          - generic [ref=e277]: cookie
          - generic [ref=e279]: XSRF-TOKEN=eyJpdiI6IkZEYUJsNmF0UUFnWGcwbE5XLzZTYlE9PSIsInZhbHVlIjoibGRkZkFSZitybithbWsxQzVRMkNmWExOM3NKb3FsSVJucHQySGt0MU5CNHdLanAySG05Zml5RlhUcGYrL1VCc3ZrM2NzR09uakJON2xiZ2pmY2ovR3JYR1paRXUyV0w2Rnk2SkQxSThMem9WSEhGb3FkSmpiY0cxMG01UHkyVmwiLCJtYWMiOiIzMzM5M2MyZTE5MTI1ZGZjYTgwYzI4M2RjMDk3ZjI5YjllZTkwMTQ5ZWZkMWFjZjRiOGZiMDgwNjA2YzAyODg2IiwidGFnIjoiIn0%3D; ntham-lyaly-alaamr-session=eyJpdiI6IlBka2NCUVpCUmFaMnp5N01LQ1I2elE9PSIsInZhbHVlIjoiWE9ZNzk2WElkaFRVbDVvOWlqZXV0ZGpxa3ZRdVo2aDZHZXN5Q3R0NTNVYmdNU1p0VllnYURmUmFwVWR3Y1RYVXJSZGEvY1JncTl2TjNWRDNZMFF0M2owWWJtUXJVdm9OVU5nWkpDblJCRUZ1amt2OS9zVk1oMmlHZk1kUDIySnMiLCJtYWMiOiJkNWIzYjUzM2EwYjE4MjRlY2U4YmI1YjcyNzA4NmI3ZTc4YWNmMTQxZTM0OWU3ZDM3Y2RlNzNjODhiNDEwYWI4IiwidGFnIjoiIn0%3D
    - generic [ref=e280]:
      - heading "Body" [level=2] [ref=e281]
      - code [ref=e286]:
        - generic [ref=e287]: "{"
        - generic [ref=e288]: "\"search\": null,"
        - generic [ref=e289]: "\"branch_id\": null,"
        - generic [ref=e290]: "\"date_from\": \"2026-04-27\","
        - generic [ref=e291]: "\"date_to\": \"2026-04-27\""
        - generic [ref=e292]: "}"
    - generic [ref=e293]:
      - heading "Routing" [level=2] [ref=e294]
      - generic [ref=e295]:
        - generic [ref=e296]:
          - generic [ref=e297]: controller
          - generic [ref=e299]: App\Http\Controllers\ExpenseController@index
        - generic [ref=e300]:
          - generic [ref=e301]: route name
          - generic [ref=e303]: expenses.index
        - generic [ref=e304]:
          - generic [ref=e305]: middleware
          - generic [ref=e307]: web, auth
    - generic [ref=e308]:
      - heading "Routing parameters" [level=2] [ref=e309]
      - generic [ref=e310]: // No routing parameters
  - generic [ref=e313]:
    - img [ref=e315]
    - img [ref=e3353]
```

# Test source

```ts
  1  | import { test, expect } from '@playwright/test';
  2  | 
  3  | test.describe('Expenses Management', () => {
  4  |   test('should create a new expense and see it in the total', async ({ page }) => {
  5  |     await page.goto('/expenses');
  6  | 
  7  |     // Get current total if exists
  8  |     const tfoot = page.locator('tfoot');
  9  |     let initialTotal = 0;
  10 |     if (await tfoot.isVisible()) {
  11 |         const text = await tfoot.locator('td').nth(1).textContent();
  12 |         initialTotal = parseFloat(text!.replace(/[^0-9.]/g, ''));
  13 |     }
  14 | 
  15 |     // Add new expense
  16 |     await page.click('button:has-text("+ مصروف جديد")');
  17 |     const amount = 250.50;
  18 |     const desc = `Test Expense ${Date.now()}`;
  19 |     
  20 |     await page.fill('input[name="amount"]', amount.toString());
  21 |     await page.fill('textarea[name="description"]', desc);
  22 |     await page.click('button[type="submit"]:has-text("حفظ")');
  23 | 
  24 |     // Verify in table
  25 |     await expect(page.locator('table')).toContainText(desc);
  26 | 
  27 |     // Verify total updated
  28 |     const newTotalText = await page.locator('tfoot td').nth(1).textContent();
  29 |     const newTotal = parseFloat(newTotalText!.replace(/[^0-9.]/g, ''));
  30 |     expect(newTotal).toBeCloseTo(initialTotal + amount, 2);
  31 |   });
  32 | 
  33 |   test('should filter expenses by date', async ({ page }) => {
  34 |     await page.goto('/expenses');
  35 | 
  36 |     const today = new Date().toISOString().split('T')[0];
  37 |     await page.fill('input[name="date_from"]', today);
  38 |     await page.fill('input[name="date_to"]', today);
  39 |     await page.click('button[type="submit"]:has-text("تصفية")');
  40 | 
  41 |     // If there's an expense today, it should be visible. 
  42 |     // This is more of a smoke test for the filter button.
> 43 |     await expect(page.locator('form')).toBeVisible();
     |                                        ^ Error: expect(locator).toBeVisible() failed
  44 |   });
  45 | });
  46 | 
```