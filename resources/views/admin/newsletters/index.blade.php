<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة النشرة البريدية') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">قائمة المشتركين ({{ $subscribers->total() }})</h3>
                        <p class="text-sm text-gray-600">جميع المشتركين في النشرة البريدية.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 [&>th]:py-2 [&>th]:px-4 [&>th]:border [&>th]:text-right">
                                    <th>#</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>حالة الاشتراك</th>
                                    <th>تاريخ الاشتراك</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscribers as $index => $subscriber)
                                    <tr class="border-b hover:bg-gray-50 [&>td]:py-2 [&>td]:px-4 [&>td]:border">
                                        <td>{{ $subscribers->firstItem() + $index }}</td>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>
                                            @if($subscriber->is_active)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">نشط</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>{{ $subscriber->subscribed_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.newsletters.destroy', $subscriber->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذا المشترك؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">لا يوجد مشتركين حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subscribers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 