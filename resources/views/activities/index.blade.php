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
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">النشاطات السابقة</h3>
                    
                    @if($participatedAds->count() > 0 || $participationRequests->count() > 0)
                        <div class="space-y-6">
                            <!-- حملات التطوع -->
                            @if($participatedAds->count() > 0)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-700 mb-3">الحملات التطوعية</h4>
                                    <div class="space-y-3">
                                        @foreach($participatedAds as $ad)
                                            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                                                <div>
                                                    <h5 class="font-semibold text-indigo-700">{{ $ad->title }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $ad->organization->name }}</p>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $ad->start_date->format('Y/m/d') }}</div>
                                                </div>
                                                <a href="{{ route('ads.show', $ad) }}" class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-md text-sm hover:bg-indigo-200">
                                                    عرض التفاصيل
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- طلبات المشاركة -->
                            @if($participationRequests->count() > 0)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-700 mb-3">فرص التطوع</h4>
                                    <div class="space-y-3">
                                        @foreach($participationRequests as $request)
                                            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                                                <div>
                                                    <h5 class="font-semibold text-indigo-700">{{ $request->jobOffer->title }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $request->jobOffer->organization->name }}</p>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs 
                                                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                                            @elseif($request->status === 'accepted') bg-green-100 text-green-800
                                                            @else bg-red-100 text-red-800 @endif">
                                                            @if($request->status === 'pending') قيد المراجعة
                                                            @elseif($request->status === 'accepted') مقبول
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
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>لا توجد نشاطات سابقة</p>
                            <a href="{{ route('ads.index') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                استكشف الحملات التطوعية
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 