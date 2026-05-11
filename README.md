# Layali Al-Omr (Ghaseel Plus) Management System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

A comprehensive, full-stack ERP and Management System designed for the car washing and detailing industry. **Layali Al-Omr** (also known as Ghaseel Plus) streamlines operations across multiple branches, managing users, daily invoices, financial expenses, and comprehensive audit logs.

*Note: This repository was recently initialized for portfolio showcasing. The codebase was primarily developed in a self-hosted organizational environment between February and May 2026, and its history has been consolidated here.*

## ✨ Key Features

- **Multi-Branch Architecture**: Manage operations, revenues, and expenses across different physical branch locations independently.
- **Role-Based Access Control (RBAC)**: Secure access using specific user roles (Admin, Cashier, Branch Manager) ensuring data integrity and operational security.
- **Invoice & Receipt Management**: Create, track, and print detailed customer invoices and booking receipts with automated calculations.
- **Financial Tracking**: Comprehensive expense logging to track operational costs, paired with revenue tracking from invoices.
- **Audit Logging**: An immutable audit log system that tracks critical user actions for accountability and security.
- **System Insights**: Real-time analytics and performance metrics dashboard for business owners.
- **Modern SPA Frontend**: Built with React and Inertia.js for lightning-fast, stateless transitions without writing a separate REST API.

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP)
- **Frontend**: React.js with Inertia.js
- **Styling**: Tailwind CSS
- **Database**: MySQL / PostgreSQL
- **Authentication**: Laravel Session Auth

## 📂 Architecture & Documentation

To understand the internal structure of the project or if you are looking to contribute, please refer to our internal documentation:
- [📖 Learning & Architecture Guide](docs/LEARNING_GUIDE.md) - Deep dive into how the system works and how to navigate the codebase.
- [🚀 Publishing Guidelines](docs/PUBLISHING_GUIDELINES.md) - Guidelines on repository management and what to keep private.

## ⚙️ Installation & Local Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/hussainalkhamri/layali-aleumr.git
   cd layali-aleumr
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM Dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the example environment file and generate a new application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup:**
   Configure your `.env` with your database credentials, then run the migrations.
   ```bash
   php artisan migrate --seed
   ```

6. **Run the Development Servers:**
   You will need two terminal windows to run both the Laravel backend and Vite frontend build tool.
   ```bash
   # Terminal 1: Run the Laravel server
   php artisan serve

   # Terminal 2: Run the Vite development server
   npm run dev
   ```

## 🔒 Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Hussain via [saleh7ussain1@gmail.com](mailto:alhussainalkhamri@gmail.com).

## 📄 License

This project is proprietary software. Unauthorized copying, modification, or distribution is strictly prohibited.
