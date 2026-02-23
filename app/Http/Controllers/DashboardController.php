<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\BookingInvoice;
use App\Models\Dress;
use App\Models\Expense;
use App\Models\SystemInsight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user   = Auth::user()->load('role', 'branch');
        $isSuperAdmin = $user->isSuperAdmin();
        $branchId = $isSuperAdmin ? null : $user->branch_id;

        // ── Dresses ──────────────────────────────────────────────
        $dressQuery = Dress::where('is_active', true);
        if ($branchId) $dressQuery->where('current_branch_id', $branchId);
        $allDresses      = $dressQuery->get();
        $totalDresses    = $allDresses->count();
        $availableDresses = $allDresses->where('current_status', 'available')->count();

        // ── Bookings ─────────────────────────────────────────────
        $bookingQuery = BookingInvoice::query();
        if ($branchId) $bookingQuery->where('branch_id', $branchId);
        $allBookings   = $bookingQuery->get();
        $today         = today()->toDateString();
        $monthStart    = today()->startOfMonth();

        $activeBookings = $allBookings->whereIn('status', ['active', 'delivered'])->count();
        $todayOutputs   = $allBookings->where('output_date', $today)->where('status', 'active')->count();
        $todayReturns   = $allBookings->where('return_date', $today)->where('status', 'delivered')->count();

        $totalRevenue   = \App\Models\Receipt::sum('amount');
        $monthlyRevenue = \App\Models\Receipt::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $pendingPayments = $allBookings->where('status', '!=', 'cancelled')->sum('remaining_amount');

        // ── Upcoming ────────────────────────────────────────────
        $upcomingBookings = $allBookings
            ->where('status', 'active')
            ->filter(fn($b) => $b->output_date && \Carbon\Carbon::parse($b->output_date)->between(now(), now()->addDays(7)))
            ->count();

        // ── Insights ─────────────────────────────────────────────
        $recentInsights = SystemInsight::latest()->take(3)->get();

        return view('pages.dashboard', compact(
            'user', 'totalDresses', 'availableDresses',
            'activeBookings', 'todayOutputs', 'todayReturns',
            'totalRevenue', 'monthlyRevenue', 'pendingPayments',
            'upcomingBookings', 'recentInsights'
        ));
    }
}
