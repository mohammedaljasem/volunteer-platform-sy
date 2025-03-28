<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            تعديل اسم المحادثة
        </h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('chat.update', $conversation) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium">اسم المحادثة الجديد</label>
                <input type="text" name="title" id="title" value="{{ $conversation->title }}" class="w-full border rounded px-3 py-2 mt-1">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">حفظ</button>
            </div>
        </form>
    </div>
</x-app-layout>
