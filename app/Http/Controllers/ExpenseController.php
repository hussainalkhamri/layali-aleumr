<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\AuditLog;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user     = Auth::user()->load('role');
        $branchId = $user->isSuperAdmin() ? null : $user->branch_id;

        $query = Expense::with('branch', 'logger');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        } elseif ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('description', 'like', "%$s%");
        }

        if ($request->filled('date_from')) {
            $query->where('expense_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('expense_date', '<=', $request->date_to);
        }

        $expenses = $query->latest()->get();
        $totalAmount = $expenses->sum('amount');
        $branches = \App\Models\Branch::where('is_active', true)->get();

        return view('pages.expenses', compact('expenses', 'branches', 'totalAmount'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $user    = Auth::user();
        $expense = Expense::create(array_merge($request->validated(), [
            'branch_id' => $user->branch_id,
            'logged_by' => $user->id,
        ]));

        AuditLog::create([
            'user_id'     => $user->id,
            'action_type' => 'CREATE',
            'table_name'  => 'expenses',
            'record_id'   => $expense->id,
            'new_values'  => $request->validated(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'تم تسجيل المصروف بنجاح');
    }
}
