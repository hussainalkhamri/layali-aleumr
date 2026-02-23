<?php

namespace App\Http\Controllers;

use App\Models\BookingInvoice;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $branchId = $user->branch_id;

        $bookings = BookingInvoice::with(['dress'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->whereIn('status', ['active', 'completed', 'cancelled']) // Only show relevant
            ->get()
            ->map(function ($booking) {
                // Determine colors based on status
                $color = match($booking->status) {
                    'active' => '#eab308', // yellow
                    'completed' => '#22c55e', // green
                    'cancelled' => '#ef4444', // red
                    default => '#3b82f6', // blue
                };

                return [
                    'id' => $booking->id,
                    'title' => ($booking->dress?->name ?? 'بدون فستان') . ' - ' . $booking->customer_name,
                    'start' => $booking->reserved_for_date,
                    'end' => $booking->return_date,
                    'color' => $color,
                    'url' => route('bookings.index', ['highlight' => $booking->id]),
                ];
            });

        return view('pages.calendar', compact('bookings'));
    }
}
