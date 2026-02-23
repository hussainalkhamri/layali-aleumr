<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDressRequest;
use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\BookingInvoice;
use App\Models\Dress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DressController extends Controller
{
    public function index(Request $request)
    {
        $user     = Auth::user()->load('role', 'branch');
        $branchId = $user->isSuperAdmin() ? null : $user->branch_id;

        $query = Dress::with('branch')->where('is_active', true);

        if ($branchId) {
            $query->where('current_branch_id', $branchId);
        } elseif ($request->filled('branch_id')) {
            $query->where('current_branch_id', $request->branch_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")->orWhere('dress_type', 'like', "%$s%")->orWhere('color', 'like', "%$s%"));
        }

        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        $dresses = $query->latest()->get();
        $branches = Branch::where('is_active', true)->get();

        return view('pages.dresses', compact('dresses', 'branches'));
    }

    public function store(StoreDressRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dresses', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $dress = Dress::create($data);

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'CREATE',
            'table_name'  => 'dresses',
            'record_id'   => $dress->id,
            'new_values'  => $data,
        ]);

        return redirect()->route('dresses.index')->with('success', 'تم إضافة الفستان بنجاح');
    }

    public function update(StoreDressRequest $request, Dress $dress)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dresses', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $old = $dress->toArray();
        $dress->update($data);

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'UPDATE',
            'table_name'  => 'dresses',
            'record_id'   => $dress->id,
            'old_values'  => $old,
            'new_values'  => $data,
        ]);

        return redirect()->route('dresses.index')->with('success', 'تم تحديث الفستان بنجاح');
    }

    /**
     * Return dresses available on a given date (no active booking conflict).
     */
    public function available(Request $request, string $date)
    {
        $user     = Auth::user();
        $branchId = $user->isSuperAdmin() ? null : $user->branch_id;

        $bookedIds = BookingInvoice::where('status', '!=', 'cancelled')
            ->where('output_date', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->where('return_date', '>=', $date)->orWhereNull('return_date');
            })
            ->pluck('dress_id');

        $dresses = Dress::with('branch')
            ->where('is_active', true)
            ->where('current_status', 'available')
            ->whereNotIn('id', $bookedIds)
            ->when($branchId, fn($q) => $q->where('current_branch_id', $branchId))
            ->get();

        return response()->json($dresses);
    }
}
