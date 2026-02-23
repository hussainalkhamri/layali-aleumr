@extends('layouts.app')
@section('title', 'الأدوار')
@section('page-title', 'إدارة الأدوار والصلاحيات')

@section('content')
<div class="space-y-4" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, editRole: null }">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">الأدوار ({{ $roles->count() }})</h2>
        <button @click="showForm = true; editRole = null" class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">+ دور جديد</button>
    </div>

    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editRole ? 'تعديل الدور' : 'دور جديد'"></h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:text-white">✕</button>
                </div>
                <form :action="editRole ? `/roles/${editRole.id}` : '{{ route('roles.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="editRole ? 'PUT' : 'POST'">
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">اسم الدور *</label>
                        <input type="text" name="name" x-bind:value="editRole?.name ?? '{{ old('name') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                        @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-3">الصلاحيات</label>
                        <div class="grid grid-cols-2 gap-2">
                            @php 
                            $allPerms = [
                                'manage_branches' => 'إدارة الفروع',
                                'manage_users' => 'إدارة المستخدمين',
                                'manage_roles' => 'إدارة الأدوار',
                                'manage_dresses' => 'إدارة الفساتين',
                                'create_booking' => 'إنشاء حجز',
                                'edit_booking' => 'تعديل حجز',
                                'cancel_booking' => 'إلغاء حجز',
                                'create_receipt' => 'إنشاء سند استلام',
                                'view_reports' => 'عرض التقارير',
                                'view_audit' => 'عرض سجل التدقيق',
                                'view_insights' => 'رؤى النظام',
                                'override_late_edits' => 'تجاوز التعديل المتأخر',
                                'view_all_branches' => 'رؤية جميع الفروع',
                                'create_expense' => 'إضافة مصروف'
                            ]; 
                            @endphp
                            @foreach($allPerms as $permKey => $permLabel)
                            <label class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="permissions[]" value="{{ $permKey }}" class="accent-amber-500"
                                       x-bind:checked="editRole ? (editRole.permissions || []).includes('{{ $permKey }}') : {{ old('permissions') && in_array($permKey, old('permissions')) ? 'true' : 'false' }}">
                                {{ $permLabel }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showForm = false" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white">إلغاء</button>
                        <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($roles as $role)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🔑</span>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $role->name }}</h3>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $role->users_count }} مستخدم</span>
                    <button @click="showForm = true; editRole = {{ json_encode(['id' => $role->id, 'name' => $role->name, 'permissions' => $role->permissions]) }}" class="text-xs text-primary-600 hover:text-amber-300 transition-colors">تعديل</button>
                </div>
            </div>
            <div class="flex flex-wrap gap-1">
                @php
                    $allPermsLocal = [
                        'manage_branches' => 'إدارة الفروع',
                        'manage_users' => 'إدارة المستخدمين',
                        'manage_roles' => 'إدارة الأدوار',
                        'manage_dresses' => 'إدارة الفساتين',
                        'create_booking' => 'إنشاء حجز',
                        'edit_booking' => 'تعديل حجز',
                        'cancel_booking' => 'إلغاء حجز',
                        'create_receipt' => 'إنشاء سند استلام',
                        'view_reports' => 'عرض التقارير',
                        'view_audit' => 'سجل التدقيق',
                        'view_insights' => 'رؤى النظام',
                        'override_late_edits' => 'تجاوز التعديل',
                        'view_all_branches' => 'رؤية جميع الفروع',
                        'create_expense' => 'إضافة مصروف'
                    ];
                @endphp
                @foreach(($role->permissions ?? []) as $perm)
                <span class="text-xs px-2 py-0.5 bg-purple-900/40 text-purple-400 border border-purple-700/30 rounded-full">{{ $allPermsLocal[$perm] ?? $perm }}</span>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
