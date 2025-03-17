<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('محفظتي') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-8 text-center">
                        <h3 class="text-2xl font-bold mb-2 font-cairo">رصيد محفظتك</h3>
                        <div class="text-4xl font-bold text-green-600 dark:text-green-400">
                            {{ number_format($wallet->balance, 0) }} <span class="text-xl">ل.س</span>
                        </div>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">يمكنك استخدام رصيد محفظتك للتبرع في الحملات التطوعية</p>
                    </div>

                    <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg">
                        <h3 class="text-xl font-bold mb-4 font-cairo">شحن المحفظة</h3>
                        
                        <form method="POST" action="{{ route('wallet.charge') }}" class="space-y-4">
                            @csrf
                            
                            <div>
                                <x-input-label for="amount" :value="__('المبلغ (ل.س)')" />
                                <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" :value="old('amount')" min="1" required autofocus />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">الحد الأدنى للشحن هو 1 ليرة سورية</p>
                            </div>
                            
                            <div class="flex justify-start">
                                <x-primary-button type="submit" class="bg-green-500 hover:bg-green-600">
                                    {{ __('شحن المحفظة') }}
                                </x-primary-button>
                            </div>
                            
                            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                <p>ملاحظة: في بيئة حقيقية، سيتم توجيهك إلى بوابة دفع آمنة لإكمال عملية الشحن.</p>
                                <p>في هذا النموذج، يتم إضافة المبلغ مباشرة إلى رصيد المحفظة لأغراض العرض.</p>
                            </div>
                        </form>
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4 font-cairo">كيفية استخدام المحفظة</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-300">
                            <li>قم بشحن محفظتك بالمبلغ الذي ترغب به</li>
                            <li>عند التبرع في أي حملة تطوعية، يمكنك اختيار "محفظة" كطريقة للدفع</li>
                            <li>سيتم خصم المبلغ من رصيد محفظتك مباشرة</li>
                            <li>يمكنك متابعة رصيد محفظتك وتاريخ المعاملات من هذه الصفحة</li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 