<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('تذكرة رقم #') . $ticket->id }}
            </h2>
            <a href="{{ route('support.my-tickets') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-md transition-colors">
                العودة للتذاكر
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $ticket->subject }}</h3>
                            <div class="flex items-center mt-2">
                                <span class="text-gray-600 ml-4">التصنيف: {{ $ticket->category_name }}</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($ticket->status == 'new') bg-blue-100 text-blue-800
                                    @elseif($ticket->status == 'in_progress') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->status == 'resolved') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $ticket->status_name }}
                                </span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 text-left">
                            <div>تاريخ الإنشاء: {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
                            <div>آخر تحديث: {{ $ticket->updated_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 ml-4">
                                <div class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                                    {{ substr($ticket->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $ticket->name }}</div>
                                <div class="text-sm text-gray-500 mb-2">{{ $ticket->email }}</div>
                                <div class="text-gray-700 whitespace-pre-line">{{ $ticket->message }}</div>
                            </div>
                        </div>
                    </div>

                    @if($ticket->reply)
                    <div class="border-t border-gray-200 mt-6 pt-4">
                        <h4 class="font-bold mb-4">الرد:</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 ml-4">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900">فريق الدعم الفني</div>
                                    <div class="text-gray-700 mt-2 whitespace-pre-line">{{ $ticket->reply }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ticket->status == 'closed')
                    <div class="mt-6 bg-gray-100 p-4 rounded-lg text-center">
                        <p class="text-gray-600">تم إغلاق هذه التذكرة. إذا كنت بحاجة إلى مزيد من المساعدة، يرجى إنشاء تذكرة جديدة.</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($ticket->status != 'closed')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4 class="font-bold mb-4">إرسال رد:</h4>
                    <form action="{{ route('support.ticket.reply', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="reply" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="اكتب ردك هنا..." required></textarea>
                        </div>
                        <div class="text-left">
                            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition-colors">
                                إرسال الرد
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout> 