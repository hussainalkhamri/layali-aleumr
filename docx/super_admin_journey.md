# Super Admin - Full Journey Diagram

This diagram illustrates the comprehensive operational and administrative flow for a Super Admin within the Layali Al-Omr system.

```mermaid
journey
    title Super Admin Lifecycle & Operational Flow
    section System Configuration
      Initialize Branches: 5: Super Admin
      Define Roles & Permissions: 4: Super Admin
      Onboard Staff (Users): 5: Super Admin
    section Inventory Management
      Add New Dresses (Upload Images): 5: Super Admin
      View Global Inventory (All Branches): 4: Super Admin
      Coordinate Inter-Branch Transfers: 4: Super Admin
    section Daily Operations
      Monitor Live Bookings: 4: Super Admin
      Review Global Receipts & Income: 5: Super Admin
      Log Operational Expenses: 3: Super Admin
    section Oversight & Security
      Analyze AI Insights (Low Stock/Late Returns): 5: Super Admin
      Investigate Audit Logs (Who did what?): 5: Super Admin
      Mark Insights as Resolved: 4: Super Admin
```

## Key Capabilities

### 1. Global Visibility
Unlike Branch Managers who are restricted to their own location, the Super Admin has a "God View."
- **Inventory:** Can see the status and location of every dress in the company.
- **Finances:** Can see the total revenue and expenses across the entire organization.

### 2. Infrastructure Control
Only the Super Admin can:
- **Create new Branches** as the business expands.
- **Modify User Roles** and their specific permissions.
- **Manage the Audit Trail** to ensure staff accountability.

### 3. Logistics Mastery
The Super Admin acts as the central coordinator for **Transfers**. When Branch A needs a dress that is currently at Branch B, the Super Admin can oversee the transfer request lifecycle from `Transit` to `Received`.

### 4. Strategic Insights
The **System Insights** module provides the Super Admin with automated alerts:
- **Low Usage:** Identifying dresses that aren't being rented.
- **Late Returns:** Tracking customers who haven't returned dresses on time.
- **Branch Performance:** Comparing which locations are generating the most revenue.
