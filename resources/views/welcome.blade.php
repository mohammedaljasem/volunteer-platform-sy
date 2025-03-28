<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" 
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" 
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'منصة التطوع') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="relative min-h-screen">
        <!-- شريط التنقل -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- شعار الموقع -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('welcome') }}" class="flex items-center">
                                <img src="{{ asset('images/logo/volunteer-logo.png') }}" alt="منصة التطوع" class="h-12 w-auto">
                                <span class="mr-2 text-xl font-bold text-green-600 dark:text-green-400">منصة التطوع</span>
                            </a>
                        </div>

                        <!-- روابط التنقل -->
                        <div class="hidden space-x-8 space-x-reverse sm:-my-px sm:mr-10 sm:flex">
                            <a href="{{ route('map') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                <i class="fas fa-map-marker-alt ml-1"></i> {{ __('خريطة المواقع') }}
                            </a>
                            <a href="{{ route('organizations.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                <i class="fas fa-building ml-1"></i> {{ __('المنظمات') }}
                            </a>
                            <a href="{{ route('ads.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out">
                                <i class="fas fa-bullhorn ml-1"></i> {{ __('الحملات التطوعية') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:mr-6">
                        
                        <!-- زر تبديل الوضع الداكن/الفاتح -->
                        <button @click="darkMode = !darkMode" class="flex items-center justify-center h-10 w-10 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out mr-4" title="تبديل الوضع المظلم">
                            <template x-if="!darkMode">
                                <i class="fas fa-moon text-lg"></i>
                            </template>
                            <template x-if="darkMode">
                                <i class="fas fa-sun text-lg"></i>
                            </template>
                        </button>

                        @if (Route::has('login'))
                            <div class="space-x-4 space-x-reverse sm:flex">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-600 focus:bg-green-500 dark:focus:bg-green-600 active:bg-green-600 dark:active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">{{ __('لوحة التحكم') }}</a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">{{ __('تسجيل الدخول') }}</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 dark:hover:bg-green-600 focus:bg-green-500 dark:focus:bg-green-600 active:bg-green-600 dark:active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">{{ __('إنشاء حساب') }}</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>

                    <!-- زر القائمة للشاشات الصغيرة -->
                    <div class="-ml-2 ml-2 flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = ! mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-200 hover:text-gray-500 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- محتوى الصفحة الرئيسية -->
        <main class="py-8">
            <!-- قسم الترحيب الرئيسي -->
            <section class="bg-gradient-to-b from-green-500 to-green-700 dark:from-green-700 dark:to-green-900 text-white py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
                <div class="max-w-7xl mx-auto text-center relative z-10">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6">
                        منصة التطوع الأولى في سوريا
                    </h1>
                    <p class="text-xl md:text-2xl max-w-3xl mx-auto mb-10">
                        انضم إلينا وكن جزءاً من التغيير الإيجابي في المجتمع السوري
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-green-700 dark:bg-gray-800 dark:text-green-400 font-bold rounded-lg shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                            ابدأ التطوع الآن
                        </a>
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-transparent border-2 border-white font-bold rounded-lg hover:bg-white/10 transition duration-300">
                            لوحة التحكم
                        </a>
                    </div>
                </div>
                <!-- عناصر زخرفية في الخلفية -->
                <div class="absolute inset-0 z-0 opacity-20">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full mix-blend-multiply filter blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-white rounded-full mix-blend-multiply filter blur-3xl"></div>
                </div>
            </section>

            <!-- قسم المميزات -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 dark:text-gray-200">ما الذي يميزنا؟</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- ميزة 1 -->
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-hands-helping text-2xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-center text-gray-800 dark:text-gray-200">جمع المتطوعين</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-center">نربط بين المتطوعين والفرص التطوعية المناسبة لمهاراتهم واهتماماتهم</p>
                        </div>
                        <!-- ميزة 2 -->
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-building text-2xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-center text-gray-800 dark:text-gray-200">دعم المنظمات</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-center">نساعد المنظمات في إدارة حملاتها وجذب المتطوعين المناسبين</p>
                        </div>
                        <!-- ميزة 3 -->
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-medal text-2xl text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-center text-gray-800 dark:text-gray-200">نظام الشارات</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-center">نقدم شارات تحفيزية للمتطوعين عند إتمامهم الأنشطة التطوعية</p>
                        </div>
                        <!-- ميزة 4 -->
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full w-14 h-14 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-map-marked-alt text-2xl text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-center text-gray-800 dark:text-gray-200">خريطة تفاعلية</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-center">نوفر خريطة توضح مواقع الفرص التطوعية والمنظمات في جميع أنحاء سوريا</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- قسم إحصائيات -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800 dark:text-gray-200">إحصائيات المنصة</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- إحصائية 1: عدد المتطوعين النشطين -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md px-6 py-8 text-center">
                            <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">
                                {{ isset($stats['volunteersCount']) ? number_format($stats['volunteersCount']) : 0 }}+
                            </div>
                            <div class="text-gray-600 dark:text-gray-300">متطوع نشط</div>
                        </div>
                        <!-- إحصائية 2: عدد المنظمات المسجلة -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md px-6 py-8 text-center">
                            <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                                {{ isset($stats['organizationsCount']) ? number_format($stats['organizationsCount']) : 0 }}+
                            </div>
                            <div class="text-gray-600 dark:text-gray-300">منظمة مسجلة</div>
                        </div>
                        <!-- إحصائية 3: عدد الحملات التطوعية -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md px-6 py-8 text-center">
                            <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                                {{ isset($stats['campaignsCount']) ? number_format($stats['campaignsCount']) : 0 }}+
                            </div>
                            <div class="text-gray-600 dark:text-gray-300">حملة تطوعية</div>
                        </div>
                        <!-- إحصائية 4: إجمالي ساعات التطوع -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md px-6 py-8 text-center">
                            <div class="text-4xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">
                                {{ isset($stats['volunteerHours']) ? number_format($stats['volunteerHours']) : 0 }}+
                            </div>
                            <div class="text-gray-600 dark:text-gray-300">ساعة تطوعية</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- قسم دعوة للانضمام -->
            <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-green-600 to-green-800 dark:from-green-800 dark:to-green-900 text-white text-center">
                <div class="max-w-4xl mx-auto">
                    <h2 class="text-3xl font-bold mb-6">انضم إلى منصة التطوع اليوم</h2>
                    <p class="text-xl mb-8 opacity-90">كن جزءاً من مجتمع يصنع الفرق، وابدأ رحلتك في التطوع والعطاء</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-green-700 dark:bg-gray-800 dark:text-green-400 font-bold rounded-lg shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                            سجل كمتطوع
                        </a>
                        <a href="{{ route('organizations.create') }}" class="px-8 py-3 bg-transparent border-2 border-white font-bold rounded-lg hover:bg-white/10 transition duration-300">
                            سجل منظمتك
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- الفوتر -->
        <footer class="bg-white dark:bg-gray-800 shadow-sm py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('images/default-avatar.svg') }}" alt="منصة التطوع" class="h-8 w-auto">
                            <span class="mr-2 text-lg font-bold text-green-600 dark:text-green-400">منصة التطوع</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            المنصة الأولى للتطوع في سوريا، تجمع المتطوعين والمنظمات لخدمة المجتمع
                        </p>
                    </div>
                    <div>
                        <h3 class="text-gray-800 dark:text-gray-200 font-semibold mb-4">روابط سريعة</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('welcome') }}" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">الرئيسية</a></li>
                            <li><a href="{{ route('ads.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">الحملات التطوعية</a></li>
                            <li><a href="{{ route('organizations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">المنظمات</a></li>
                            <li><a href="{{ route('map') }}" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">خريطة المواقع</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-gray-800 dark:text-gray-200 font-semibold mb-4">تواصل معنا</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center"><i class="fas fa-envelope ml-2 text-gray-400"></i> <span class="text-gray-600 dark:text-gray-400">contact@volunteer-platform.sy</span></li>
                            <li class="flex items-center"><i class="fas fa-phone ml-2 text-gray-400"></i> <span class="text-gray-600 dark:text-gray-400">+963-11-1234567</span></li>
                            <li class="flex items-center"><i class="fas fa-map-marker-alt ml-2 text-gray-400"></i> <span class="text-gray-600 dark:text-gray-400">دمشق، سوريا</span></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} منصة التطوع - جميع الحقوق محفوظة</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>



