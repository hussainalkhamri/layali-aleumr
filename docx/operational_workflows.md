# Operational Workflows & Business Logic

This document provides a detailed breakdown of how the Layali Al-Omr system operates under the hood, specifically detailing the step-by-step logic executed during major actions.

## 1. Booking Workflow
When a cashier creates a new booking (`BookingInvoiceController`), the system executes several business rules sequentially:
1. **Discount Validation**: The system checks the submitted `discount_percent`. If it exceeds the authenticated user's `max_discount_percent`, the request is immediately rejected.
2. **Branch Scoping**: The `branch_id` of the booking is automatically inherited from the user's assigned branch. The cashier cannot create bookings for other branches.
3. **Auto-Receipt Generation**: If the booking includes a `paid_advance` greater than zero, the system seamlessly creates a `Receipt` record tied to this booking to reflect the cash deposit.
4. **Audit Logging**: An `AuditLog` is created capturing the exact values the cashier entered.

## 2. Dress Transfer Workflow
Moving a dress between branches (`TransferController`) follows a strict 4-stage State Machine to prevent inventory loss:
1. **Pending**: A user requests a dress from another branch.
2. **Approved**: A manager reviews and approves the request.
3. **In Transit**: The dress physically leaves the origin branch. The system automatically updates the Dress's `current_status` to `transit` so it cannot be booked.
4. **Received**: The destination branch confirms arrival. The system automatically updates the Dress's `current_branch_id` to the destination branch and resets its status to `available`.

## 3. Availability Engine
When creating a booking, the system guarantees a dress is not double-booked:
*   The `DressController@available` endpoint is polled with the desired date.
*   The system cross-references the `booking_invoices` table to find all bookings that overlap with the requested date and exclude those `dress_id`s.
*   Only dresses that belong to the user's branch (unless Super Admin) and have a `current_status` of `available` are returned to the frontend.

## 4. Financial Tracking (Receipts & Expenses)
*   **Expenses**: Logged with specific categories (e.g., salaries, maintenance, rent). Automatically tied to the logged-in user and their branch.
*   **Receipts**: Captured for booking payments, deposits, or miscellaneous income.
*   *Note on Visibility*: In the `index` views, standard users only see the financial records associated with their own `branch_id`.

## 5. Security & Auditing
Instead of relying entirely on abstract Eloquent Observers, the system explicitly commands the `AuditLog` model in every controller method (e.g., `UserController@update`, `DressController@store`).
*   **Why?** This ensures we accurately capture the exact context (who clicked the button, what the payload was) without side effects from automated database jobs.
*   **RBAC**: Every route is guarded by the `CheckPermission` middleware, which validates if the user's `Role` contains the explicit permission string (e.g., `manage_branches`) required to execute the controller method. Super Admins bypass this automatically.

---
### Observations / Areas for Expansion
*   **Dress Status Binding**: Currently, updating a booking to "completed" does not automatically mark the dress as "available"—this might be a business logic step you wish to automate next.
*   **Receipt Totals**: The dashboard relies on these receipts to calculate net profit per branch.
