<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 rtl">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <img class="mx-auto h-16 w-auto mb-4" src="{{ asset('storage/auth/@logo-login.jpeg') }}" alt="منصة التطوع">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">نسيت كلمة المرور؟</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                أدخل بريدك الإلكتروني وسنرسل لك رابطًا لإعادة تعيين كلمة المرور ✉️
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-md rounded-2xl sm:px-10 space-y-6">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="text-green-600 text-sm text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                        <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            إرسال رابط إعادة التعيين
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4 text-sm text-gray-600 dark:text-gray-300">
                    تتذكر كلمة المرور؟ 
                    <a href="{{ route('login') }}" class="text-green-600 hover:underline dark:text-green-400">
                        تسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
