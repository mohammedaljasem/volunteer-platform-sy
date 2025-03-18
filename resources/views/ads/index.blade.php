<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('الحملات التطوعية') }}
        </h2>
    </x-slot>

    <div class="py-12 rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            @if(request('search') || request('category') || request('status'))
                                الحملات التطوعية 
                                @if(request('search'))
                                    <span class="text-primary">التي تطابق "{{ request('search') }}"</span>
                                @endif
                                @if(request('category'))
                                    <span class="text-gray-600 text-base"> في {{ __('categories.' . request('category')) }}</span>
                                @endif
                                @if(request('status'))
                                    <span class="text-gray-600 text-base"> ({{ __('statuses.' . request('status')) }})</span>
                                @endif
                            @else
                                قائمة الحملات التطوعية
                            @endif
                        </h3>
                        @if(request('search') || request('category') || request('status'))
                        <span class="text-sm text-gray-500">{{ $ads->total() }} نتيجة</span>
                        @endif
                    </div>

                    @can('create-campaign')
                    <a href="{{ route('ads.create') }}" class="btn-primary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        إنشاء حملة جديدة
                    </a>
                    @endcan

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- فلتر البحث والتصنيف -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 mb-6 rounded-lg">
                        <form action="{{ route('ads.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">بحث</label>
                                <div class="relative">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="أدخل كلمة للبحث..." class="form-input pr-10 w-full">
                                    @if(request('search'))
                                    <button type="button" onclick="clearSearch()" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التصنيف</label>
                                <select name="category" id="category" class="form-input w-full">
                                    <option value="">جميع التصنيفات</option>
                                    <option value="education" {{ request('category') == 'education' ? 'selected' : '' }}>تعليم</option>
                                    <option value="health" {{ request('category') == 'health' ? 'selected' : '' }}>صحة</option>
                                    <option value="humanitarian" {{ request('category') == 'humanitarian' ? 'selected' : '' }}>إنساني</option>
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                                <select name="status" id="status" class="form-input w-full">
                                    <option value="">جميع الحالات</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشطة</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                                </select>
                            </div>
                            <div class="flex items-end space-x-2 space-x-reverse">
                                <button type="submit" class="btn-primary flex-1">تطبيق الفلتر</button>
                                @if(request('search') || request('category') || request('status'))
                                <a href="{{ route('ads.index') }}" class="btn-secondary flex-1 text-center">إعادة تعيين</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- عرض الحملات بشكل بطاقات -->
                    @if($ads->isEmpty())
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="mt-2 text-lg text-gray-500">لا توجد حملات مطابقة للبحث</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($ads as $ad)
                                <div class="card transition-transform duration-300 hover:scale-105">
                                    @if($ad->image)
                                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-48 object-cover rounded-t-lg">
                                            @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                                </div>
                                            @endif
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-xl font-bold text-gray-800">{{ $ad->title }}</h3>
                                            <span class="px-2 py-1 text-xs rounded 
                                                @if($ad->status == 'active') bg-green-100 text-green-800
                                                @elseif($ad->status == 'completed') bg-blue-100 text-blue-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ $ad->status }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($ad->description, 100) }}</p>
                                        
                                        <div class="flex items-center text-gray-500 text-xs mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $ad->organization->name ?? 'منظمة غير معروفة' }}
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="flex justify-between text-sm font-medium">
                                                <span>التقدم</span>
                                                <span>{{ $ad->target_amount > 0 ? number_format(($ad->current_amount / $ad->target_amount) * 100, 0) : 0 }}%</span>
                                            </div>
                                            <div class="progress-bar mt-1">
                                                <div class="progress-value" style="width: {{ $ad->target_amount > 0 ? min(($ad->current_amount / $ad->target_amount) * 100, 100) : 0 }}%"></div>
                                            </div>
                                            <div class="flex justify-between text-xs mt-1 text-gray-500">
                                                <span>{{ number_format($ad->current_amount) }} ل.س</span>
                                                <span>الهدف: {{ number_format($ad->target_amount) }} ل.س</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex space-x-2 space-x-reverse mt-4">
                                            <a href="{{ route('ads.show', $ad->id) }}" class="btn-primary flex-1 text-center">عرض التفاصيل</a>
                                            @can('donate')
                                            <a href="{{ route('ads.donate', $ad->id) }}" class="btn-secondary flex-1 text-center">تبرع الآن</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    </div>
                        <div class="mt-6">
                        {{ $ads->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        function clearSearch() {
            const searchInput = document.getElementById('search');
            searchInput.value = '';
            
            // Preserve other filters if they exist
            const categoryValue = document.getElementById('category').value;
            const statusValue = document.getElementById('status').value;
            
            let url = "{{ route('ads.index') }}";
            let params = [];
            
            if (categoryValue) {
                params.push(`category=${categoryValue}`);
            }
            
            if (statusValue) {
                params.push(`status=${statusValue}`);
            }
            
            if (params.length > 0) {
                url += "?" + params.join("&");
            }
            
            window.location.href = url;
        }
    </script>
    @endpush
</x-app-layout> 