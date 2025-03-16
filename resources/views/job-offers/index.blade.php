<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('فرص التطوع المتاحة') }}
            </h2>
            @can('create', App\Models\JobOffer::class)
            <a href="{{ route('job-offers.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('إضافة فرصة جديدة') }}
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    @if($jobOffers->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">{{ __('لا توجد فرص تطوع متاحة حالياً') }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($jobOffers as $jobOffer)
                                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $jobOffer->title }}</h3>
                                            <span class="px-2 py-1 text-xs rounded 
                                                @if($jobOffer->status == 'متاحة') bg-green-100 text-green-800
                                                @elseif($jobOffer->status == 'مغلقة') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ $jobOffer->status }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-4">{{ Str::limit($jobOffer->description, 100) }}</p>
                                        
                                        <div class="mb-4">
                                            <span class="text-sm text-gray-700 block mb-1">
                                                <i class="fas fa-building ml-1"></i> {{ $jobOffer->organization->name }}
                                            </span>
                                            <span class="text-sm text-gray-700 block">
                                                <i class="fas fa-calendar-alt ml-1"></i> آخر موعد: {{ $jobOffer->deadline->format('Y-m-d') }}
                                            </span>
                                        </div>
                                        
                                        <a href="{{ route('job-offers.show', $jobOffer) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-300">
                                            {{ __('عرض التفاصيل') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $jobOffers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 