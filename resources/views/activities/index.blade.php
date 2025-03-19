<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('جميع النشاطات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">النشاطات الأخيرة</h3>
                    
                    @if(count($recentActivities) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($recentActivities as $activity)
                                <x-activity-card :activity="$activity" />
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">لا توجد نشاطات حديثة</p>
                            <a href="{{ route('job-offers.index') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition">
                                استكشف فرص التطوع
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- أقسام أخرى للنشاطات -->
            @if($participationRequests->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">فرص التطوع المشارك بها</h3>
                    <div class="space-y-3">
                        @foreach($participationRequests as $request)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div>
                                    <h5 class="font-semibold text-indigo-700 dark:text-indigo-400">{{ $request->jobOffer->title }}</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $request->jobOffer->organization->name }}</p>
                                    <div class="text-xs mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            @if($request->status === 'pending' || $request->status === 'معلق') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                            @elseif($request->status === 'accepted' || $request->status === 'مقبول') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 
                                            @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                            @if($request->status === 'pending' || $request->status === 'معلق') قيد المراجعة
                                            @elseif($request->status === 'accepted' || $request->status === 'مقبول') مقبول
                                            @else مرفوض @endif
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('job-offers.show', $request->jobOffer) }}" class="self-end sm:self-auto px-3 py-1.5 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-md text-sm hover:bg-indigo-200 dark:hover:bg-indigo-800 transition whitespace-nowrap">
                                    عرض التفاصيل
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($donations->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">التبرعات</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($donations as $donation)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg hover:shadow-md transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h5 class="font-semibold text-green-700 dark:text-green-400">{{ number_format($donation->amount) }} ل.س</h5>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $donation->date->format('Y-m-d') }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    {{ optional($donation->ad)->title ?? 'حملة تطوعية' }}
                                </p>
                                @if($donation->ad)
                                <div class="mt-2 text-right">
                                    <a href="{{ route('ads.show', $donation->ad) }}" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-md text-sm hover:bg-green-200 dark:hover:bg-green-800 transition">
                                        عرض الحملة
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($badges->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">الشارات</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($badges as $userBadge)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg text-center hover:shadow-md transition-shadow duration-200">
                                <div class="w-16 h-16 mx-auto mb-2 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h5 class="font-semibold text-gray-800 dark:text-gray-200">{{ $userBadge->badge->name }}</h5>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $userBadge->created_at->format('Y-m-d') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 