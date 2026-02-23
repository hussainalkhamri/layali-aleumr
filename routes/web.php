<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingInvoiceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DressController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemInsightController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected routes ──────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Branches
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index')
        ->middleware('permission:manage_branches');
    Route::post('/branches', [BranchController::class, 'store'])->name('branches.store')
        ->middleware('permission:manage_branches');
    Route::put('/branches/{branch}', [BranchController::class, 'update'])->name('branches.update')
        ->middleware('permission:manage_branches');

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')
        ->middleware('permission:manage_roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')
        ->middleware('permission:manage_roles');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')
        ->middleware('permission:manage_roles');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index')
        ->middleware('permission:manage_users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')
        ->middleware('permission:manage_users');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')
        ->middleware('permission:manage_users');

    // Dresses
    Route::get('/dresses', [DressController::class, 'index'])->name('dresses.index');
    Route::post('/dresses', [DressController::class, 'store'])->name('dresses.store');
    Route::put('/dresses/{dress}', [DressController::class, 'update'])->name('dresses.update');
    Route::get('/dresses/available/{date}', [DressController::class, 'available'])->name('dresses.available');

    // Bookings
    Route::get('/bookings', [BookingInvoiceController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingInvoiceController::class, 'store'])->name('bookings.store');
    Route::put('/bookings/{booking}', [BookingInvoiceController::class, 'update'])->name('bookings.update');

    // Receipts
    Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
    Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipts.store');

    // Expenses
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index')
        ->middleware('permission:view_audit');

    // System Insights
    Route::get('/insights', [SystemInsightController::class, 'index'])->name('insights.index')
        ->middleware('permission:view_insights');
    Route::post('/insights/{insight}/read', [SystemInsightController::class, 'markRead'])->name('insights.read');
    Route::post('/insights/generate', [SystemInsightController::class, 'generateReport'])->name('insights.generate');
    Route::post('/insights/chat', [SystemInsightController::class, 'chat'])->name('insights.chat');
});
