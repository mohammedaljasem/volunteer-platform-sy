<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ $conversation->title ?? 'محادثة' }}
        </h2>
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
                        <p class="mt-1 text-gray-800 dark:text-gray-100">{{ $message->body }}</p>
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

        {{-- Form إرسال رسالة جديدة --}}
        <form action="{{ route('chat.message', $conversation) }}" method="POST" class="mt-6 space-y-3">
            @csrf
            <textarea name="body" rows="3" class="w-full border rounded px-3 py-2 dark:bg-gray-800 dark:text-white" placeholder="اكتب رسالتك هنا..." required></textarea>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">إرسال</button>
        </form>
    </div>
</x-app-layout>
