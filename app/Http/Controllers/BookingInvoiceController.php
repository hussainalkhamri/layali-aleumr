<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingInvoiceRequest;
use App\Models\AuditLog;
use App\Models\BookingInvoice;
use App\Models\Branch;
use App\Models\Dress;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user()->load('role', 'branch');
        $branchId = $user->isSuperAdmin() ? null : $user->branch_id;

        $query = BookingInvoice::with('dress', 'creator', 'branch');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        } elseif ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('customer_name', 'like', "%$s%")
                                     ->orWhere('customer_phone', 'like', "%$s%")
                                     ->orWhere('invoice_no', 'like', "%$s%")
                                     ->orWhere('id', 'like', "%$s%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('reserved_for_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('reserved_for_date', '<=', $request->date_to);
        }

        $bookings       = $query->latest()->get();
        $totalAmount    = $bookings->sum('total_amount');
        $totalRemaining = $bookings->sum('remaining_amount');

        $dresses  = Dress::where('is_active', true)
            ->when($branchId, fn($q) => $q->where('current_branch_id', $branchId))
            ->get();

        $branches = Branch::where('is_active', true)->get();

        return view('pages.bookings', compact('bookings', 'dresses', 'branches', 'totalAmount', 'totalRemaining'));
    }

    public function store(StoreBookingInvoiceRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();
        
        // --- Conflict Check ---
        $requestedOutput = \Carbon\Carbon::parse($data['output_date']);
        $requestedReturn = $data['return_date'] ? \Carbon\Carbon::parse($data['return_date']) : $requestedOutput->copy()->addDays(3);
        
        $conflict = BookingInvoice::where('dress_id', $data['dress_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($requestedOutput, $requestedReturn) {
                $query->where(function ($q) use ($requestedOutput, $requestedReturn) {
                    $q->whereBetween('output_date', [$requestedOutput, $requestedReturn])
                      ->orWhereBetween('return_date', [$requestedOutput, $requestedReturn]);
                })->orWhere(function ($q) use ($requestedOutput, $requestedReturn) {
                    $q->where('output_date', '<=', $requestedOutput)
                      ->where('return_date', '>=', $requestedReturn);
                });
            })->first();

        if ($conflict) {
            return back()->withErrors([
                'dress_id' => "هذا الفستان محجوز بالفعل في الفترة المختارة (من {$conflict->output_date->format('d/m/Y')} إلى {$conflict->return_date->format('d/m/Y')})",
            ])->withInput();
        }
        // -----------------------

        $data['created_by'] = $user->id;
        $data['branch_id']  = $user->branch_id;

        // Auto-generate invoice number if not provided
        if (empty($data['invoice_no'])) {
            $date = date('ymd');
            $branchId = $user->branch_id ?? '0';
            $count = BookingInvoice::whereDate('created_at', today())->count() + 1;
            $data['invoice_no'] = "INV-{$date}-{$branchId}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
        }

        $booking = BookingInvoice::create($data);

        // Update dress status to booked
        Dress::where('id', $booking->dress_id)->update(['current_status' => 'booked']);

        // Auto-create deposit receipt if advance paid
        if (floatval($request->paid_advance ?? 0) > 0) {
            Receipt::create([
                'booking_invoice_id' => $booking->id,
                'received_by'        => $user->id,
                'amount'             => $request->paid_advance,
                'receipt_nature'     => 'deposit',
                'payment_method'     => $request->payment_method ?? 'cash',
            ]);
        }

        AuditLog::create([
            'user_id'     => $user->id,
            'action_type' => 'CREATE',
            'table_name'  => 'booking_invoices',
            'record_id'   => $booking->id,
            'new_values'  => $request->validated(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'تم إنشاء الحجز بنجاح وتحديث حالة الفستان');
    }

    public function update(Request $request, BookingInvoice $booking)
    {
        $data = $request->validate([
            'status'           => ['in:active,delivered,completed,cancelled'],
            'return_date'      => ['nullable', 'date'],
            'notes'            => ['nullable', 'string'],
            'remaining_amount' => ['nullable', 'numeric'],
        ]);

        $oldStatus = $booking->status;
        $newStatus = $data['status'] ?? $oldStatus;

        $old = $booking->toArray();
        $booking->update(array_filter($data, fn($v) => $v !== null));

        // Handle Dress Status transitions
        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'cancelled' || $newStatus === 'completed') {
                Dress::where('id', $booking->dress_id)->update(['current_status' => 'available']);
            } elseif ($newStatus === 'delivered' || $newStatus === 'active') {
                Dress::where('id', $booking->dress_id)->update(['current_status' => 'booked']);
            }
        }

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'UPDATE',
            'table_name'  => 'booking_invoices',
            'record_id'   => $booking->id,
            'old_values'  => $old,
            'new_values'  => $data,
        ]);

        return redirect()->route('bookings.index')->with('success', 'تم تحديث الحجز بنجاح');
    }
}
