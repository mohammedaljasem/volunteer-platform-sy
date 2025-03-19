<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $jobOffer->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('job-offers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 dark:hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 dark:ring-gray-700 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة للقائمة') }}
                </a>
                @can('update', $jobOffer)
                <a href="{{ route('job-offers.edit', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 dark:bg-yellow-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 dark:hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 dark:ring-yellow-700 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('تعديل') }}
                </a>
                @endcan
                @can('delete', $jobOffer)
                <form action="{{ route('job-offers.destroy', $jobOffer) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفرصة؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 dark:hover:bg-red-600 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 dark:ring-red-700 disabled:opacity-25 transition ease-in-out duration-150">
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
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
        
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">{{ $jobOffer->title }}</h1>
                        <span class="px-3 py-1 text-sm rounded-full 
                            @if($jobOffer->status == 'متاحة') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($jobOffer->status == 'مغلقة') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                            {{ $jobOffer->status }}
                        </span>
                    </div>
                    
                    @if($jobOffer->image)
                    <div class="mb-6">
                        <img src="{{ $jobOffer->image_url }}" alt="{{ $jobOffer->title }}" class="w-full h-64 object-cover rounded-lg shadow-sm">
                    </div>
                    @endif
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">تفاصيل الفرصة</h3>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $jobOffer->description }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">معلومات المنظمة</h3>
                            <p class="mb-2 text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">المنظمة:</span> 
                                {{ $jobOffer->organization->name }}
                            </p>
                            @if($jobOffer->organization->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($jobOffer->organization->description, 150) }}</p>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">المعلومات الزمنية</h3>
                            <p class="mb-1 text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">آخر موعد للتقديم:</span> 
                                {{ $jobOffer->deadline ? $jobOffer->deadline->format('Y-m-d') : 'غير محدد' }}
                            </p>
                            <p class="mb-1 text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">الوقت المتبقي:</span> 
                                @if(!$jobOffer->deadline)
                                    <span class="text-gray-600 dark:text-gray-400">غير محدد</span>
                                @elseif($jobOffer->deadline->isPast())
                                    <span class="text-red-600 dark:text-red-400">انتهى وقت التقديم</span>
                                @else
                                    {{ $jobOffer->deadline->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($jobOffer->status == 'متاحة' && !$hasRequested && ($jobOffer->deadline && $jobOffer->deadline->isFuture()))
                        @can('request', $jobOffer)
                            <div class="mt-8 border-t dark:border-gray-700 pt-6">
                                <form action="{{ route('job-offers.request', $jobOffer) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-300">
                                        {{ __('تقديم طلب للمشاركة') }}
                                    </button>
                                </form>
                            </div>
                        @endcan
                    @elseif($hasRequested)
                        <div class="mt-8 border-t dark:border-gray-700 pt-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 p-4 rounded-lg">
                                <p class="font-medium">{{ __('لقد قمت بالفعل بتقديم طلب مشاركة في هذه الفرصة') }}</p>
                            </div>
                        </div>
                    @elseif($jobOffer->deadline && $jobOffer->deadline->isPast())
                        <div class="mt-8 border-t dark:border-gray-700 pt-6">
                            <div class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 p-4 rounded-lg">
                                <p class="font-medium">{{ __('انتهى وقت التقديم لهذه الفرصة') }}</p>
                            </div>
                        </div>
                    @elseif($jobOffer->status != 'متاحة')
                        <div class="mt-8 border-t dark:border-gray-700 pt-6">
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 text-yellow-700 dark:text-yellow-300 p-4 rounded-lg">
                                <p class="font-medium">{{ __('هذه الفرصة غير متاحة للتقديم حالياً') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 