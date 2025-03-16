<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('إنشاء حملة تطوعية جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان الحملة -->
                            <div>
                                <x-input-label for="title" :value="__('عنوان الحملة')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            
                            <!-- الفريق/المنظمة -->
                            <div>
                                <x-input-label for="company_id" :value="__('الفريق/المنظمة')" />
                                <select id="company_id" name="company_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">اختر الفريق/المنظمة</option>
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}" {{ old('company_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>
                            
                            <!-- المبلغ المستهدف -->
                            <div>
                                <x-input-label for="goal_amount" :value="__('المبلغ المستهدف (بالليرة السورية)')" />
                                <x-text-input id="goal_amount" class="block mt-1 w-full" type="number" name="goal_amount" :value="old('goal_amount')" min="0" required />
                                <x-input-error :messages="$errors->get('goal_amount')" class="mt-2" />
                            </div>
                            
                            <!-- صورة الحملة -->
                            <div>
                                <x-input-label for="image" :value="__('صورة الحملة')" />
                                <input id="image" type="file" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="image" accept="image/*" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            
                            <!-- تاريخ البدء -->
                            <div>
                                <x-input-label for="start_date" :value="__('تاريخ البدء')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            
                            <!-- تاريخ الانتهاء -->
                            <div>
                                <x-input-label for="end_date" :value="__('تاريخ الانتهاء')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- وصف الحملة -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف الحملة')" />
                            <textarea id="description" name="description" rows="6" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('ads.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">إلغاء</a>
                            <x-primary-button class="ml-3">
                                {{ __('إنشاء الحملة') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 