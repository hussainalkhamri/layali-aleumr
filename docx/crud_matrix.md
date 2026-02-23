# Layali Al-Omr - CRUD Operations Matrix

This document outlines the available CRUD (Create, Read, Update, Delete) operations for each module in the system, along with their corresponding routes and controller methods.

## Summary Table

| Module | Create | Read | Update | Delete | Business Logic Rationale |
| :--- | :---: | :---: | :---: | :---: | :--- |
| **Auth** | - | - | - | - | Registration is handled via the **Users** module for security. |
| **Dashboard** | - | ✅ | - | - | Read-only overview to ensure data consistency across branches. |
| **Branches** | ✅ | ✅ | ✅ | - | Deletion disabled to prevent orphaned data in inventory and finances. |
| **Roles** | ✅ | ✅ | - | - | Permissions are currently static to maintain system stability. |
| **Users** | ✅ | ✅ | ✅ | - | Users are deactivated (`is_active`) rather than deleted for audit integrity. |
| **Dresses** | ✅ | ✅ | ✅ | - | Deletion disabled to maintain rental history integrity. |
| **Bookings** | ✅ | ✅ | ✅ | - | Invoices cannot be deleted; must be `Cancelled` to track lost revenue. |
| **Receipts** | ✅ | ✅ | - | - | Financial records are immutable once issued for tax/accounting accuracy. |
| **Expenses** | ✅ | ✅ | - | - | Expenses are immutable to prevent tampering with branch net profit. |
| **Transfers** | ✅ | ✅ | ✅ | - | Must follow the lifecycle (`Transit` ➔ `Received`) to track inventory. |
| **Audit Logs** | - | ✅ | - | - | Security logs are strictly immutable and cannot be modified or deleted. |
| **AI Insights**| - | ✅ | ✅ | - | "Update" is used to mark alerts as read/dismissed. |

---

## Detailed Operations by Page

### 👤 User Management (`/users`)
- **Read**: View list of all staff, their roles, and assigned branches.
- **Create**: Add new staff with specific roles and discount limits.
- **Update**: Modify existing user details, passwords, or active status.

### 👗 Dress Management (`/dresses`)
- **Read**: View inventory across branches with current status (Available, Booked, etc.).
- **Create**: Add new dresses with sizing, color, and pricing details.
- **Update**: Modify dress details or current branch assignment.
- **Delete**: Logical delete (sets `is_active` to false) to preserve history.

### 📋 Booking Management (`/bookings`)
- **Read**: View all rental invoices and customer details.
- **Create**: Generate new rental contracts with automated receipt creation for deposits.
- **Update**: Update booking status or financial details.

### 🏬 Branch Management (`/branches`)
- **Read**: View all active store branches.
- **Create**: Add new physical locations.
- **Update**: Modify branch name or location details.

### 🔄 Inventory Transfers (`/transfers`)
- **Read**: View status of dresses moving between branches.
- **Create**: Initiate a new transfer request.
- **Update**: Approve, ship, or receive a transfer (updates dress location).

### 🧾 Financials (Receipts & Expenses)
- **Read**: View records of income and costs per branch.
- **Create**: Log new payments or operational expenses.

### 🔑 Roles & Permissions (`/roles`)
- **Read**: View current roles and their granular permission sets.
- **Create**: Define new roles with specific access rights.

### 📝 Security & Audit (`/audit-logs`)
- **Read**: Search and review the automated history of all `CREATE`, `UPDATE`, and `DELETE` operations.
