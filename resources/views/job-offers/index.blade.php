<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('فرص التطوع المتاحة') }}
            </h2>
            @can('create', App\Models\JobOffer::class)
            <a href="{{ route('job-offers.create') }}" class="btn-primary flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                {{ __('إضافة فرصة جديدة') }}
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12 rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- البانر العلوي -->
            <div class="bg-primary dark:bg-gray-800 rounded-lg shadow-lg mb-8 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="p-8 flex flex-col justify-center flex-1">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">انضم إلى فريق التطوع</h2>
                        <p class="text-white opacity-90 mb-6">نحن بحاجة إلى مهاراتك وتفانيك! استكشف فرص التطوع المتاحة وكن جزءاً من التغيير الإيجابي في المجتمع.</p>
                        <div>
                            <a href="#opportunities" class="bg-white text-primary dark:bg-gray-700 dark:text-gray-200 font-bold py-2 px-6 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-300 inline-block">استكشف الفرص</a>
                        </div>
                    </div>
                    <div class="bg-primary-light dark:bg-gray-700 md:w-2/5 flex items-center justify-center p-8">
                        <img src="https://images.unsplash.com/photo-1593113630400-ea4288922497?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="متطوعون" class="h-64 object-cover rounded-lg shadow-md">
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- رسائل النجاح والخطأ -->
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

                    <!-- قسم البحث والتصفية -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                        <form action="{{ route('job-offers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">بحث</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="ابحث عن فرص التطوع..." class="form-input pr-10 w-full dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                                    @if(request('search'))
                                    <button type="button" onclick="clearSearch()" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المجال</label>
                                <select name="category" id="category" class="form-input w-full dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600">
                                    <option value="">جميع المجالات</option>
                                    <option value="تعليم" {{ request('category') == 'تعليم' ? 'selected' : '' }}>تعليم</option>
                                    <option value="صحة" {{ request('category') == 'صحة' ? 'selected' : '' }}>صحة</option>
                                    <option value="إغاثة" {{ request('category') == 'إغاثة' ? 'selected' : '' }}>إغاثة</option>
                                </select>
                            </div>
                            <div class="flex items-end space-x-2 space-x-reverse">
                                <button type="submit" class="btn-primary flex-1">تطبيق الفلتر</button>
                                @if(request('search') || request('category'))
                                <a href="{{ route('job-offers.index') }}" class="btn-secondary flex-1 text-center">إعادة تعيين</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <!-- قائمة الفرص -->
                    <div id="opportunities">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                @if(request('search') || request('category'))
                                    فرص التطوع 
                                    @if(request('search'))
                                        <span class="text-secondary dark:text-indigo-400">التي تطابق "{{ request('search') }}"</span>
                                    @endif
                                    @if(request('category'))
                                        <span class="text-gray-600 dark:text-gray-400 text-base"> في مجال {{ request('category') }}</span>
                                    @endif
                                @else
                                    فرص التطوع المتاحة
                                @endif
                            </h3>
                            @if(request('search') || request('category'))
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $jobOffers->total() }} نتيجة</span>
                            @endif
                        </div>
                    
                    @if($jobOffers->isEmpty())
                            <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-gray-600 dark:text-gray-300 text-lg">{{ __('لا توجد فرص تطوع متاحة حالياً') }}</p>
                                <p class="text-gray-500 dark:text-gray-400 mt-2">يرجى العودة لاحقًا أو البحث بمعايير مختلفة.</p>
                        </div>
                    @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($jobOffers as $jobOffer)
                                    <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 bg-white dark:bg-gray-800 dark:border-gray-700 relative">
                                        <div class="absolute top-4 left-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                @if($jobOffer->status == 'متاحة') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                @elseif($jobOffer->status == 'مغلقة') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                                                {{ $jobOffer->status }}
                                            </span>
                                        </div>
                                        
                                        @if($jobOffer->image)
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ $jobOffer->image_url }}" alt="{{ $jobOffer->title }}" class="w-full h-full object-cover">
                                        </div>
                                        @else
                                        <div class="h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                        
                                        <div class="p-6">
                                            <div class="flex items-start">
                                                <div class="bg-secondary bg-opacity-10 dark:bg-indigo-900/20 p-3 rounded-full ml-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $jobOffer->title }}</h3>
                                                    <div class="flex flex-wrap gap-2 mb-3">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                            {{ $jobOffer->category }}
                                            </span>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                            {{ $jobOffer->location }}
                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm mt-3">{{ Str::limit($jobOffer->description, 150) }}</p>
                                            
                                            <div class="grid grid-cols-2 gap-2 mb-4 text-sm text-gray-600 dark:text-gray-400">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $jobOffer->start_date ? $jobOffer->start_date->format('Y/m/d') : 'غير محدد' }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{ $jobOffer->hours_per_week }} ساعة/أسبوع</span>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between items-center mt-4">
                                                <a href="{{ route('job-offers.show', $jobOffer->id) }}" class="text-secondary dark:text-indigo-400 font-medium hover:text-secondary-dark dark:hover:text-indigo-300 transition">
                                                    عرض التفاصيل
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                
                                                @if($jobOffer->status == 'متاحة')
                                                    <form action="{{ route('job-offers.request', $jobOffer->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="btn-primary">
                                                            تقديم طلب
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 dark:text-gray-200">
                            {{ $jobOffers->links() }}
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function clearSearch() {
            const searchInput = document.getElementById('search');
            searchInput.value = '';
            // Preserve the category filter if it exists
            const categoryValue = document.getElementById('category').value;
            if (categoryValue) {
                window.location.href = "{{ route('job-offers.index') }}?category=" + categoryValue;
            } else {
                window.location.href = "{{ route('job-offers.index') }}";
            }
        }
    </script>
    @endpush
</x-app-layout> 