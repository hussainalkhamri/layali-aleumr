@extends('layouts.app')
@section('title', 'المصروفات')
@section('page-title', 'المصروفات')

@section('content')
<div class="space-y-4" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }} }">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">المصروفات ({{ $expenses->count() }})</h2>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm rounded-xl transition-colors border border-gray-200 dark:border-gray-700 flex items-center gap-2">
                <span>🖨️</span> طباعة
            </button>
            <button @click="showForm = true" class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">+ مصروف جديد</button>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4">
        <form action="{{ route('expenses.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] text-gray-500 mb-1">البحث (الوصف)</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث..." 
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
            </div>
            
            @if(auth()->user()->isSuperAdmin())
            <div class="w-48">
                <label class="block text-[10px] text-gray-500 mb-1">الفرع</label>
                <select name="branch_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="w-36">
                <label class="block text-[10px] text-gray-500 mb-1">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
            </div>

            <div class="w-36">
                <label class="block text-[10px] text-gray-500 mb-1">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-gray-900 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white text-sm rounded-xl transition-colors">تصفية</button>
                @if(request()->anyFilled(['search', 'branch_id', 'date_from', 'date_to']))
                    <a href="{{ route('expenses.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-900 dark:hover:text-white text-sm">إلغاء</a>
                @endif
            </div>
        </form>
    </div>

    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">إضافة مصروف</h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:text-white">✕</button>
                </div>
                <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">المبلغ *</label>
                        <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount') }}" class="w-full bg-gray-50 dark:bg-gray-800 border @error('amount') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                        @error('amount') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الوصف *</label>
                        <textarea name="description" rows="3" class="w-full bg-gray-50 dark:bg-gray-800 border @error('description') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
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
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الوصف</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">المبلغ</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الفرع</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">بواسطة</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $expense->description }}</td>
                        <td class="px-4 py-3 text-red-600 dark:text-red-400 font-medium">{{ number_format($expense->amount, 2) }} ر.ي</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $expense->branch?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $expense->logger?->full_name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $expense->created_at?->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-600 dark:text-gray-500">لا توجد مصروفات</td></tr>
                    @endforelse
                </tbody>
                @if($expenses->isNotEmpty())
                <tfoot class="bg-gray-50 dark:bg-gray-800/50 font-bold border-t border-gray-200 dark:border-gray-800">
                    <tr>
                        <td class="px-4 py-3 text-gray-900 dark:text-white text-left">الإجمالي:</td>
                        <td class="px-4 py-3 text-red-600 dark:text-red-400">{{ number_format($totalAmount, 2) }} ر.ي</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
