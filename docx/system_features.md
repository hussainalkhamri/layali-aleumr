# Layali Al-Omr - Complete Feature List

Here is a comprehensive list of all the features and capabilities currently built into the system, organized by module:

## 1. Authentication & Security
*   **Username Login:** Fast, POS-friendly login using a unique username (instead of email) and password.
*   **Role-Based Access Control (RBAC):** Define custom roles (e.g., Manager, Cashier) and assign granular permissions (e.g., `manage_users`, `manage_branches`, `view_insights`).
*   **Super Admin Privilege:** Built-in bypass that grants full system access to designated Super Admins.
*   **Branch Isolation:** Users are tied to a specific branch. By default, they can only view and manage inventory, bookings, and finances for *their* assigned branch.
*   **Activity Auditing (Audit Logs):** Every time a user adds or updates a record (user, dress, booking, transfer, etc.), the system automatically records *who* did it, *when*, and stores the exact "Before" and "After" data.

## 2. Dress & Inventory Management
*   **Comprehensive Profiles:** Store detailed information for each dress including barcode, name, category, size, color, rental price, and supplier.
*   **Real-time Status Tracking:** Monitor whether a dress is `available`, `rented`, `maintenance`, or `missing`.
*   **Location Tracking:** Know exactly which branch currently holds the dress.

## 3. Booking & Rental Operations
*   **Smart Availability Checking:** The system automatically prevents double-booking by checking if a dress is already rented out during the selected dates.
*   **Discount Controls:** Cashiers are restricted by a maximum discount percentage limit (`max_discount_percent`) assigned to their user profile by an admin.
*   **Financial Math:** Automatically calculates total cost, applies valid discounts, tracks advance payments, and calculates the remaining balance.
*   **Auto-Receipts:** If a customer pays an advance deposit while creating a booking, the system automatically generates a corresponding financial `Receipt` record.
*   **Lifecycle Management:** Track the booking from `active` to `delivered` to `completed` or `cancelled`.

## 4. Inter-Branch Transfers
*   **Request Workflow:** Users can request a dress from another branch to fulfill a customer need.
*   **Approval & Transit System:** Follows a strict 4-step process: `Pending` ➔ `Approved` (by manager) ➔ `In Transit` (updates dress status so it can't be booked) ➔ `Received`.
*   **Auto-Location Update:** Once marked as `Received`, the system automatically updates the dress's current branch and makes it `available` again.

## 5. Financial Management
*   **Expense Tracking:** Log operational costs (salaries, rent, maintenance) tied to specific branches, complete with amounts and dates.
*   **Income Receipts:** Log incoming payments, tracking the payment method (cash, card, bank transfer) and the nature of the receipt (deposit, final payment, miscellaneous).

## 6. Dashboard & Insights
*   **Quick Overview:** A dashboard interface providing an at-a-glance view of daily operations.
*   **AI Insights Module:** A dedicated space for analytical reporting and trends (e.g., top-performing branches, most popular dresses).

## 7. User Experience (UX) & Design
*   **Responsive Modern UI:** Built with Tailwind CSS, ensuring it works perfectly on desktops, tablets, and POS screens.
*   **Brand Identity:** Custom "Layali Al-Omr Maroon" color palette and integrated SVG branding.
*   **Dark Mode / Light Mode:** Fully supported theme toggle that saves the user's preference and seamlessly inverts graphics (like the logo) for readability.
*   **Fast Interactions:** Uses Alpine.js to open forms in beautiful, fast popup modals without having to reload the entire web page.
*   **Visual Cues:** All interactive elements, buttons, and table actions feature correct hover states and pointer cursors.
