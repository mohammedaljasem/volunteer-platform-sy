<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('تفاصيل فرصة التطوع') }}
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
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">{{ $jobOffer->title }}</h3>
                        <div class="flex space-x-2 space-x-reverse">
                            <a href="{{ route('admin.job-offers') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">العودة للقائمة</a>
                            <a href="{{ route('admin.job-offers.edit', $jobOffer->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">تعديل</a>
                            <form action="{{ route('admin.job-offers.delete', $jobOffer->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('هل أنت متأكد من حذف هذه الفرصة؟')">حذف</button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            @if($jobOffer->image)
                                <img src="{{ Storage::url($jobOffer->image) }}" alt="{{ $jobOffer->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg mb-4">
                                    <span class="text-gray-500">لا توجد صورة</span>
                                </div>
                            @endif

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-lg mb-2">معلومات أساسية</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">المنظمة:</p>
                                        <p class="font-medium">{{ $jobOffer->organization->name ?? 'غير متوفر' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">الحالة:</p>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $jobOffer->status == 'متاحة' ? 'bg-green-100 text-green-800' : 
                                                ($jobOffer->status == 'مغلقة' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $jobOffer->status }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">الموعد النهائي:</p>
                                        <p class="font-medium">{{ $jobOffer->deadline ? $jobOffer->deadline->format('Y-m-d') : 'غير محدد' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">تاريخ الإنشاء:</p>
                                        <p class="font-medium">{{ $jobOffer->created_at->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold text-lg mb-2">الوصف</h4>
                                <div class="prose max-w-none">
                                    {{ $jobOffer->description }}
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-semibold text-lg mb-2">المهارات المطلوبة</h4>
                                <p>{{ $jobOffer->skills_required ?? 'غير محدد' }}</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-lg mb-2">معلومات إضافية</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">المدينة:</p>
                                        <p class="font-medium">{{ $jobOffer->city ?? 'غير محدد' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">العنوان:</p>
                                        <p class="font-medium">{{ $jobOffer->location ?? 'غير محدد' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">عدد المتطوعين المطلوب:</p>
                                        <p class="font-medium">{{ $jobOffer->volunteers_needed ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 