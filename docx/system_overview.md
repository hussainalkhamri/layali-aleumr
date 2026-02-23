# Layali Al-Omr (ليالي العُمر) System Overview

This document summarizes the progress, architecture, and core business logic implemented in the Layali Al-Omr Dress Management System up to this point. 

## 1. Architecture & Tech Stack
We have successfully transitioned the application from an initial Express/Node.js/React concept into a robust, monolithic **Laravel 12** architecture.
*   **Backend Framework**: Laravel 12 using MVC architecture.
*   **Frontend**: Blade templates powered by **Alpine.js** for reactivity and interactivity without the overhead of a heavy JS framework.
*   **Styling**: **Tailwind CSS v4** featuring a fully custom **Maroon brand palette** (`primary`) and a seamlessly integrated **Light/Dark Mode**.
*   **Database**: SQLite/MySQL using Eloquent ORM with strictly enforced foreign key relationships.

## 2. Core Modules & Operations (CRUD)
The system currently boasts fully operational management interfaces for several core entities:

*   **Users & Roles (RBAC)**: Custom roles can be created and assigned granular permissions (e.g., `manage_users`, `manage_branches`). Users are linked to specific branches and can be given a maximum allowed discount percentage for sales.
*   **Branches**: Management of multiple physical store locations.
*   **Dresses (Inventory)**: The core entity. Dresses have barcodes, categories, sizes, colors, rental prices, and current statuses (e.g., *Available*, *Rented*, *Maintenance*, *Missing*). They are assigned to specific branches.
*   **Bookings / Invoices**: Workflow for renting dresses to clients, tracking booking dates, return dates, financial totals, and applying user-limited discounts.
*   **Transfers**: Workflow for securely transferring dress inventory from one branch to another, tracking the sender, receiver, and status (Pending/Completed).
*   **Expenses & Receipts**: Complete financial tracking for incoming revenue (Receipts) and outgoing costs (Expenses) per branch.
*   **Audit Logs**: A security and tracking module that automatically logs every `CREATE`, `UPDATE`, and `DELETE` action performed by staff, recording exactly what was changed (old vs. new values).
*   **AI Insights / Dashboard**: An overview summarizing business health, active bookings, and inventory metrics.

## 3. Key Business Logic & Rules
The application relies on several strict business rules to ensure data integrity and proper workflow:

> [!IMPORTANT]
> **Branch Scoping (Multi-Tenancy)**
> Unless a user is a **Super Admin**, they are restricted to seeing and interacting *only* with the inventory, bookings, transfers, and finances associated with their specific `branch_id`.

> [!NOTE]
> **Authentication Logic**
> Users authenticate using a `username` rather than an email address, facilitating easier point-of-sale login for staff.

1.  **Inventory State Machine**: A dress cannot be booked if it is currently marked as *Rented* or *Maintenance*. Returning a dress updates its status back to *Available*.
2.  **Discount Restrictions**: When creating a booking or receipt, the system limits the maximum discount a cashier can give based on the `max_discount_percent` defined in their User profile.
3.  **Transfer Workflow**: A dress physically exists in only one branch at a time. A transfer must be explicitly *Accepted* or *Completed* by the receiving branch before the dress's `branch_id` is officially updated.
4.  **Implicit Audit Trails**: Every major operational table is monitored. If a user modifies a booking or changes a dress status, their numeric `id` and the specific changes are permanently recorded in the `audit_logs` table.

## 4. Design & UI Aesthetics
*   **Consistent Branding**: The UI uses a tailored color palette featuring vibrant maroon gradients and dark mode adaptations (`dark:bg-gray-900`) that maintain high contrast.
*   **Dynamic Cursors**: All actionable elements (buttons, links, Alpine triggers) globally enforce a pointing hand cursor for clear UX.
*   **Brand Integration**: The Layali Al-Omr `logo.svg` is embedded globally across the login page, welcome portal, sidebar, and browser tab (favicon), with CSS filters to ensure it gracefully inverts to pure white when Dark Mode is active.

## Ready for the Next Phase
The foundation is highly stable. As we move forward, we can build on top of these models to add new features, expand the business logic (e.g., advanced reporting, SMS integrations, deep AI analytics), or refine any of the existing CRUD views!
