<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 rtl">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <img class="mx-auto h-16 w-auto mb-4" src="{{ asset('storage/auth/@logo-login.jpeg') }}" alt="منصة التطوع">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">منصة التطوع السورية</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">مرحباً بك من جديد 👋</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-md rounded-2xl sm:px-10 space-y-6">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                        <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('كلمة المرور')" />
                        <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                   class="h-4 w-4 text-green-600 border-gray-300 rounded dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">تذكرني</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-green-600 hover:underline dark:text-green-400"
                               href="{{ route('password.request') }}">
                                نسيت كلمة المرور؟
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit"
                                class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            تسجيل الدخول
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative text-center text-sm text-gray-500 dark:text-gray-400">
                    <span class="bg-white dark:bg-gray-800 px-2">أو سجل باستخدام</span>
                </div>

                <!-- Social Login Buttons -->
                <div class="flex flex-col gap-3">
                    <a href="{{ url('auth/google') }}"
                       class="flex items-center justify-center py-2 px-4 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                        تسجيل الدخول عبر Google
                    </a>

                </div>

                <!-- Register Link -->
                <div class="text-center mt-4 text-sm text-gray-600 dark:text-gray-300">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline dark:text-green-400">
                        سجل الآن
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
