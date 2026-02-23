<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = User::with('role', 'branch');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('full_name', 'like', "%$s%")->orWhere('username', 'like', "%$s%"));
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $users    = $query->get();
        $roles    = Role::all();
        $branches = Branch::where('is_active', true)->get();
        return view('pages.users', compact('users', 'roles', 'branches'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'CREATE',
            'table_name'  => 'users',
            'record_id'   => $user->id,
            'new_values'  => collect($data)->except('password')->toArray(),
        ]);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $old  = $user->toArray();
        $data = $request->validated();

        // Remove password if empty (not changing)
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        AuditLog::create([
            'user_id'     => Auth::id(),
            'action_type' => 'UPDATE',
            'table_name'  => 'users',
            'record_id'   => $user->id,
            'old_values'  => $old,
            'new_values'  => collect($data)->except('password')->toArray(),
        ]);

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }
}
