@extends('layouts.app')
@section('title', 'سجل العمليات')
@section('page-title', 'سجل العمليات')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">آخر {{ $logs->count() }} عملية</h2>
        <form action="{{ route('audit-logs.index') }}" method="GET" class="w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث عن مستخدم أو عملية..." 
                   class="w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-1.5 text-sm text-gray-900 dark:text-white focus:outline-none focus:border-primary-500">
        </form>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">العملية</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">الجدول</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">السجل</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">المستخدم</th>
                        <th class="text-right text-xs text-gray-500 dark:text-gray-400 px-4 py-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($logs as $log)
                    @php 
                        $actions = ['CREATE'=>'إضافة','UPDATE'=>'تعديل','DELETE'=>'حذف','LOGIN'=>'دخول'];
                        $tables = [
                            'dresses' => 'الفساتين',
                            'booking_invoices' => 'الحجوزات',
                            'receipts' => 'الإيصالات',
                            'expenses' => 'المصروفات',
                            'users' => 'المستخدمين',
                            'roles' => 'الأدوار',
                            'branches' => 'الفروع'
                        ];
                        $c = ['CREATE'=>'emerald','UPDATE'=>'blue','DELETE'=>'red','LOGIN'=>'purple'][$log->action_type] ?? 'gray'; 
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-{{ $c }}-100 dark:bg-{{ $c }}-900/40 text-black dark:text-{{ $c }}-400 border border-{{ $c }}-200 dark:border-{{ $c }}-700/40">
                                {{ $actions[$log->action_type] ?? $log->action_type }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 font-medium">{{ $tables[$log->table_name] ?? $log->table_name }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">#{{ $log->record_id }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $log->user?->full_name ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 dark:text-gray-400 text-xs">{{ $log->created_at?->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-600 dark:text-gray-500">لا توجد سجلات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
