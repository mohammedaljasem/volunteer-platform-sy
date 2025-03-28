<x-app-layout>
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            المحادثات
        </h2>

        <x-nav-link :href="route('chat.archived')" :active="request()->routeIs('chat.archived')">
            🗂️ الأرشيف
        </x-nav-link>
    </div>
</x-slot>


    <div class="p-6 space-y-4">
            <div class="flex justify-end">
            <button onclick="document.getElementById('newChatModal').showModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                + محادثة جديدة
            </button>
            </div>

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

    <form action="{{ route('chat.destroy', $conversation) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه المحادثة؟')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">حذف</button>
    </form>
    <form action="{{ route('chat.archive', $conversation) }}" method="POST" onsubmit="return confirm('هل تريد أرشفة هذه المحادثة؟')">
    @csrf
    @method('PUT')
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm ml-2">أرشفة</button>
</form>

</div>

        @empty
            <p class="text-gray-500 dark:text-gray-400">لا توجد محادثات بعد.</p>
        @endforelse
        <dialog id="newChatModal" class="rounded-md p-6 shadow-xl w-96">
    <form method="POST" action="{{ route('chat.store') }}">
        @csrf
        <h3 class="text-lg font-bold mb-4">محادثة جديدة</h3>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">اختر المستخدم</label>
            <select name="user_id" id="user_id" class="w-full border rounded px-3 py-2 mt-1" required>
                @foreach(App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">عنوان المحادثة (اختياري)</label>
            <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2 mt-1" />
        </div>

        <div class="flex justify-end gap-2">
            <button type="button" onclick="document.getElementById('newChatModal').close()" class="text-gray-500 hover:text-gray-700">إلغاء</button>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">إنشاء</button>
        </div>
    </form>
</dialog>

    </div>
</x-app-layout>
