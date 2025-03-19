<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('إضافة فرصة تطوع جديدة') }}
            </h2>
            <a href="{{ route('job-offers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 dark:hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 dark:ring-gray-700 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('العودة للقائمة') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">{{ __('خطأ!') }}</strong>
                            <span class="block sm:inline">{{ __('الرجاء تصحيح الأخطاء التالية:') }}</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('job-offers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('عنوان الفرصة') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('وصف الفرصة') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                            <textarea name="description" id="description" rows="6" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" required>{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('اكتب وصفاً مفصلاً للفرصة، بما في ذلك المهام المطلوبة والمهارات اللازمة.') }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('صورة الفرصة') }}</label>
                            <input type="file" name="image" id="image" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('يفضل صورة بأبعاد 16:9 للحصول على أفضل عرض. الحد الأقصى للحجم 2 ميجابايت.') }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="organization_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('المنظمة') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                            <select name="organization_id" id="organization_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" required>
                                <option value="">{{ __('-- اختر المنظمة --') }}</option>
                                @foreach($organizations as $id => $name)
                                    <option value="{{ $id }}" {{ old('organization_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('الموقع (اختياري)') }}</label>
                            <input type="number" name="location_id" id="location_id" value="{{ old('location_id') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md">
                        </div>
                        
                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('آخر موعد للتقديم') }} <span class="text-red-500 dark:text-red-400">*</span></label>
                            <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" min="{{ date('Y-m-d') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" required>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 dark:hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 dark:ring-blue-700 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('إضافة الفرصة') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 