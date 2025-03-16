<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('الحملات التطوعية') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">قائمة الحملات التطوعية</h3>
                        
                        @can('create-campaign')
                        <a href="{{ route('ads.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            إنشاء حملة جديدة
                        </a>
                        @endcan
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        الصورة
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        العنوان
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        المنظمة/الفريق
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        المبلغ المستهدف
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        التقدم
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        الحالة
                                    </th>
                                    <th class="py-3 px-6 bg-gray-100 dark:bg-gray-800 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-b">
                                        الإجراءات
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($ads as $ad)
                                    <tr>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            @if ($ad->image)
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="h-16 w-16 object-cover rounded">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                                    <span class="text-gray-500 dark:text-gray-400">لا توجد صورة</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            <a href="{{ route('ads.show', $ad) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $ad->title }}
                                            </a>
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            {{ $ad->company->name }}
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            {{ number_format($ad->goal_amount, 0) }} ل.س
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $ad->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-600 dark:text-gray-300">
                                                {{ $ad->progress_percentage }}% ({{ number_format($ad->current_amount, 0) }} ل.س)
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600">
                                            @if ($ad->status === 'نشطة')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    {{ $ad->status }}
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                    {{ $ad->status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 border-b border-gray-200 dark:border-gray-600 text-sm">
                                            <a href="{{ route('ads.show', $ad) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 ml-2">
                                                عرض
                                            </a>
                                            
                                            @can('update', $ad)
                                            <a href="{{ route('ads.edit', $ad) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 ml-2">
                                                تعديل
                                            </a>
                                            @endcan
                                            
                                            @can('delete', $ad)
                                            <form class="inline" action="{{ route('ads.destroy', $ad) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الحملة؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    حذف
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400">
                                            لا توجد حملات تطوعية متاحة حاليًا.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $ads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 