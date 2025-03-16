<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('تعديل الحملة التطوعية') }}: {{ $ad->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('ads.update', $ad) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- عنوان الحملة -->
                            <div>
                                <x-input-label for="title" :value="__('عنوان الحملة')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $ad->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            
                            <!-- الفريق/المنظمة -->
                            <div>
                                <x-input-label for="company_id" :value="__('الفريق/المنظمة')" />
                                <select id="company_id" name="company_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="">اختر الفريق/المنظمة</option>
                                    @foreach($companies as $id => $name)
                                        <option value="{{ $id }}" {{ (old('company_id', $ad->company_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                            </div>
                            
                            <!-- التصنيف -->
                            <div>
                                <x-input-label for="category" :value="__('تصنيف الحملة')" />
                                <select id="category" name="category" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">اختر تصنيف الحملة</option>
                                    <option value="صحة" {{ old('category', $ad->category) == 'صحة' ? 'selected' : '' }}>صحة</option>
                                    <option value="تعليم" {{ old('category', $ad->category) == 'تعليم' ? 'selected' : '' }}>تعليم</option>
                                    <option value="بيئة" {{ old('category', $ad->category) == 'بيئة' ? 'selected' : '' }}>بيئة</option>
                                    <option value="إغاثة" {{ old('category', $ad->category) == 'إغاثة' ? 'selected' : '' }}>إغاثة</option>
                                    <option value="أيتام" {{ old('category', $ad->category) == 'أيتام' ? 'selected' : '' }}>أيتام</option>
                                    <option value="مشاريع خيرية" {{ old('category', $ad->category) == 'مشاريع خيرية' ? 'selected' : '' }}>مشاريع خيرية</option>
                                    <option value="أخرى" {{ old('category', $ad->category) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>
                            
                            <!-- المبلغ المستهدف -->
                            <div>
                                <x-input-label for="goal_amount" :value="__('المبلغ المستهدف (بالليرة السورية)')" />
                                <x-text-input id="goal_amount" class="block mt-1 w-full" type="number" name="goal_amount" :value="old('goal_amount', $ad->goal_amount)" min="0" required />
                                <x-input-error :messages="$errors->get('goal_amount')" class="mt-2" />
                            </div>
                            
                            <!-- المبلغ الحالي -->
                            <div>
                                <x-input-label for="current_amount" :value="__('المبلغ الحالي (بالليرة السورية)')" />
                                <x-text-input id="current_amount" class="block mt-1 w-full" type="number" name="current_amount" :value="old('current_amount', $ad->current_amount)" min="0" required />
                                <x-input-error :messages="$errors->get('current_amount')" class="mt-2" />
                            </div>
                            
                            <!-- تاريخ البدء -->
                            <div>
                                <x-input-label for="start_date" :value="__('تاريخ البدء')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date', $ad->start_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            
                            <!-- تاريخ الانتهاء -->
                            <div>
                                <x-input-label for="end_date" :value="__('تاريخ الانتهاء')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $ad->end_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                            
                            <!-- المدينة - الموقع -->
                            <div>
                                <x-input-label for="city_id" :value="__('المدينة')" />
                                <select id="city_id" name="city_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">اختر المدينة</option>
                                    @foreach(\App\Models\City::all() as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $ad->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                            </div>
                            
                            <!-- إحداثيات الموقع -->
                            <div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <x-input-label for="latitude" :value="__('خط العرض')" />
                                        <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude', $ad->latitude)" placeholder="33.5138" />
                                    </div>
                                    <div>
                                        <x-input-label for="longitude" :value="__('خط الطول')" />
                                        <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude', $ad->longitude)" placeholder="36.2765" />
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">أدخل إحداثيات الموقع (اختياري). يمكن الحصول عليها من خرائط جوجل.</p>
                                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                            </div>
                            
                            <!-- حالة الحملة -->
                            <div>
                                <x-input-label for="status" :value="__('حالة الحملة')" />
                                <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="نشطة" {{ (old('status', $ad->status) == 'نشطة') ? 'selected' : '' }}>نشطة</option>
                                    <option value="مكتملة" {{ (old('status', $ad->status) == 'مكتملة') ? 'selected' : '' }}>مكتملة</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            
                            <!-- صورة الحملة -->
                            <div>
                                <x-input-label for="image" :value="__('صورة الحملة')" />
                                <input id="image" type="file" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="image" accept="image/*" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                
                                @if ($ad->image)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">الصورة الحالية:</p>
                                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="mt-1 h-20 w-auto object-cover rounded">
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- وصف الحملة -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('وصف الحملة')" />
                            <textarea id="description" name="description" rows="6" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>{{ old('description', $ad->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('ads.show', $ad) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">إلغاء</a>
                            <x-primary-button class="ml-3">
                                {{ __('حفظ التغييرات') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 