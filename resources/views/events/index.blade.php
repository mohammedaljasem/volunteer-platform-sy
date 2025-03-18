<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('جميع الأحداث القادمة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">الأحداث القادمة</h3>
                    
                    @if($upcomingAds->count() > 0 || $upcomingJobOffers->count() > 0)
                        <div class="space-y-6">
                            <!-- حملات التطوع -->
                            @if($upcomingAds->count() > 0)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-700 mb-3">الحملات التطوعية</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($upcomingAds as $ad)
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex items-center mb-3">
                                                    <div class="text-center bg-indigo-100 rounded-lg p-2 mr-2">
                                                        <p class="text-xs font-medium text-indigo-600">{{ $ad->start_date->format('M') }}</p>
                                                        <p class="text-lg font-bold text-indigo-800">{{ $ad->start_date->format('d') }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-semibold text-indigo-700">{{ $ad->title }}</h5>
                                                        <p class="text-sm text-gray-600">{{ $ad->organization->name }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex justify-between items-center mt-3">
                                                    <span class="text-xs text-gray-500">{{ $ad->location }}</span>
                                                    <a href="{{ route('ads.show', $ad) }}" class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-md text-sm hover:bg-indigo-200">
                                                        عرض التفاصيل
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- فرص التطوع -->
                            @if($upcomingJobOffers->count() > 0)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-700 mb-3">فرص التطوع</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($upcomingJobOffers as $jobOffer)
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <div class="flex items-center mb-3">
                                                    <div class="text-center bg-green-100 rounded-lg p-2 mr-2">
                                                        <p class="text-xs font-medium text-green-600">{{ $jobOffer->start_date->format('M') }}</p>
                                                        <p class="text-lg font-bold text-green-800">{{ $jobOffer->start_date->format('d') }}</p>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-semibold text-green-700">{{ $jobOffer->title }}</h5>
                                                        <p class="text-sm text-gray-600">{{ $jobOffer->organization->name }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between items-center mt-3">
                                                    <span class="text-xs text-gray-500">{{ $jobOffer->location }}</span>
                                                    <a href="{{ route('job-offers.show', $jobOffer) }}" class="px-3 py-1 bg-green-100 text-green-800 rounded-md text-sm hover:bg-green-200">
                                                        عرض التفاصيل
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>لا توجد أحداث قادمة</p>
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