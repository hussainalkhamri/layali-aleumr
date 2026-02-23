<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('pages.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:roles,name'],
            'permissions' => ['array'],
        ], [
            'name.required' => 'اسم الدور مطلوب',
            'name.unique'   => 'اسم الدور موجود بالفعل',
        ]);

        $data['permissions'] = $data['permissions'] ?? [];
        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'تم إضافة الدور بنجاح');
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'unique:roles,name,' . $role->id],
            'permissions' => ['array'],
        ], [
            'name.required' => 'اسم الدور مطلوب',
            'name.unique'   => 'اسم الدور موجود بالفعل',
        ]);

        $data['permissions'] = $data['permissions'] ?? [];
        $role->update($data);

        return redirect()->route('roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }
}
