<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images/default-avatar.svg') }}" alt="منصة التطوع" class="h-10 w-auto">
                        <span class="mr-2 text-xl font-bold text-green-600 dark:text-green-400">منصة التطوع</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 space-x-reverse sm:-my-px sm:mr-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="dark:text-gray-300 dark:hover:text-white">
                        <i class="fas fa-home ml-1"></i> {{ __('الرئيسية') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ads.index')" :active="request()->routeIs('ads.*')" class="dark:text-gray-300 dark:hover:text-white">
                        <i class="fas fa-bullhorn ml-1"></i> {{ __('الحملات') }}
                    </x-nav-link>
                    <x-nav-link :href="route('job-offers.index')" :active="request()->routeIs('job-offers.*')" class="dark:text-gray-300 dark:hover:text-white">
                        <i class="fas fa-briefcase ml-1"></i> {{ __('فرص التطوع') }}
                    </x-nav-link>
                    <x-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')" class="dark:text-gray-300 dark:hover:text-white">
                        <i class="fas fa-chart-line ml-1"></i> {{ __('نشاطاتي') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:mr-6">
                <!-- Notifications -->
                <div class="mr-3 relative">
                    <x-dropdown align="left" width="80">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div class="relative">
                                    <i class="fas fa-bell text-xl"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="max-h-96 overflow-y-auto">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('الإشعارات') }}
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Notification Items -->
                                <div class="divide-y divide-gray-200 dark:divide-gray-600">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <div class="flex">
                                            <div class="flex-shrink-0 ml-3">
                                                <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-800 flex items-center justify-center">
                                                    <i class="fas fa-check text-green-600 dark:text-green-300"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">تمت الموافقة على طلب المشاركة</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">تمت الموافقة على طلب المشاركة في فرصة تنظيف الشاطئ</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">منذ ساعة واحدة</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <div class="flex">
                                            <div class="flex-shrink-0 ml-3">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-800 flex items-center justify-center">
                                                    <i class="fas fa-donate text-blue-600 dark:text-blue-300"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">تم استلام تبرع جديد</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">تم استلام تبرع بقيمة 5,000 ل.س للحملة التعليمية</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">منذ 3 ساعات</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <div class="flex">
                                            <div class="flex-shrink-0 ml-3">
                                                <div class="h-10 w-10 rounded-full bg-yellow-100 dark:bg-yellow-800 flex items-center justify-center">
                                                    <i class="fas fa-medal text-yellow-600 dark:text-yellow-300"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">لقد حصلت على شارة جديدة</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">تهانينا! لقد حصلت على شارة متطوع متميز</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">منذ يومين</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <a href="#" class="block text-center px-4 py-2 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    عرض كل الإشعارات
                                </a>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Dark Mode Toggle for Desktop -->
                <div class="mr-3">
                    <button @click="darkMode = !darkMode" class="flex items-center justify-center h-10 w-10 rounded-full text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                        <template x-if="!darkMode">
                            <i class="fas fa-moon text-lg"></i>
                        </template>
                        <template x-if="darkMode">
                            <i class="fas fa-sun text-lg"></i>
                        </template>
                    </button>
                </div>

                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full object-cover ml-2" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                <div>{{ Auth::user()->name }}</div>
                            </div>

                            <div class="mr-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="dark:text-gray-300 dark:hover:text-white">
                            <i class="fas fa-user-edit ml-2"></i> {{ __('الملف الشخصي') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.wallet')" class="dark:text-gray-300 dark:hover:text-white">
                            <i class="fas fa-wallet ml-2"></i> {{ __('المحفظة') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="dark:text-gray-300 dark:hover:text-white">
                                <i class="fas fa-sign-out-alt ml-2"></i> {{ __('تسجيل الخروج') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-home ml-1"></i> {{ __('الرئيسية') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ads.index')" :active="request()->routeIs('ads.*')" class="dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-bullhorn ml-1"></i> {{ __('الحملات') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('job-offers.index')" :active="request()->routeIs('job-offers.*')" class="dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-briefcase ml-1"></i> {{ __('فرص التطوع') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')" class="dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-chart-line ml-1"></i> {{ __('نشاطاتي') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" class="dark:text-gray-300 dark:hover:text-white">
                <i class="fas fa-bell ml-1"></i> {{ __('الإشعارات') }}
                <span class="bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 mr-1">3</span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="dark:text-gray-300 dark:hover:text-white">
                    <i class="fas fa-user-edit ml-2"></i> {{ __('الملف الشخصي') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.wallet')" class="dark:text-gray-300 dark:hover:text-white">
                    <i class="fas fa-wallet ml-2"></i> {{ __('المحفظة') }}
                </x-responsive-nav-link>

                <!-- Dark Mode Toggle for Mobile -->
                <x-responsive-nav-link @click="darkMode = !darkMode" class="cursor-pointer dark:text-gray-300 dark:hover:text-white">
                    <template x-if="!darkMode">
                        <i class="fas fa-moon ml-2"></i>
                    </template>
                    <template x-if="darkMode">
                        <i class="fas fa-sun ml-2"></i>
                    </template>
                    <span x-text="darkMode ? 'الوضع المضيء' : 'الوضع المظلم'"></span>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="dark:text-gray-300 dark:hover:text-white">
                        <i class="fas fa-sign-out-alt ml-2"></i>
                        {{ __('تسجيل الخروج') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
