<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="h-full" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'منصة التطوع') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            @if(in_array(app()->getLocale(), ['ar', 'he', 'ur']))
            body {
                font-family: 'Cairo', 'figtree', sans-serif;
            }
            @endif
        </style>
    </head>
    <body class="font-sans antialiased h-full transition-colors duration-200 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- إضافة مكون الإشعارات التفاعلية -->
            <x-toaster />
            
            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow mt-auto py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            © {{ date('Y') }} منصة التطوع - جميع الحقوق محفوظة
                        </div>
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <!-- زر الوضع المظلم تم نقله إلى الشريط العلوي -->
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @stack('modals')
    </body>
</html>
