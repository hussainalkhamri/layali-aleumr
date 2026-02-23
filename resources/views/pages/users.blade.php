@extends('layouts.app')
@section('title', 'المستخدمون')
@section('page-title', 'إدارة المستخدمين')

@section('content')
<div class="space-y-4" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, editUser: {{ old('edit_user_data') ? old('edit_user_data') : 'null' }} }">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">المستخدمون ({{ $users->count() }})</h2>
        <button @click="showForm = true; editUser = null" class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">+ مستخدم جديد</button>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] text-gray-500 mb-1">البحث (الاسم، اسم المستخدم)</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث..." 
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
            </div>
            
            <div class="w-48">
                <label class="block text-[10px] text-gray-500 mb-1">الفرع</label>
                <select name="branch_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-48">
                <label class="block text-[10px] text-gray-500 mb-1">الدور</label>
                <select name="role_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الأدوار</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ request('role_id') == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-gray-900 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white text-sm rounded-xl transition-colors">تصفية</button>
                @if(request()->anyFilled(['search', 'branch_id', 'role_id']))
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-900 dark:hover:text-white text-sm">إلغاء</a>
                @endif
            </div>
        </form>
    </div>

    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editUser ? 'تعديل المستخدم' : 'مستخدم جديد'"></h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:text-white">✕</button>
                </div>
                <form :action="editUser ? `/users/${editUser.id}` : '{{ route('users.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="editUser ? 'PUT' : 'POST'">
                    <input type="hidden" name="edit_user_data" x-bind:value="editUser ? JSON.stringify(editUser) : ''">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الاسم الكامل *</label>
                            <input type="text" name="full_name" x-bind:value="editUser?.full_name ?? '{{ old('full_name') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500 @error('full_name') border-red-500 @enderror" required>
                            @error('full_name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">اسم المستخدم *</label>
                            <input type="text" name="username" x-bind:value="editUser?.username ?? '{{ old('username') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500 @error('username') border-red-500 @enderror" required>
                            @error('username') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">رقم الجوال</label>
                            <input type="text" name="phone" x-bind:value="editUser?.phone ?? ''" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">كلمة المرور <span x-show="editUser" class="text-gray-600 dark:text-gray-500">(اتركها فارغة للإبقاء على الحالية)</span></label>
                            <input type="password" name="password" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500 @error('password') border-red-500 @enderror" x-bind:required="!editUser">
                            @error('password') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الدور</label>
                            <select name="role_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                                <option value="">— بلا دور —</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" 
                                            x-bind:selected="editUser ? editUser.role_id == {{ $role->id }} : {{ old('role_id', 'null') }} == {{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الفرع</label>
                            <select name="branch_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                                <option value="">— بلا فرع —</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" 
                                            x-bind:selected="editUser ? editUser.branch_id == {{ $branch->id }} : {{ old('branch_id', 'null') }} == {{ $branch->id }}"
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-3 pt-4">
                            <input type="hidden" name="is_active_present" value="1">
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="w-4 h-4 accent-amber-500" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="text-sm text-gray-600 dark:text-gray-400">نشط</label>
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

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الاسم</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">المستخدم</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الدور</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الفرع</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الحالة</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $user->full_name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->username }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->role?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $user->branch?->name ?? 'الإدارة العامة' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs {{ $user->is_active ? 'bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 border border-emerald-700/40' : 'bg-red-900/40 text-inferno-600 dark:text-inferno-400 border border-red-700/40' }}">
                                {{ $user->is_active ? 'نشط' : 'موقوف' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <button @click="showForm = true; editUser = {{ $user->toJson() }}" class="text-xs text-primary-600 dark:text-primary-400 hover:text-amber-300">تعديل</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-600 dark:text-gray-500">لا يوجد مستخدمون</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
