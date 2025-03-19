<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('جميع النشاطات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">النشاطات الأخيرة</h3>
                    
                    @if(count($recentActivities) > 0)
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg relative overflow-hidden">
                                    <div class="absolute top-0 right-0 h-full w-1 
                                        @if($activity['color'] == 'blue') bg-blue-500
                                        @elseif($activity['color'] == 'green') bg-green-500
                                        @elseif($activity['color'] == 'yellow') bg-yellow-500
                                        @else bg-gray-500
                                        @endif">
                                    </div>
                                    <div class="flex items-start space-x-4 space-x-reverse">
                                        <span class="flex-shrink-0 h-10 w-10 rounded-full 
                                            @if($activity['color'] == 'blue') bg-blue-100
                                            @elseif($activity['color'] == 'green') bg-green-100
                                            @elseif($activity['color'] == 'yellow') bg-yellow-100
                                            @else bg-gray-100
                                            @endif flex items-center justify-center">
                                            @if($activity['icon'] == 'add')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                                                    @if($activity['color'] == 'blue') text-blue-600
                                                    @elseif($activity['color'] == 'green') text-green-600
                                                    @elseif($activity['color'] == 'yellow') text-yellow-600
                                                    @else text-gray-600
                                                    @endif" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif($activity['icon'] == 'money')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                                                    @if($activity['color'] == 'blue') text-blue-600
                                                    @elseif($activity['color'] == 'green') text-green-600
                                                    @elseif($activity['color'] == 'yellow') text-yellow-600
                                                    @else text-gray-600
                                                    @endif" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            @elseif($activity['icon'] == 'badge')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 
                                                    @if($activity['color'] == 'blue') text-blue-600
                                                    @elseif($activity['color'] == 'green') text-green-600
                                                    @elseif($activity['color'] == 'yellow') text-yellow-600
                                                    @else text-gray-600
                                                    @endif" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            @endif
                                        </span>
                                        <div class="flex-1">
                                            <p class="text-gray-800 font-medium mb-1">{{ $activity['title'] }}</p>
                                            <p class="text-sm text-gray-500">
                                                {{ $activity['date']->diffForHumans() }}
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ $activity['link'] }}" class="inline-flex items-center text-sm font-medium 
                                                    @if($activity['color'] == 'blue') text-blue-600 hover:text-blue-800
                                                    @elseif($activity['color'] == 'green') text-green-600 hover:text-green-800
                                                    @elseif($activity['color'] == 'yellow') text-yellow-600 hover:text-yellow-800
                                                    @else text-gray-600 hover:text-gray-800
                                                    @endif">
                                                    عرض التفاصيل
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>لا توجد نشاطات حديثة</p>
                            <a href="{{ route('ads.index') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                استكشف الحملات التطوعية
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- أقسام أخرى للنشاطات -->
            @if($participationRequests->count() > 0)
            <div class="mt-6 bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">فرص التطوع المشارك بها</h3>
                    <div class="space-y-3">
                        @foreach($participationRequests as $request)
                            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                                <div>
                                    <h5 class="font-semibold text-indigo-700">{{ $request->jobOffer->title }}</h5>
                                    <p class="text-sm text-gray-600">{{ $request->jobOffer->organization->name }}</p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs 
                                            @if($request->status === 'pending' || $request->status === 'معلق') bg-yellow-100 text-yellow-800
                                            @elseif($request->status === 'accepted' || $request->status === 'مقبول') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($request->status === 'pending' || $request->status === 'معلق') قيد المراجعة
                                            @elseif($request->status === 'accepted' || $request->status === 'مقبول') مقبول
                                            @else مرفوض @endif
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ route('job-offers.show', $request->jobOffer) }}" class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-md text-sm hover:bg-indigo-200">
                                    عرض التفاصيل
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($donations->count() > 0)
            <div class="mt-6 bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">التبرعات</h3>
                    <div class="space-y-3">
                        @foreach($donations as $donation)
                            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                                <div>
                                    <h5 class="font-semibold text-green-700">{{ number_format($donation->amount) }} ل.س</h5>
                                    <p class="text-sm text-gray-600">{{ optional($donation->ad)->title ?? 'حملة تطوعية' }}</p>
                                    <div class="text-xs text-gray-500 mt-1">{{ $donation->date->format('Y-m-d') }}</div>
                                </div>
                                @if($donation->ad)
                                <a href="{{ route('ads.show', $donation->ad) }}" class="px-3 py-1 bg-green-100 text-green-800 rounded-md text-sm hover:bg-green-200">
                                    عرض الحملة
                                </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            @if($badges->count() > 0)
            <div class="mt-6 bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">الشارات</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($badges as $userBadge)
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <div class="w-16 h-16 mx-auto mb-2 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h5 class="font-semibold text-gray-800">{{ $userBadge->badge->name }}</h5>
                                <p class="text-xs text-gray-500 mt-1">{{ $userBadge->created_at->format('Y-m-d') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 