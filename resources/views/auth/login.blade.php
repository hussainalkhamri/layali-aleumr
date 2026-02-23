<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول — ليالي العُمر</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-100 via-gray-50 to-gray-200 dark:from-gray-950 dark:via-gray-900 dark:to-primary-950 flex items-center justify-center font-sans">

<div class="w-full max-w-md px-4">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <img src="{{ asset('images/logo.svg') }}" alt="ليالي العُمر" class="w-24 h-auto mx-auto mb-4 drop-shadow-xl dark:drop-shadow-[0_4px_10px_rgba(255,255,255,0.1)] dark:brightness-0 dark:invert">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">نظام ليالي العُمر</h1>
    </div>

    {{-- Card --}}
    <div class="bg-white dark:bg-gray-900/80 backdrop-blur border border-gray-200 dark:border-gray-800 rounded-2xl p-8 shadow-2xl">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">تسجيل الدخول</h2>

        @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 dark:bg-red-900/40 border border-red-200 dark:border-red-700/50 rounded-xl text-red-600 dark:text-red-400 text-sm">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">اسم المستخدم</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500 transition-colors"
                       placeholder="أدخل اسم المستخدم" required autofocus>
            </div>

            <div>
                <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">كلمة المرور</label>
                <input type="password" name="password"
                       class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white text-sm focus:outline-none focus:border-primary-500 transition-colors"
                       placeholder="أدخل كلمة المرور" required>
            </div>

            <button type="submit"
                    class="w-full bg-gradient-to-r from-primary-600 to-primary-800 hover:from-primary-500 hover:to-primary-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg shadow-primary-500/20 hover:shadow-primary-500/30">
                دخول
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-800 text-center">
            <p class="text-xs text-gray-600 dark:text-gray-500">Admin: admin / admin123</p>
        </div>
    </div>
</div>

</body>
</html>
