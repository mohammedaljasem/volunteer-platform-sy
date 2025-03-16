<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>

    <div class="py-12 rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- قسم الترحيب -->
            <div class="bg-green-100 border-r-4 border-green-500 p-6 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="ml-4 flex items-center justify-center bg-white rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V12m0 0V4m0 8h8m-8 0H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">مرحباً بك {{ Auth::user()->name }} في منصة التطوع</h3>
                        <p class="text-gray-600">نحن سعداء بانضمامك لمجتمع المتطوعين، استكشف الفرص المتاحة وابدأ رحلة العطاء</p>
                    </div>
                </div>
            </div>

            <!-- قسم الإحصائيات -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- بطاقة إحصائية 1 -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-primary bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">المتطوعون النشطون</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $activeVolunteersCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 2 -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-secondary bg-opacity-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">الحملات النشطة</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $activeCampaignsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 3 -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-yellow-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">إجمالي التبرعات (ل.س)</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalDonations) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إحصائية 4 -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">النشاطات القادمة</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $upcomingActivities }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الحملات الموصى بها -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">الحملات الموصى بها</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($recommendedCampaigns as $campaign)
                            <div class="card">
                                @if($campaign->image)
                                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="font-bold text-gray-800">{{ $campaign->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($campaign->description, 100) }}</p>
                                    <div class="mt-3">
                                        <div class="progress-bar">
                                            <div class="progress-value" @if($campaign->progress_percentage <= 25) style="width: 25%" @elseif($campaign->progress_percentage <= 50) style="width: 50%" @elseif($campaign->progress_percentage <= 75) style="width: 75%" @else style="width: 100%" @endif></div>
                                        </div>
                                        <div class="flex justify-between text-xs mt-1">
                                            <span>{{ $campaign->progress_percentage }}%</span>
                                            <span>الهدف: {{ number_format($campaign->target_amount) }} ل.س</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('ads.show', $campaign->id) }}" class="btn-primary block text-center mt-4">عرض التفاصيل</a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-6">
                                <p class="text-gray-500">لا توجد حملات موصى بها حاليًا</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
