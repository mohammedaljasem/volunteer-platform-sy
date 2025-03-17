<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            تبرع الآن
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-bold mb-4">تبرع الآن</h3>
                    <p class="mb-4">ساهم في دعم هذه الحملة وساعد في إحداث تغيير إيجابي</p>
                    
                    <form method="POST" action="{{ route('ads.donate.store', 1) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium mb-1">مبلغ التبرع (ل.س)</label>
                            <input type="number" id="amount" name="amount" min="1000" step="500" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full" placeholder="أدخل مبلغ التبرع" required>
                        </div>
                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium mb-1">طريقة الدفع</label>
                            <select id="payment_method" name="payment_method" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block w-full" required>
                                <option value="">اختر طريقة الدفع</option>
                                <option value="نقدي">نقدي</option>
                                <option value="تحويل بنكي">تحويل بنكي</option>
                                <option value="محفظة">الدفع من محفظتي</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                إرسال التبرع
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
