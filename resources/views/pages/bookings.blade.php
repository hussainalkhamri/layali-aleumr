@extends('layouts.app')
@section('title', 'الحجوزات')
@section('page-title', 'إدارة الحجوزات')

@section('content')
<div class="space-y-4" x-data="{
    showForm: {{ $errors->any() ? 'true' : 'false' }},
    editBooking: null,
    total: {{ old('total_amount', 0) }},
    advance: {{ old('paid_advance', 0) }},
    discount: {{ old('discount_percent', 0) }},
    originalPrice: {{ old('dress_id') ? ($dresses->find(old('dress_id'))?->rental_price ?? 0) : 0 }},
    dresses: {{ $dresses->mapWithKeys(fn($d) => [$d->id => $d->rental_price])->toJson() }},

    get remaining() {
        return Math.max(0, this.total - this.advance);
    },

    updateTotal() {
        if (this.originalPrice > 0) {
            this.total = this.originalPrice - (this.originalPrice * (this.discount / 100));
        }
    },

    onDressChange(id) {
        if (!this.editBooking && this.dresses[id]) {
            this.originalPrice = this.dresses[id];
            this.updateTotal();
        }
    },

    init() {
        this.$watch('discount', () => this.updateTotal());
        this.$watch('editBooking', (val) => {
            if (val) {
                this.total = val.total_amount;
                this.advance = val.paid_advance;
                this.discount = val.discount_percent;
                this.originalPrice = val.total_amount / (1 - (val.discount_percent / 100));
            } else {
                this.total = 0;
                this.advance = 0;
                this.discount = 0;
                this.originalPrice = 0;
            }
        });
    }
}">

    <div class="flex items-center gap-3">
        <button onclick="window.print()" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            طباعة
        </button>
        <button @click="showForm = true; editBooking = null"
                class="px-4 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors">
            + حجز جديد
        </button>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4">
        <form action="{{ route('bookings.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-[10px] text-gray-500 mb-1">البحث (الاسم، الجوال، رقم الفاتورة)</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث..." 
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
            </div>
            
            @if(auth()->user()->isSuperAdmin())
            <div class="w-40">
                <label class="block text-[10px] text-gray-500 mb-1">الفرع</label>
                <select name="branch_id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الفروع</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ request('branch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="w-32">
                <label class="block text-[10px] text-gray-500 mb-1">الحالة</label>
                <select name="status" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>مستلم</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>

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
                <button type="submit" class="px-5 py-2 bg-gray-900 dark:bg-gray-800 hover:bg-gray-800 dark:hover:bg-gray-700 text-white text-sm rounded-xl transition-colors">بحث</button>
                @if(request()->anyFilled(['search', 'branch_id', 'status', 'date_from', 'date_to']))
                    <a href="{{ route('bookings.index') }}" class="px-3 py-2 text-gray-500 hover:text-gray-900 dark:hover:text-white text-sm">إلغاء</a>
                @endif
            </div>
        </form>
    </div>

    {{-- New/Edit Booking Modal --}}
    <div x-show="showForm" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" x-text="editBooking ? 'تعديل الحجز' : 'حجز جديد'"></h3>
                    <button @click="showForm = false" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:text-white">✕</button>
                </div>

                <form :action="editBooking ? `/bookings/${editBooking.id}` : '{{ route('bookings.store') }}'" method="POST">
                    @csrf
                    <template x-if="editBooking">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">رقم الفاتورة (اختياري)</label>
                            <input type="text" name="invoice_no" x-bind:value="editBooking?.invoice_no ?? '{{ old('invoice_no') }}'"
                                   placeholder="يترك فارغاً للتوليد التلقائي"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('invoice_no') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                            @error('invoice_no') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">نوع العقد *</label>
                            <select name="contract_type" class="w-full bg-gray-50 dark:bg-gray-800 border @error('contract_type') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                                <option value="rental" x-bind:selected="editBooking ? editBooking.contract_type == 'rental' : '{{ old('contract_type') }}' == 'rental'" {{ old('contract_type') == 'rental' ? 'selected' : '' }}>إيجار</option>
                                <option value="sale" x-bind:selected="editBooking ? editBooking.contract_type == 'sale' : '{{ old('contract_type') }}' == 'sale'" {{ old('contract_type') == 'sale' ? 'selected' : '' }}>بيع</option>
                            </select>
                            @error('contract_type') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الفستان *</label>
                            <select name="dress_id" @change="onDressChange($event.target.value)"
                                    class="w-full bg-gray-50 dark:bg-gray-800 border @error('dress_id') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                                <option value="">— اختر الفستان —</option>
                                @foreach($dresses as $dress)
                                    <option value="{{ $dress->id }}" 
                                            x-bind:disabled="!editBooking && '{{ $dress->current_status }}' != 'available'"
                                            x-bind:selected="editBooking ? editBooking.dress_id == {{ $dress->id }} : {{ old('dress_id', 'null') }} == {{ $dress->id }}"
                                            {{ old('dress_id') == $dress->id ? 'selected' : '' }}>
                                        {{ $dress->name }} ({{ $dress->dress_type }}) 
                                        @if($dress->current_status != 'available')
                                            — [{{ $dress->current_status == 'booked' ? 'محجوز' : 'تنظيف' }}]
                                        @endif
                                        — {{ number_format($dress->rental_price, 0) }} ر.س
                                    </option>
                                @endforeach
                            </select>
                            @error('dress_id') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <template x-if="editBooking">
                            <div>
                                <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">الحالة</label>
                                <select name="status" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                                    <option value="active" x-bind:selected="editBooking?.status == 'active'">نشط</option>
                                    <option value="delivered" x-bind:selected="editBooking?.status == 'delivered'">مسلم</option>
                                    <option value="completed" x-bind:selected="editBooking?.status == 'completed'">مكتمل</option>
                                    <option value="cancelled" x-bind:selected="editBooking?.status == 'cancelled'">ملغى</option>
                                </select>
                            </div>
                        </template>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">اسم العميل *</label>
                            <input type="text" name="customer_name" x-bind:value="editBooking?.customer_name ?? '{{ old('customer_name') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('customer_name') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('customer_name') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">رقم الجوال *</label>
                            <input type="text" name="customer_phone" x-bind:value="editBooking?.customer_phone ?? '{{ old('customer_phone') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('customer_phone') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('customer_phone') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">تاريخ الفرح *</label>
                            <input type="date" name="reserved_for_date" x-bind:value="editBooking?.reserved_for_date?.split('T')[0] ?? '{{ old('reserved_for_date') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('reserved_for_date') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('reserved_for_date') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">تاريخ الاستلام *</label>
                            <input type="date" name="output_date" x-bind:value="editBooking?.output_date?.split('T')[0] ?? '{{ old('output_date') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('output_date') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('output_date') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">تاريخ الإرجاع</label>
                            <input type="date" name="return_date" x-bind:value="editBooking?.return_date?.split('T')[0] ?? '{{ old('return_date') }}'"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('return_date') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                            @error('return_date') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">نسبة الخصم %</label>
                            <input type="number" name="discount_percent" x-model.number="discount" min="0" max="100"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('discount_percent') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                            @error('discount_percent') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">المبلغ الإجمالي *</label>
                            <input type="number" name="total_amount" step="0.01" min="0" x-model.number="total"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('total_amount') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500" required>
                            @error('total_amount') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">المبلغ المدفوع مقدماً</label>
                            <input type="number" name="paid_advance" x-model.number="advance" step="0.01" min="0"
                                   class="w-full bg-gray-50 dark:bg-gray-800 border @error('paid_advance') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                            @error('paid_advance') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">المبلغ المتبقي *</label>
                            <input type="number" name="remaining_amount" step="0.01" min="0" x-bind:value="remaining" readonly
                                   class="w-full bg-gray-200 dark:bg-gray-700 border @error('remaining_amount') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none cursor-not-allowed" required>
                            @error('remaining_amount') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">طريقة دفع العربون</label>
                            <select name="payment_method" class="w-full bg-gray-50 dark:bg-gray-800 border @error('payment_method') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500">
                                <option value="cash" x-bind:selected="editBooking ? editBooking.payment_method == 'cash' : '{{ old('payment_method') }}' == 'cash'" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدي</option>
                                <option value="transfer" x-bind:selected="editBooking ? editBooking.payment_method == 'transfer' : '{{ old('payment_method') }}' == 'transfer'" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>حوالة</option>
                            </select>
                            @error('payment_method') <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">تعديلات الفستان</label>
                            <textarea name="dress_adjustments" rows="2" x-text="editBooking?.dress_adjustments ?? '{{ old('dress_adjustments') }}'"
                                      class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">ملاحظات</label>
                            <textarea name="notes" rows="2" x-text="editBooking?.notes ?? '{{ old('notes') }}'"
                                      class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-2.5 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showForm = false"
                                class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white">إلغاء</button>
                        <button type="submit"
                                class="px-6 py-2 bg-primary-600 hover:bg-primary-500 text-gray-900 dark:text-white text-sm rounded-xl transition-colors" x-text="editBooking ? 'تحديث الحجز' : 'حفظ الحجز'"></button>
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
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">#</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">العميل</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الفستان</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">تاريخ الاستلام</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الإجمالي</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">المتبقي</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">الحالة</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 font-medium px-4 py-3">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($bookings as $booking)
                    @php
                        $sc = ['active'=>'blue','delivered'=>'purple','completed'=>'emerald','cancelled'=>'red'][$booking->status] ?? 'gray';
                        $sl = ['active'=>'نشط','delivered'=>'مُسلَّم','completed'=>'مكتمل','cancelled'=>'ملغى'][$booking->status] ?? $booking->status;
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                            <span class="block font-medium text-gray-900 dark:text-white">{{ $booking->invoice_no ?? '#' . $booking->id }}</span>
                            <span class="text-[10px] opacity-50">ID: {{ $booking->id }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $booking->customer_name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->customer_phone }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $booking->dress?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $booking->output_date?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-white">{{ number_format($booking->total_amount, 0) }} ر.ي</td>
                        <td class="px-4 py-3 {{ floatval($booking->remaining_amount) > 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                            {{ number_format($booking->remaining_amount, 0) }} ر.ي
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-{{ $sc }}-100 dark:bg-{{ $sc }}-900/40 text-black dark:text-{{ $sc }}-400 border border-{{ $sc }}-200 dark:border-{{ $sc }}-700/40">{{ $sl }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button @click="showForm = true; editBooking = {{ $booking->toJson() }}"
                                    class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 transition-colors">تعديل</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-600 dark:text-gray-500">لا توجد حجوزات</td></tr>
                    @endforelse
                </tbody>
                @if($bookings->count() > 0)
                <tfoot class="bg-gray-50 dark:bg-gray-800/50 font-bold border-t border-gray-200 dark:border-gray-800">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-left">الإجمالي الكلي:</td>
                        <td class="px-4 py-3 text-gray-900 dark:text-white">{{ number_format($totalAmount, 0) }} ر.ي</td>
                        <td class="px-4 py-3 text-red-600 dark:text-red-400">{{ number_format($totalRemaining, 0) }} ر.ي</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
