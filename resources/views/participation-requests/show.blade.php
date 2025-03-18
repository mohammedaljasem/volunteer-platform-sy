<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('تفاصيل طلب المشاركة') }}
            </h2>
            <div class="flex space-x-2">
                @can('viewAny', App\Models\ParticipationRequest::class)
                <a href="{{ route('participation-requests.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة للقائمة') }}
                </a>
                @else
                <a href="{{ route('participation-requests.my') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة لطلباتي') }}
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">{{ __('طلب مشاركة في') }}: {{ $participationRequest->jobOffer->title }}</h1>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($participationRequest->status == 'معلق') bg-yellow-100 text-yellow-800
                            @elseif($participationRequest->status == 'مقبول') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $participationRequest->status }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">{{ __('معلومات المتطوع') }}</h3>
                            <p class="mb-1"><span class="font-semibold">{{ __('الاسم') }}:</span> {{ $participationRequest->user->name }}</p>
                            <p class="mb-1"><span class="font-semibold">{{ __('البريد الإلكتروني') }}:</span> {{ $participationRequest->user->email }}</p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">{{ __('معلومات الطلب') }}</h3>
                            <p class="mb-1"><span class="font-semibold">{{ __('تاريخ الطلب') }}:</span> {{ $participationRequest->request_date->format('Y-m-d') }}</p>
                            @if($participationRequest->response_date)
                            <p class="mb-1"><span class="font-semibold">{{ __('تاريخ الرد') }}:</span> {{ $participationRequest->response_date->format('Y-m-d') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">{{ __('تفاصيل فرصة التطوع') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="mb-1"><span class="font-semibold">{{ __('العنوان') }}:</span> {{ $participationRequest->jobOffer->title }}</p>
                            <p class="mb-1"><span class="font-semibold">{{ __('المنظمة') }}:</span> {{ $participationRequest->jobOffer->organization->name }}</p>
                            <p class="mb-1"><span class="font-semibold">{{ __('الموعد النهائي') }}:</span> {{ $participationRequest->jobOffer->deadline->format('Y-m-d') }}</p>
                            <p class="mb-3"><span class="font-semibold">{{ __('الحالة') }}:</span> {{ $participationRequest->jobOffer->status }}</p>
                            <p class="mb-1"><span class="font-semibold">{{ __('الوصف') }}:</span></p>
                            <p class="text-gray-700 whitespace-pre-line">{{ $participationRequest->jobOffer->description }}</p>
                        </div>
                    </div>
                    
                    @if($participationRequest->status == 'معلق')
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">{{ __('تحديث حالة الطلب') }}</h3>
                            
                            @can('update', $participationRequest)
                                <div class="flex space-x-4">
                                    <form action="{{ route('participation-requests.update-status', $participationRequest) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="مقبول">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('قبول الطلب') }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('participation-requests.update-status', $participationRequest) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="مرفوض">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            {{ __('رفض الطلب') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-gray-500">{{ __('فقط صاحب الفرصة التطوعية يمكنه قبول أو رفض هذا الطلب') }}</p>
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 