<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('طلبات المشاركة الخاصة بي') }}
        </h2>
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
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __('طلبات المشاركة التي قدمتها') }}</h3>
                        
                        @if($requests->isEmpty())
                            <div class="text-center py-8">
                                <p class="text-gray-500 text-lg">{{ __('لم تقم بتقديم أي طلبات مشاركة بعد') }}</p>
                                <a href="{{ route('job-offers.index') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                    {{ __('استعرض فرص التطوع المتاحة') }}
                                </a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($requests as $request)
                                    <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                        <div class="p-6">
                                            <div class="flex justify-between items-start">
                                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $request->jobOffer->title }}</h3>
                                                <span class="px-2 py-1 text-xs rounded 
                                                    @if($request->status == 'معلق') bg-yellow-100 text-yellow-800
                                                    @elseif($request->status == 'مقبول') bg-green-100 text-green-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ $request->status }}
                                                </span>
                                            </div>
                                            
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($request->jobOffer->description, 100) }}</p>
                                            
                                            <div class="mb-4">
                                                <span class="text-sm text-gray-700 block mb-1">
                                                    <i class="fas fa-building ml-1"></i> {{ $request->jobOffer->organization->name }}
                                                </span>
                                                <span class="text-sm text-gray-700 block mb-1">
                                                    <i class="fas fa-calendar-alt ml-1"></i> تاريخ الطلب: {{ $request->request_date->format('Y-m-d') }}
                                                </span>
                                                @if($request->response_date)
                                                <span class="text-sm text-gray-700 block">
                                                    <i class="fas fa-reply ml-1"></i> تاريخ الرد: {{ $request->response_date->format('Y-m-d') }}
                                                </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <a href="{{ route('participation-requests.show', $request) }}" class="text-blue-600 hover:text-blue-800">
                                                    {{ __('عرض التفاصيل') }}
                                                </a>
                                                
                                                <a href="{{ route('job-offers.show', $request->jobOffer) }}" class="text-gray-600 hover:text-gray-800">
                                                    {{ __('عرض الفرصة') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                {{ $requests->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 