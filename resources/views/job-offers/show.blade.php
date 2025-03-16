<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $jobOffer->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('job-offers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة للقائمة') }}
                </a>
                @can('update', $jobOffer)
                <a href="{{ route('job-offers.edit', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('تعديل') }}
                </a>
                @endcan
                @can('delete', $jobOffer)
                <form action="{{ route('job-offers.destroy', $jobOffer) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفرصة؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('حذف') }}
                    </button>
                </form>
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
                    <div class="flex justify-between items-start">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $jobOffer->title }}</h1>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($jobOffer->status == 'متاحة') bg-green-100 text-green-800
                            @elseif($jobOffer->status == 'مغلقة') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $jobOffer->status }}
                        </span>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">تفاصيل الفرصة</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $jobOffer->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">معلومات المنظمة</h3>
                            <p class="mb-2">
                                <span class="font-semibold">المنظمة:</span> 
                                {{ $jobOffer->organization->name }}
                            </p>
                            @if($jobOffer->organization->description)
                            <p class="text-sm text-gray-600">{{ Str::limit($jobOffer->organization->description, 150) }}</p>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">المعلومات الزمنية</h3>
                            <p class="mb-1">
                                <span class="font-semibold">آخر موعد للتقديم:</span> 
                                {{ $jobOffer->deadline ? $jobOffer->deadline->format('Y-m-d') : 'غير محدد' }}
                            </p>
                            <p class="mb-1">
                                <span class="font-semibold">الوقت المتبقي:</span> 
                                @if(!$jobOffer->deadline)
                                    <span class="text-gray-600">غير محدد</span>
                                @elseif($jobOffer->deadline->isPast())
                                    <span class="text-red-600">انتهى وقت التقديم</span>
                                @else
                                    {{ $jobOffer->deadline->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($jobOffer->status == 'متاحة' && !$hasRequested && ($jobOffer->deadline && $jobOffer->deadline->isFuture()))
                        @can('request', $jobOffer)
                            <div class="mt-8 border-t pt-6">
                                <form action="{{ route('job-offers.request', $jobOffer) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                        {{ __('تقديم طلب للمشاركة') }}
                                    </button>
                                </form>
                            </div>
                        @endcan
                    @elseif($hasRequested)
                        <div class="mt-8 border-t pt-6">
                            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg">
                                <p class="font-medium">{{ __('لقد قمت بالفعل بتقديم طلب مشاركة في هذه الفرصة') }}</p>
                            </div>
                        </div>
                    @elseif($jobOffer->deadline && $jobOffer->deadline->isPast())
                        <div class="mt-8 border-t pt-6">
                            <div class="bg-red-50 text-red-700 p-4 rounded-lg">
                                <p class="font-medium">{{ __('انتهى وقت التقديم لهذه الفرصة') }}</p>
                            </div>
                        </div>
                    @elseif($jobOffer->status != 'متاحة')
                        <div class="mt-8 border-t pt-6">
                            <div class="bg-yellow-50 text-yellow-700 p-4 rounded-lg">
                                <p class="font-medium">{{ __('هذه الفرصة غير متاحة للتقديم حالياً') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 