<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('التبرع للحملة') }}: {{ $ad->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('ads.donate.store', $ad) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">{{ $ad->title }}</h3>
                            <div class="flex justify-between items-center mb-2">
                                <span>الهدف:</span>
                                <span class="font-bold">{{ number_format($ad->goal_amount, 0) }} ل.س</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span>المبلغ الحالي:</span>
                                <span class="font-bold text-green-600 dark:text-green-400">{{ number_format($ad->current_amount, 0) }} ل.س</span>
                            </div>
                            <div class="text-center mb-2">
                                <span class="text-lg font-semibold">نسبة الإنجاز: {{ $ad->progress_percentage }}%</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="amount" :value="__('مبلغ التبرع (بالليرة السورية)')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" min="1" required autofocus />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="payment_method" :value="__('طريقة الدفع')" />
                            <select id="payment_method" name="payment_method" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">اختر طريقة الدفع</option>
                                <option value="نقدي" {{ old('payment_method') == 'نقدي' ? 'selected' : '' }}>نقدي</option>
                                <option value="تحويل بنكي" {{ old('payment_method') == 'تحويل بنكي' ? 'selected' : '' }}>تحويل بنكي</option>
                                <option value="محفظة" {{ old('payment_method') == 'محفظة' ? 'selected' : '' }}>
                                    الدفع من محفظتي
                                    @php
                                        // البحث عن محفظة المستخدم أو إنشاء محفظة جديدة
                                        $wallet = \App\Models\Wallet::firstOrCreate(
                                            ['user_id' => auth()->id()],
                                            ['balance' => 0]
                                        );
                                        echo ' (' . number_format($wallet->balance, 0) . ' ل.س)';
                                    @endphp
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_recurring" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('is_recurring') ? 'checked' : '' }}>
                                <span class="mr-2 text-sm text-gray-600 dark:text-gray-400">تبرع متكرر شهرياً</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <a href="{{ route('ads.show', $ad) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">إلغاء</a>
                            <x-primary-button class="ml-3">
                                {{ __('تبرع الآن') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
