<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Models\AuditLog;
use App\Models\BookingInvoice;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user     = Auth::user()->load('role');
        $branchId = $user->isSuperAdmin() ? null : $user->branch_id;

        $query = Receipt::with('booking.branch', 'receiver');

        if ($branchId) {
            $query->whereHas('booking', fn($q) => $q->where('branch_id', $branchId));
        } elseif ($request->filled('branch_id')) {
            $query->whereHas('booking', fn($q) => $q->where('branch_id', $request->branch_id));
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => 
                $q->where('receipt_no', 'like', "%$s%")
                  ->orWhereHas('booking', fn($bq) => 
                      $bq->where('customer_name', 'like', "%$s%")
                         ->orWhere('customer_phone', 'like', "%$s%")
                         ->orWhere('invoice_no', 'like', "%$s%")
                         ->orWhere('id', 'like', "%$s%")
                  )
            );
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $receipts = $query->latest()->get();
        $totalAmount = $receipts->sum('amount');

        $bookings = BookingInvoice::where('status', '!=', 'cancelled')
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $branches = \App\Models\Branch::where('is_active', true)->get();

        return view('pages.receipts', compact('receipts', 'bookings', 'branches', 'totalAmount'));
    }

    public function store(StoreReceiptRequest $request)
    {
        $user    = Auth::user();
        $booking = BookingInvoice::findOrFail($request->booking_invoice_id);

        $data = $request->validated();
        $data['received_by'] = $user->id;

        if (empty($data['receipt_no'])) {
            $date = date('ymd');
            $branchId = $user->branch_id ?? '0';
            $count = Receipt::whereDate('created_at', today())->count() + 1;
            $data['receipt_no'] = "REC-{$date}-{$branchId}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        }

        $receipt = Receipt::create($data);

        // Update the booking remaining/paid amounts
        $newRemaining = max(0, floatval($booking->remaining_amount) - floatval($request->amount));
        $newPaid      = floatval($booking->paid_advance) + floatval($request->amount);
        $booking->update([
            'remaining_amount' => number_format($newRemaining, 2, '.', ''),
            'paid_advance'     => number_format($newPaid, 2, '.', ''),
            'status'           => $newRemaining <= 0 ? 'completed' : $booking->status,
        ]);

        AuditLog::create([
            'user_id'     => $user->id,
            'action_type' => 'CREATE',
            'table_name'  => 'receipts',
            'record_id'   => $receipt->id,
            'new_values'  => $request->validated(),
        ]);

        return redirect()->route('receipts.index')->with('success', 'تم تسجيل الإيصال بنجاح');
    }
}
