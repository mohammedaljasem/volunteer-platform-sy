<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            🗂️ المحادثات المؤرشفة
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @forelse($conversations as $conversation)
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow flex justify-between items-center">
                <div>
                    <a href="{{ route('chat.show', $conversation) }}" class="text-lg font-semibold hover:underline block">
                        {{ $conversation->title ?? 'بدون عنوان' }}
                    </a>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        الأعضاء: {{ $conversation->users->pluck('name')->join(', ') }}
                    </p>
                </div>

                <form action="{{ route('chat.unarchive', $conversation) }}" method="POST" onsubmit="return confirm('استعادة هذه المحادثة من الأرشيف؟')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                        استعادة
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">لا توجد محادثات مؤرشفة.</p>
        @endforelse
    </div>
</x-app-layout>
