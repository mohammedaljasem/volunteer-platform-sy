<div class="mt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('فرص التطوع') }}</h3>
    
    @if(count($jobOffers) === 0)
        <div class="mt-4 text-gray-500 dark:text-gray-400">
            {{ __('لا توجد فرص تطوع متاحة حالياً في هذه المنظمة.') }}
        </div>
    @else
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($jobOffers as $jobOffer)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-4">
                        <h4 class="text-md font-semibold mb-2 dark:text-gray-200">{{ $jobOffer->title }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($jobOffer->description, 100) }}</p>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('تاريخ البدء') }}: {{ $jobOffer->start_date ? $jobOffer->start_date->format('Y-m-d') : __('غير محدد') }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('المتطوعين المطلوبين') }}: {{ $jobOffer->total_positions }}</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $jobOffer->location }}</span>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('job-offers.show', $jobOffer) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-blue-700 dark:hover:bg-blue-600">
                                {{ __('التفاصيل') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4 dark:text-gray-200">
            {{ $jobOffers->links() }}
        </div>
    @endif
    
    @php
        $isManager = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->where('role', 'مدير')
            ->exists();
    @endphp
    
    @if($isManager)
        <div class="mt-4">
            <a href="{{ route('job-offers.create', ['organization_id' => $organization->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-blue-700 dark:hover:bg-blue-600">
                {{ __('إضافة فرصة تطوع جديدة') }}
            </a>
        </div>
    @endif
</div> 