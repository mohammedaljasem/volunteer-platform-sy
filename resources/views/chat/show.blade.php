<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ $conversation->title ?? 'محادثة' }}
            </h2>

            <!-- زر تعديل -->
            <button onclick="document.getElementById('editTitleModal').showModal()" 
                class="text-blue-500 text-sm hover:underline">
                تعديل اسم المحادثة
            </button>
        </div>
    </x-slot>

    <div class="p-6 space-y-4">
        @foreach ($conversation->messages as $message)
            <div class="mb-2 p-2 rounded {{ $message->user_id == auth()->id() ? 'bg-green-100' : 'bg-gray-100' }}">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-sm text-gray-700 dark:text-gray-300">
                            {{ $message->user->name }} -
                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">
                            {{ $message->content }}
                        </p>
                    </div>

                    @if ($message->user_id === auth()->id())
                        <form action="{{ route('chat.message.destroy', $message) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الرسالة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm ml-2 hover:underline">حذف</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Form إرسال رسالة جديدة -->
        <form action="{{ route('chat.message', $conversation) }}" method="POST" class="mt-6 space-y-3">
            @csrf
            <textarea name="body" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white" placeholder="اكتب رسالتك هنا..." required></textarea>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">إرسال</button>
        </form>

        <!-- نافذة تعديل اسم المحادثة -->
        <dialog id="editTitleModal" class="rounded-md p-6 shadow-xl w-96">
            <form method="POST" action="{{ route('chat.update.title', $conversation) }}">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-bold mb-4">تعديل اسم المحادثة</h3>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">اسم جديد</label>
                    <input type="text" name="title" id="title" value="{{ $conversation->title }}" 
                        class="w-full border rounded px-3 py-2 mt-1" required />
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('editTitleModal').close()" 
                        class="text-gray-500 hover:text-gray-700">إلغاء</button>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        حفظ
                    </button>
                </div>
            </form>
        </dialog>
    </div>
</x-app-layout>
