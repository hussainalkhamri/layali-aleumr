@extends('layouts.app')
@section('title', 'الفساتين')
@section('page-title', 'إدارة الفساتين')

@section('content')
<div class="space-y-4" x-data="{ showForm: {{ $errors->any() ? 'true' : 'false' }}, editDress: null }">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">الفساتين ({{ $dresses->count() }})</h2>
        <button @click="showForm = true; editDress = null"
                class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-white text-sm rounded-xl transition-colors">
            + إضافة فستان
        </button>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4">
        <form action="{{ route('dresses.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] text-gray-500 mb-1">البحث (الاسم، النوع، اللون)</label>
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

            <div class="w-40">
                <label class="block text-[10px] text-gray-500 mb-1">الحالة</label>
                <select name="status" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الحالات</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متاح</option>
                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>محجوز</option>
                    <option value="rented_out" {{ request('status') == 'rented_out' ? 'selected' : '' }}>مُسلَّم (خارج)</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>صيانة/تنظيف</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-gray-900 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white text-sm rounded-xl transition-colors">تصفية</button>
                @if(request()->anyFilled(['search', 'branch_id', 'status']))
                    <a href="{{ route('dresses.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-900 dark:hover:text-white text-sm flex items-center">إلغاء</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Add/Edit Form Modal --}}
    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editDress ? 'تعديل الفستان' : 'إضافة فستان جديد'"></h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">✕</button>
                </div>

                <form :action="editDress ? `/dresses/${editDress.id}` : '{{ route('dresses.store') }}'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="editDress ? 'PUT' : 'POST'">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">اسم الفستان *</label>
                            <input type="text" name="name" x-bind:value="editDress?.name ?? '{{ old('name') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('name') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">صورة الفستان</label>
                            <div class="flex items-center gap-4">
                                <template x-if="editDress?.image_url">
                                    <img :src="editDress.image_url" class="w-16 h-16 rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                                </template>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                            </div>
                            <p class="text-[10px] text-gray-500 mt-1">يمكنك رفع ملف صورة (JPG, PNG, WEBP) بحد أقصى 2MB</p>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">نوع الفستان *</label>
                            <input type="text" name="dress_type" x-bind:value="editDress?.dress_type ?? '{{ old('dress_type') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('dress_type') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" placeholder="زفاف، سهرة، خطوبة..." required>
                            @error('dress_type') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الفرع</label>
                            <select name="current_branch_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                                <option value="">— اختر الفرع —</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" 
                                            x-bind:selected="editDress ? editDress.current_branch_id == {{ $branch->id }} : {{ old('current_branch_id', 'null') }} == {{ $branch->id }}"
                                            {{ old('current_branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">اللون</label>
                            <input type="text" name="color" x-bind:value="editDress?.color ?? ''"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">مقاس الصدر</label>
                            <input type="text" name="chest_size" x-bind:value="editDress?.chest_size ?? ''"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">مقاس الخصر</label>
                            <input type="text" name="waist_size" x-bind:value="editDress?.waist_size ?? ''"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">سعر الإيجار</label>
                            <input type="number" name="rental_price" step="0.01" x-bind:value="editDress?.rental_price ?? ''"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">سعر البيع</label>
                            <input type="number" name="sale_price" step="0.01" x-bind:value="editDress?.sale_price ?? ''"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">الحد الأقصى للاستخدام</label>
                            <input type="number" name="max_usage_limit" x-bind:value="editDress?.max_usage_limit ?? 50"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div>
                            <label class="block text-xs text-clay-soil-600 dark:text-clay-soil-400 mb-1">أيام التنظيف</label>
                            <input type="number" name="cleaning_days" x-bind:value="editDress?.cleaning_days ?? 2"
                                   class="w-full bg-parchment-100 dark:bg-clay-soil-800 border border-parchment-300 dark:border-clay-soil-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-rich-mahogany-500">
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="show_in_catalog" id="show_in_catalog" value="1"
                                   class="w-4 h-4 accent-primary-500">
                            <label for="show_in_catalog" class="text-sm text-gray-600 dark:text-gray-400">إظهار في الكتالوج</label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showForm = false"
                                class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">إلغاء</button>
                        <button type="submit"
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-500 text-white text-sm rounded-xl transition-colors">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الاسم</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">النوع</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الفرع</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الحالة</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الإيجار</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الاستخدام</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($dresses as $dress)
                    @php
                        $statusColors = [
                            'available'   => 'emerald',
                            'booked'      => 'blue',
                            'rented_out'  => 'purple',
                            'maintenance' => 'amber',
                        ];
                        $statusLabels = [
                            'available'   => 'متاح',
                            'booked'      => 'محجوز',
                            'rented_out'  => 'مُسلَّم',
                            'maintenance' => 'صيانة',
                        ];
                        $sc = $statusColors[$dress->current_status] ?? 'gray';
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $dress->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $dress->dress_type }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $dress->branch?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-{{ $sc }}-100 dark:bg-{{ $sc }}-900/40 text-black dark:text-{{ $sc }}-400 border border-{{ $sc }}-200 dark:border-{{ $sc }}-700/40">
                                {{ $statusLabels[$dress->current_status] ?? $dress->current_status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $dress->rental_price ? number_format($dress->rental_price, 0) . ' ر.ي' : '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $dress->current_usage_count }}/{{ $dress->max_usage_limit }}</td>
                        <td class="px-4 py-3">
                            <button @click="showForm = true; editDress = {{ $dress->toJson() }}"
                                    class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">تعديل</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">لا توجد فساتين</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
