<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('تعديل فرصة التطوع') }}: {{ $jobOffer->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('job-offers.show', $jobOffer) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة للتفاصيل') }}
                </a>
                <a href="{{ route('job-offers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('العودة للقائمة') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">{{ __('خطأ!') }}</strong>
                            <span class="block sm:inline">{{ __('الرجاء تصحيح الأخطاء التالية:') }}</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('job-offers.update', $jobOffer) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">{{ __('عنوان الفرصة') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $jobOffer->title) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('وصف الفرصة') }} <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="6" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('description', $jobOffer->description) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ __('اكتب وصفاً مفصلاً للفرصة، بما في ذلك المهام المطلوبة والمهارات اللازمة.') }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="organization_id" class="block text-sm font-medium text-gray-700">{{ __('المنظمة') }} <span class="text-red-500">*</span></label>
                            <select name="organization_id" id="organization_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">{{ __('-- اختر المنظمة --') }}</option>
                                @foreach($organizations as $id => $name)
                                    <option value="{{ $id }}" {{ old('organization_id', $jobOffer->organization_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">{{ __('الحالة') }} <span class="text-red-500">*</span></label>
                            <select name="status" id="status" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="متاحة" {{ old('status', $jobOffer->status) == 'متاحة' ? 'selected' : '' }}>{{ __('متاحة') }}</option>
                                <option value="مغلقة" {{ old('status', $jobOffer->status) == 'مغلقة' ? 'selected' : '' }}>{{ __('مغلقة') }}</option>
                                <option value="قادمة" {{ old('status', $jobOffer->status) == 'قادمة' ? 'selected' : '' }}>{{ __('قادمة') }}</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="location_id" class="block text-sm font-medium text-gray-700">{{ __('الموقع (اختياري)') }}</label>
                            <input type="number" name="location_id" id="location_id" value="{{ old('location_id', $jobOffer->location_id) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        
                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-700">{{ __('آخر موعد للتقديم') }} <span class="text-red-500">*</span></label>
                            <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $jobOffer->deadline->format('Y-m-d')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('تحديث الفرصة') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 