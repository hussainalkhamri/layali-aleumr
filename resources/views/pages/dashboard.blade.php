@extends('layouts.app')
@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('content')
<div class="space-y-6">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'إجمالي الفساتين',    'value' => $totalDresses,    'icon' => '👗', 'color' => 'purple'],
                ['label' => 'الفساتين المتاحة',    'value' => $availableDresses, 'icon' => '✅', 'color' => 'emerald'],
                ['label' => 'الحجوزات النشطة',    'value' => $activeBookings,  'icon' => '📋', 'color' => 'blue'],
                ['label' => 'حجوزات قادمة (أسبوع)', 'value' => $upcomingBookings, 'icon' => '📅', 'color' => 'amber'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5 hover:border-gray-300 dark:hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">{{ $stat['icon'] }}</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Revenue Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-1">إجمالي الإيرادات</p>
            <p class="text-xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($totalRevenue, 2) }} ر.ي</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-1">إيرادات هذا الشهر</p>
            <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($monthlyRevenue, 2) }} ر.ي</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <p class="text-xs text-gray-500 mb-1">مدفوعات معلقة</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ number_format($pendingPayments, 2) }} ر.ي</p>
        </div>
    </div>

    {{-- Today's Activity + Insights --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Today Activity --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-400 mb-4">نشاط اليوم</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-800">
                    <span class="text-sm text-gray-600 dark:text-gray-400">📦 استلامات اليوم</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $todayOutputs }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600 dark:text-gray-400">🔙 إرجاعات اليوم</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $todayReturns }}</span>
                </div>
            </div>
        </div>

        {{-- AI Insights --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-5">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-400 mb-4">✨ تحليلات النظام</h3>
            @if($recentInsights->isEmpty())
                <p class="text-sm text-gray-500">لا توجد تحليلات حالياً</p>
            @else
            <div class="space-y-3">
                @foreach($recentInsights as $insight)
                @php
                    $colors = ['INFO' => 'blue', 'WARNING' => 'amber', 'CRITICAL' => 'red'];
                    $c = $colors[$insight->level] ?? 'gray';
                @endphp
                <div class="p-3 rounded-xl bg-white dark:bg-gray-900 border border-{{ $c }}-200 dark:border-{{ $c }}-800/50 shadow-sm">
                    <p class="text-xs font-semibold text-gray-900 dark:text-white mb-1">{{ $insight->title }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $insight->content }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
