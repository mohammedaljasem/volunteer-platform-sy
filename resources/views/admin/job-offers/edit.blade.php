<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('تعديل فرصة التطوع') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 rtl" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- إشعارات النجاح والخطأ -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">تعديل فرصة التطوع: {{ $jobOffer->title }}</h3>
                        <a href="{{ route('admin.job-offers') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">العودة للقائمة</a>
                    </div>

                    <form action="{{ route('admin.job-offers.update', $jobOffer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <!-- العنوان -->
                                <div class="mb-4">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $jobOffer->title) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- المنظمة -->
                                <div class="mb-4">
                                    <label for="organization_id" class="block text-sm font-medium text-gray-700 mb-1">المنظمة</label>
                                    <select name="organization_id" id="organization_id" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="">-- اختر المنظمة --</option>
                                        @foreach($organizations as $organization)
                                            <option value="{{ $organization->id }}" {{ old('organization_id', $jobOffer->organization_id) == $organization->id ? 'selected' : '' }}>
                                                {{ $organization->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('organization_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- الحالة -->
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                                    <select name="status" id="status" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="متاحة" {{ old('status', $jobOffer->status) == 'متاحة' ? 'selected' : '' }}>متاحة</option>
                                        <option value="مغلقة" {{ old('status', $jobOffer->status) == 'مغلقة' ? 'selected' : '' }}>مغلقة</option>
                                        <option value="معلقة" {{ old('status', $jobOffer->status) == 'معلقة' ? 'selected' : '' }}>معلقة</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- الموقع -->
                                <div class="mb-4">
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">الموقع</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $jobOffer->location) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('location')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- المهارات المطلوبة -->
                                <div class="mb-4">
                                    <label for="skills_required" class="block text-sm font-medium text-gray-700 mb-1">المهارات المطلوبة</label>
                                    <textarea name="skills_required" id="skills_required" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('skills_required', $jobOffer->skills_required) }}</textarea>
                                    @error('skills_required')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <!-- التاريخ -->
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">تاريخ البدء</label>
                                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $jobOffer->start_date ? $jobOffer->start_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('start_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- الموعد النهائي -->
                                <div class="mb-4">
                                    <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">الموعد النهائي</label>
                                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $jobOffer->deadline ? $jobOffer->deadline->format('Y-m-d') : '') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('deadline')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- الصورة -->
                                <div class="mb-4">
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">الصورة</label>
                                    @if($jobOffer->image)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($jobOffer->image) }}" alt="{{ $jobOffer->title }}" class="h-32 w-auto object-cover rounded">
                                        </div>
                                    @endif
                                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100">
                                    @error('image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- الوصف -->
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
                                    <textarea name="description" id="description" rows="5" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $jobOffer->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="mr-3 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">حفظ التغييرات</button>
                            <a href="{{ route('admin.job-offers') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 