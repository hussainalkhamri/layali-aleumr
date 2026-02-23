<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام ليالي العُمر')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="h-full bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100 font-sans" x-data="{ sidebarOpen: true }">

<div class="flex h-full">

    {{-- ── Sidebar ──────────────────────────────────────────────── --}}
    <aside class="transition-all duration-300 bg-gray-50 border-l border-gray-200 dark:bg-gray-900 dark:border-gray-800 flex flex-col z-20"
           :class="sidebarOpen ? 'w-64' : 'w-16'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 p-4 border-b border-gray-200 dark:border-gray-800 min-h-[64px]">
            <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center">
                <img src="{{ asset('images/logo.svg') }}" alt="نظام ليالي العُمر" class="w-full h-full object-contain dark:brightness-0 dark:invert transition-all">
            </div>
            <div x-show="sidebarOpen" class="overflow-hidden">
                <p class="text-sm font-bold text-primary-700 dark:text-primary-400 leading-tight whitespace-nowrap">نظام ليالي العُمر</p>
                
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto p-2 space-y-1">
            @php
                $user = auth()->user()->load('role');
                $navItems = [
                    ['route' => 'dashboard',       'icon' => '⊞', 'label' => 'لوحة التحكم',   'perm' => null],
                    ['route' => 'dresses.index',   'icon' => '👗', 'label' => 'الفساتين',       'perm' => null],
                    ['route' => 'bookings.index',  'icon' => '📋', 'label' => 'الحجوزات',       'perm' => null],
                    ['route' => 'receipts.index',  'icon' => '🧾', 'label' => 'الإيصالات',      'perm' => null],
                    ['route' => 'expenses.index',  'icon' => '💸', 'label' => 'المصروفات',      'perm' => null],
                    ['route' => 'calendar.index',  'icon' => '📅', 'label' => 'التقويم',        'perm' => null],
                    ['route' => 'branches.index',  'icon' => '🏬', 'label' => 'الفروع',         'perm' => 'manage_branches'],
                    ['route' => 'users.index',     'icon' => '👤', 'label' => 'المستخدمون',     'perm' => 'manage_users'],
                    ['route' => 'roles.index',     'icon' => '🔑', 'label' => 'الأدوار',        'perm' => 'manage_roles'],
                    ['route' => 'audit-logs.index','icon' => '📝', 'label' => 'سجل العمليات',   'perm' => 'view_audit'],
                    ['route' => 'insights.index',  'icon' => '✨', 'label' => 'تحليلات AI',     'perm' => 'view_insights'],
                ];
            @endphp

            @foreach($navItems as $item)
                @if(!$item['perm'] || $user->hasPermission($item['perm']))
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150 group
                              {{ request()->routeIs($item['route']) ? 'bg-primary-50 text-primary-700 border border-primary-200 dark:bg-primary-900/30 dark:text-primary-400 dark:border-primary-800/50' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100' }}">
                        <span class="text-lg flex-shrink-0">{{ $item['icon'] }}</span>
                        <span x-show="sidebarOpen" class="whitespace-nowrap overflow-hidden">{{ $item['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>

        {{-- User --}}
        <div class="p-3 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3" x-show="sidebarOpen">
                <div class="w-8 h-8 rounded-full bg-primary-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ mb_substr(auth()->user()->full_name, 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-medium truncate text-gray-900 dark:text-white">{{ auth()->user()->full_name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->branch?->name ?? 'الإدارة العامة' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30 transition-colors">
                    <span>🚪</span>
                    <span x-show="sidebarOpen">تسجيل الخروج</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main ─────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="bg-gray-50 border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800 px-4 h-16 flex items-center justify-between flex-shrink-0 relative z-10">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">@yield('page-title', '')</span>
                <button onclick="document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'" 
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors"
                        title="تبديل المظهر">
                    {{-- Sun Icon for Dark Mode (to switch to light) --}}
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Moon Icon for Light Mode (to switch to dark) --}}
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mx-6 mt-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-900/40 dark:border-emerald-700/50 rounded-lg dark:text-emerald-400 text-sm">
            ✓ {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/40 dark:border-red-700/50 rounded-lg dark:text-red-400 text-sm">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
