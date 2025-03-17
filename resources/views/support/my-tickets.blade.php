<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تذاكر الدعم الفني الخاصة بي') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">تذاكر الدعم الفني الخاصة بي</h3>
                        <a href="{{ route('support.technical') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded-md transition-colors">
                            إنشاء تذكرة جديدة
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($tickets->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-6a2 2 0 00-2 2v12a2 2 0 002 2h6z" />
                            </svg>
                            <p class="text-gray-600 text-lg">لا توجد تذاكر دعم فني</p>
                            <p class="text-gray-500 mt-2">قم بإنشاء تذكرة جديدة عند الحاجة للمساعدة</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-3 px-4 text-right border-b">رقم التذكرة</th>
                                        <th class="py-3 px-4 text-right border-b">الموضوع</th>
                                        <th class="py-3 px-4 text-right border-b">التصنيف</th>
                                        <th class="py-3 px-4 text-right border-b">الحالة</th>
                                        <th class="py-3 px-4 text-right border-b">تاريخ الإنشاء</th>
                                        <th class="py-3 px-4 text-right border-b">خيارات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr class="hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                            <td class="py-3 px-4 border-b">#{{ $ticket->id }}</td>
                                            <td class="py-3 px-4 border-b">{{ Str::limit($ticket->subject, 50) }}</td>
                                            <td class="py-3 px-4 border-b">{{ $ticket->category_name }}</td>
                                            <td class="py-3 px-4 border-b">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($ticket->status == 'new') bg-blue-100 text-blue-800
                                                    @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                                    @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $ticket->status_name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 border-b">{{ $ticket->created_at->format('Y-m-d') }}</td>
                                            <td class="py-3 px-4 border-b">
                                                <a href="{{ route('support.ticket.show', $ticket) }}" class="text-primary hover:text-primary-dark font-medium">
                                                    عرض التفاصيل
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $tickets->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 