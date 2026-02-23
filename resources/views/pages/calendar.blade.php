@extends('layouts.app')
@section('title', 'التقويم')
@section('page-title', 'تقويم الحجوزات')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">جدول الحجوزات</h2>
        <div class="flex gap-4 text-xs text-gray-600 dark:text-gray-400">
            <span class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-yellow-500"></div> نشط</span>
            <span class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-green-500"></div> مكتمل</span>
            <span class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-red-500"></div> ملغي</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-4 sm:p-6 shadow-sm">
        <div id="calendar" class="w-full min-h-[600px] text-gray-900 dark:text-gray-100"></div>
    </div>
</div>

<!-- FullCalendar Library -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($bookings);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ar',
            direction: 'rtl',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'اليوم',
                month: 'شهر',
                week: 'أسبوع',
                day: 'يوم',
                list: 'أجندة'
            },
            events: events,
            eventClick: function(info) {
                if(info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                }
            },
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            }
        });
        calendar.render();
    });
</script>

<style>
    /* Tailwind Dark Mode Overrides for FullCalendar */
    .dark .fc-theme-standard .fc-scrollgrid,
    .dark .fc-theme-standard th,
    .dark .fc-theme-standard td {
        border-color: #374151 !important;
    }
    .dark .fc-col-header-cell-cushion,
    .dark .fc-daygrid-day-number {
        color: #f3f4f6 !important;
    }
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.85rem;
    }
    .dark .fc .fc-button-primary {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    .dark .fc .fc-button-primary:hover {
        background-color: #4338ca;
        border-color: #4338ca;
    }
    .dark .fc .fc-button-primary:disabled {
        background-color: #312e81;
        border-color: #312e81;
    }
    .fc .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 600;
    }
</style>
@endsection
