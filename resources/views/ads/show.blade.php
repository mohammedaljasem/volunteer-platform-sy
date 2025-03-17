<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('تفاصيل الحملة') }}
        </h2>
            <div class="flex space-x-2 space-x-reverse">
                @can('update', $ad)
                <a href="{{ route('ads.edit', $ad) }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    تعديل الحملة
                </a>
                @endcan
                <a href="{{ route('ads.index') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- عرض رسائل النجاح -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 mx-6 mt-6" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- صورة الحملة -->
                <div class="w-full h-64 md:h-80 bg-gray-200 relative">
                    @if($ad->image)
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    
                    <div class="absolute bottom-4 right-4 bg-white dark:bg-gray-800 px-3 py-1 rounded-lg shadow-md">
                        <span class="text-sm font-semibold {{ $ad->status == 'نشطة' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $ad->status }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="md:flex md:justify-between md:items-start">
                        <!-- معلومات الحملة الأساسية -->
                        <div class="md:w-2/3 md:ml-6">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $ad->title }}</h1>
                            <div class="flex items-center text-gray-600 dark:text-gray-400 mb-4 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>{{ $ad->company->name }}</span>
                                <span class="mx-2">•</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $ad->created_at->format('Y/m/d') }}</span>
                            </div>
                            
                            <!-- حالة التقدم -->
                            <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="flex justify-between mb-1 text-sm font-medium">
                                    <span>التقدم في جمع التبرعات</span>
                                    <span>{{ $ad->progress_percentage }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-value" style="width: {{ $ad->progress_percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs mt-2 text-gray-500 dark:text-gray-400">
                                    <span>{{ number_format($ad->current_amount) }} ل.س تم جمعها</span>
                                    <span>الهدف: {{ number_format($ad->goal_amount) }} ل.س</span>
                                </div>
                            </div>
                            
                            <!-- وصف الحملة -->
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">عن الحملة</h2>
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                                    {!! nl2br(e($ad->description)) !!}
                                </div>
                                    </div>
                            
                            <!-- تفاصيل إضافية -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">الموقع</h3>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        @if($ad->city)
                                            <span>{{ $ad->city->name }}</span>
                                        @else
                                            <span class="text-gray-500">غير محدد</span>
                                        @endif
                                    </div>
                                    @if($ad->latitude && $ad->longitude)
                                    <div class="mt-2 text-sm">
                                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                            <span>خط العرض: {{ $ad->latitude }}</span>
                                            <span>خط الطول: {{ $ad->longitude }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <a href="https://www.google.com/maps?q={{ $ad->latitude }},{{ $ad->longitude }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                عرض على الخريطة
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">التصنيف</h3>
                                    <div class="flex items-center text-gray-700 dark:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        @if(isset($ad->category) && !empty($ad->category))
                                            <span>{{ $ad->category }}</span>
                                        @else
                                            <span class="text-gray-500">غير مصنف</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- قسم التبرع -->
                        <div class="md:w-1/3 mt-6 md:mt-0">
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">تبرع الآن</h2>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">ساهم في دعم هذه الحملة وساعد في إحداث تغيير إيجابي</p>
                                
                                @if($ad->status == 'نشطة')
                                    <form action="{{ route('ads.donate.store', $ad) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">مبلغ التبرع (ل.س)</label>
                                            <input type="number" id="amount" name="amount" min="100" step="10" class="form-input" placeholder="أدخل مبلغ التبرع" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">طريقة الدفع</label>
                                            <select id="payment_method" name="payment_method" class="form-input" required>
                                                <option value="نقدي">نقدي</option>
                                                <option value="تحويل بنكي">تحويل بنكي</option>
                                                <option value="محفظة">الدفع من محفظتي</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="is_recurring" name="is_recurring" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="is_recurring" class="mr-2 block text-sm text-gray-700 dark:text-gray-300">
                                                    تبرع شهري متكرر
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">سيتم خصم هذا المبلغ شهرياً بشكل تلقائي</p>
                                        </div>
                                        <button type="submit" class="w-full btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            إرسال التبرع
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-200 p-4 rounded-md">
                                        <p class="text-center">هذه الحملة غير نشطة حالياً ولا تقبل التبرعات</p>
                                    </div>
                                @endif
                                
                                <div class="mt-6">
                                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">شارك الحملة</h3>
                                    <div class="flex space-x-3 space-x-reverse">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('ads.show', $ad)) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                                            </svg>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($ad->title) }}&url={{ urlencode(route('ads.show', $ad)) }}" target="_blank" class="bg-blue-400 hover:bg-blue-500 text-white p-2 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                            </svg>
                                        </a>
                                        <a href="https://wa.me/?text={{ urlencode($ad->title . ' - ' . route('ads.show', $ad)) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                            </svg>
                                        </a>
                                        <a href="mailto:?subject={{ urlencode($ad->title) }}&body={{ urlencode('شاهد هذه الحملة التطوعية: ' . route('ads.show', $ad)) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M0 3v18h24v-18h-24zm21.518 2l-9.518 7.713-9.518-7.713h19.036zm-19.518 14v-11.817l10 8.104 10-8.104v11.817h-20z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- قائمة المتبرعين -->
                            <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">آخر المتبرعين</h3>
                                @if(count($ad->donations) > 0)
                                    <ul class="space-y-4">
                                        @foreach($ad->donations->take(5) as $donation)
                                            <li class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 ml-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                <div>
                                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $donation->user->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $donation->created_at->format('Y/m/d') }}</p>
                                                    </div>
                                </div>
                                                <span class="text-green-600 dark:text-green-400 font-semibold">{{ number_format($donation->amount) }} ل.س</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">لا يوجد متبرعين حتى الآن</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- قسم التعليقات -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">التعليقات والآراء</h2>
                        
                        <!-- نموذج إضافة تعليق -->
                        @auth
                            <form action="{{ route('ads.comment', $ad) }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                                <div class="mb-3">
                                    <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">أضف تعليقك</label>
                                    <textarea id="text" name="text" rows="3" class="form-input" placeholder="اكتب تعليقك هنا..." required></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        إضافة تعليق
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-md mb-6">
                                <p class="text-blue-800 dark:text-blue-200 text-center">يجب <a href="{{ route('login') }}" class="underline">تسجيل الدخول</a> لإضافة تعليق</p>
                        </div>
                        @endauth
                        
                        <!-- قائمة التعليقات -->
                        @if(count($ad->comments) > 0)
                            <div class="space-y-6">
                                @foreach($ad->comments as $comment)
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 ml-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $comment->user->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('Y/m/d H:i') }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- أزرار التعديل والحذف للتعليق (تظهر فقط لصاحب التعليق) -->
                                            @auth
                                                @if(auth()->id() == $comment->user_id)
                                                    <div class="flex space-x-2 space-x-reverse">
                                                        <button type="button" 
                                                                onclick="openEditModal({{ $comment->id }}, '{{ addslashes($comment->text) }}')" 
                                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                                                title="تعديل التعليق">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828l-3.182 3.182M14.828 3.172a2 2 0 010 2.828l-10 10-4.243 1.415 1.415-4.243 10-10z" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" 
                                                                onclick="confirmDelete({{ $comment->id }})" 
                                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                                title="حذف التعليق">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                        <div class="text-gray-700 dark:text-gray-300 mt-2">
                                            {{ $comment->text }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">لا توجد تعليقات على هذه الحملة</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">كن أول من يعلق!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نافذة تعديل التعليق -->
    <div id="editCommentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md mx-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">تعديل التعليق</h3>
            <form id="editCommentForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التعليق</label>
                    <textarea id="edit_text" name="text" rows="4" class="form-input w-full" required></textarea>
                </div>
                <div class="flex justify-end space-x-2 space-x-reverse">
                    <button type="button" onclick="closeEditModal()" class="btn-secondary">
                        إلغاء
                    </button>
                    <button type="submit" class="btn-primary">
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- نموذج حذف التعليق (مخفي) -->
    <form id="deleteCommentForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // دالة لفتح نافذة تعديل التعليق
        function openEditModal(commentId, commentText) {
            document.getElementById('edit_text').value = commentText;
            document.getElementById('editCommentForm').action = '/comments/' + commentId;
            document.getElementById('editCommentModal').classList.remove('hidden');
            document.getElementById('editCommentModal').classList.add('flex');
        }
        
        // دالة لإغلاق نافذة تعديل التعليق
        function closeEditModal() {
            document.getElementById('editCommentModal').classList.remove('flex');
            document.getElementById('editCommentModal').classList.add('hidden');
        }
        
        // دالة لتأكيد حذف التعليق
        function confirmDelete(commentId) {
            if (confirm('هل أنت متأكد من رغبتك في حذف هذا التعليق؟')) {
                var form = document.getElementById('deleteCommentForm');
                form.action = '/comments/' + commentId;
                form.submit();
            }
        }
    </script>
</x-app-layout> 