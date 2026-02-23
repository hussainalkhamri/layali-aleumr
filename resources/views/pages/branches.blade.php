@extends('layouts.app')
@section('title', 'الفروع')
@section('page-title', 'إدارة الفروع')

@section('content')
<div class="space-y-4" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, editBranch: null }">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">الفروع ({{ $branches->count() }})</h2>
        <button @click="showForm = true; editBranch = null" class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">+ فرع جديد</button>
    </div>

    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editBranch ? 'تعديل الفرع' : 'فرع جديد'"></h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:text-white">✕</button>
                </div>
                <form :action="editBranch ? `/branches/${editBranch.id}` : '{{ route('branches.store') }}'" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="editBranch ? 'PUT' : 'POST'">
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">اسم الفرع *</label>
                        <input type="text" name="name" x-bind:value="editBranch?.name ?? '{{ old('name') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                        @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الموقع *</label>
                        <input type="text" name="location" x-bind:value="editBranch?.location ?? '{{ old('location') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border @error('location') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                        @error('location') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الهاتف</label>
                        <input type="text" name="phone" x-bind:value="editBranch?.phone ?? '{{ old('phone') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border @error('phone') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                        @error('phone') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">واتساب</label>
                        <input type="text" name="whatsapp" x-bind:value="editBranch?.whatsapp ?? '{{ old('whatsapp') }}'" class="w-full bg-gray-50 dark:bg-gray-800 border @error('whatsapp') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                        @error('whatsapp') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
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
        @forelse($branches as $branch)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 hover:border-gray-300 dark:border-gray-700 transition-colors">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-primary-600/20 flex items-center justify-center text-xl">🏬</div>
                <button @click="showForm = true; editBranch = {{ $branch->toJson() }}"
                        class="text-xs text-primary-600 dark:text-primary-400 hover:text-amber-300 transition-colors">تعديل</button>
            </div>
            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $branch->name }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $branch->location }}</p>
            @if($branch->phone)
            <p class="text-xs text-gray-600 dark:text-gray-400">📞 {{ $branch->phone }}</p>
            @endif
            @if($branch->whatsapp)
            <p class="text-xs text-gray-600 dark:text-gray-400">💬 {{ $branch->whatsapp }}</p>
            @endif
        </div>
        @empty
        <p class="col-span-3 text-center text-gray-600 dark:text-gray-500 py-8">لا توجد فروع</p>
        @endforelse
    </div>
</div>
@endsection
