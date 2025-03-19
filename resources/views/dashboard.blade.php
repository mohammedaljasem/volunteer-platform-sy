<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-600 dark:text-green-400 leading-tight">
                {{ __('لوحة التحكم') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- قسم الترحيب -->
            <div class="relative bg-gradient-to-r from-green-500 to-green-600 dark:from-green-600 dark:to-green-800 p-8 mb-6 rounded-xl shadow-lg overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full text-white">
                        <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between relative z-10">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="ml-4 flex items-center justify-center bg-white dark:bg-gray-800 rounded-full p-1 overflow-hidden shadow-md" style="width: 80px; height: 80px;">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover rounded-full">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">مرحباً بك {{ Auth::user()->name }}</h3>
                            <p class="text-green-50">نحن سعداء بانضمامك لمجتمع المتطوعين، استكشف الفرص المتاحة وابدأ رحلة العطاء</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-white border border-transparent rounded-md font-semibold text-xs text-green-700 uppercase tracking-widest hover:bg-green-50 active:bg-white focus:outline-none focus:border-green-300 focus:ring ring-green-200 disabled:opacity-25 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            تعديل الملف الشخصي
                        </a>
                    </div>
                </div>
            </div>

            <!-- قسم الإحصائيات -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- بطاقة إحصائية 1 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-emerald-100 dark:bg-emerald-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">المتطوعون النشطون</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $activeVolunteersCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                                <div class="h-1 bg-emerald-500 dark:bg-emerald-400 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 2 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">الحملات النشطة</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $activeCampaignsCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                                <div class="h-1 bg-blue-500 dark:bg-blue-400 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 3 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-amber-100 dark:bg-amber-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">إجمالي التبرعات (ل.س)</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalDonations) }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                                <div class="h-1 bg-amber-500 dark:bg-amber-400 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 4 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">النشاطات القادمة</p>
                                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $upcomingActivities }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-full">
                                <div class="h-1 bg-indigo-500 dark:bg-indigo-400 rounded-full" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تقسيم المحتوى إلى عمودين -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- العمود الأيمن: الحملات الموصى بها -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <div class="p-5 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">الحملات الموصى بها</h3>
                                <a href="{{ route('ads.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">عرض الكل</a>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @forelse($recommendedCampaigns as $campaign)
                                    <div class="bg-white dark:bg-gray-700 border dark:border-gray-600 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-300">
                                @if($campaign->image)
                                            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" 
                                                class="w-full h-44 object-cover hover:scale-105 transition-transform duration-300">
                                @else
                                            <div class="w-full h-44 bg-gray-100 dark:bg-gray-600 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                            <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-gray-800 dark:text-gray-200">{{ $campaign->title }}</h4>
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 font-semibold">
                                                    {{ $campaign->progress_percentage }}%
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ Str::limit($campaign->description, 80) }}</p>
                                            <div class="mt-3">
                                                <div class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                                    <div class="h-full bg-green-500 dark:bg-green-400 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                                                </div>
                                                <div class="flex justify-between text-xs mt-1">
                                                    <span class="font-medium text-gray-500 dark:text-gray-400">جُمع: {{ number_format($campaign->current_amount) }} ل.س</span>
                                                    <span class="font-medium text-gray-500 dark:text-gray-400">الهدف: {{ number_format($campaign->target_amount) }} ل.س</span>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex justify-between items-center">
                                                <a href="{{ route('ads.show', $campaign->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 text-sm font-medium">
                                                    عرض التفاصيل
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('ads.donate', $campaign->id) }}" class="px-3 py-1 text-sm font-medium bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-md transition">
                                                    تبرع الآن
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-2 text-center py-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 mt-2">لا توجد حملات موصى بها حاليًا</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- العمود الأيسر: نشاطك و الأحداث القادمة -->
                <div>
                    <!-- نشاطك الأخير -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">نشاطك الأخير</h2>
                                <a href="{{ route('activities.index') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition-colors">
                                    عرض كل النشاطات
                                </a>
                            </div>
                            <div class="overflow-hidden">
                                @forelse($recentActivities as $activity)
                                    <x-activity-card :activity="$activity" :compact="true" class="mb-3" />
                                    @if(!$loop->last)
                                    <hr class="border-gray-200 dark:border-gray-700 my-3">
                                    @endif
                                @empty
                                <div class="text-center py-4">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400">لا توجد أنشطة حتى الآن</p>
                                    <a href="{{ route('job-offers.index') }}" class="mt-2 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">استكشف فرص التطوع</a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- الأحداث القادمة -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <div class="p-5 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">الأحداث القادمة</h3>
                            </div>
                        </div>
                        <div class="p-5">
                            <ul class="space-y-3">
                                <li class="bg-indigo-50 dark:bg-indigo-900/40 p-3 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="mr-3 text-center">
                                            <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400">يونيو</p>
                                            <p class="text-lg font-bold text-indigo-800 dark:text-indigo-300">15</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">يوم التطوع العالمي</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">دمشق - 10:00 صباحًا</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-green-50 dark:bg-green-900/40 p-3 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="mr-3 text-center">
                                            <p class="text-xs font-medium text-green-600 dark:text-green-400">يوليو</p>
                                            <p class="text-lg font-bold text-green-800 dark:text-green-300">02</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">حملة تنظيف الشاطئ</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">اللاذقية - 09:00 صباحًا</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="bg-amber-50 dark:bg-amber-900/40 p-3 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="mr-3 text-center">
                                            <p class="text-xs font-medium text-amber-600 dark:text-amber-400">يوليو</p>
                                            <p class="text-lg font-bold text-amber-800 dark:text-amber-300">10</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">توزيع الحقائب المدرسية</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">حمص - 11:00 صباحًا</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="mt-4 text-center">
                                <a href="{{ route('events.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">عرض جميع الأحداث</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
