<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchRequest;
use App\Models\AuditLog;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_active', true)->latest()->get();
        return view('pages.branches', compact('branches'));
    }

    public function store(StoreBranchRequest $request)
    {
        $branch = Branch::create($request->validated());

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'CREATE',
            'table_name'  => 'branches',
            'record_id'   => $branch->id,
            'new_values'  => $request->validated(),
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'تم إضافة الفرع بنجاح');
    }

    public function update(StoreBranchRequest $request, Branch $branch)
    {
        $old = $branch->toArray();
        $branch->update($request->validated());

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'UPDATE',
            'table_name'  => 'branches',
            'record_id'   => $branch->id,
            'old_values'  => $old,
            'new_values'  => $request->validated(),
        ]);

        return redirect()->route('branches.index')
            ->with('success', 'تم تحديث الفرع بنجاح');
    }
}
