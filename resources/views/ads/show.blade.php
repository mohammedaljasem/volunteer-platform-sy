<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $ad->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    <div class="flex flex-col md:flex-row">
                        <div class="w-full md:w-1/3 p-4">
                            @if ($ad->image)
                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-auto object-cover rounded-lg shadow">
                            @else
                                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 dark:text-gray-400">لا توجد صورة</span>
                                </div>
                            @endif
                            
                            <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                                <h3 class="text-lg font-semibold mb-2">معلومات الحملة:</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">المنظمة/الفريق:</span>
                                        <span class="font-semibold">{{ $ad->company->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">الحالة:</span>
                                        @if ($ad->status === 'نشطة')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                {{ $ad->status }}
                                            </span>
                                        @elseif ($ad->status === 'قادمة')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                {{ $ad->status }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                {{ $ad->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">تاريخ البدء:</span>
                                        <span class="font-semibold">{{ $ad->start_date->format('Y/m/d') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">تاريخ الانتهاء:</span>
                                        <span class="font-semibold">{{ $ad->end_date->format('Y/m/d') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-2/3 p-4">
                            <h2 class="text-2xl font-bold mb-4">{{ $ad->title }}</h2>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">الوصف:</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                                    <p class="whitespace-pre-line">{{ $ad->description }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">التقدم:</h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">المبلغ المستهدف:</span>
                                        <span class="font-bold text-lg">{{ number_format($ad->goal_amount, 0) }} ل.س</span>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">المبلغ الحالي:</span>
                                        <span class="font-bold text-lg text-green-600 dark:text-green-400">{{ number_format($ad->current_amount, 0) }} ل.س</span>
                                    </div>
                                    
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-4 mb-2" dir="ltr">
                                        <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $ad->progress_percentage }}%"></div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <span class="text-sm font-semibold">{{ $ad->progress_percentage }}% مكتمل</span>
                                    </div>
                                    
                                    <!-- زر التبرع -->
                                    @can('donate', $ad)
                                    <div class="mt-4">
                                        <a href="{{ route('ads.donate', $ad) }}" 
                                           class="block w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded text-center">
                                            تبرع الآن
                                        </a>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                            
                            <div class="mt-8 flex justify-between">
                                <a href="{{ route('ads.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    العودة للقائمة
                                </a>
                                
                                <div>
                                    @can('update', $ad)
                                    <a href="{{ route('ads.edit', $ad) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2">
                                        تعديل
                                    </a>
                                    @endcan
                                    
                                    @can('delete', $ad)
                                    <form class="inline" action="{{ route('ads.destroy', $ad) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحملة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            حذف
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- قسم التعليقات -->
                    <div class="mt-10 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">التعليقات ({{ $comments->count() }})</h3>
                        
                        <!-- نموذج إضافة تعليق -->
                        @can('comment', $ad)
                        <div class="mb-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                            <form method="POST" action="{{ route('ads.comment', $ad) }}">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="text" :value="__('أضف تعليقاً')" />
                                    <textarea id="text" name="text" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>{{ old('text') }}</textarea>
                                    <x-input-error :messages="$errors->get('text')" class="mt-2" />
                                </div>
                                
                                <div class="flex justify-end">
                                    <x-primary-button>
                                        {{ __('إرسال التعليق') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        @endcan
                        
                        <!-- قائمة التعليقات -->
                        <div class="space-y-4">
                            @forelse ($comments as $comment)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-start">
                                            <div class="mr-3">
                                                <p class="font-bold">{{ $comment->user->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->date->format('Y/m/d H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p class="whitespace-pre-line">{{ $comment->text }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 shadow text-center">
                                    <p class="text-gray-600 dark:text-gray-400">لا توجد تعليقات حتى الآن. كن أول من يعلق!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 