<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 rtl">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <img class="mx-auto h-16 w-auto mb-4" src="{{ asset('storage/auth/@logo-login.jpeg') }}" alt="منصة التطوع">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إنشاء حساب جديد</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">كن جزءًا من التغيير الإيجابي في سوريا ✨</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-6 shadow-md rounded-2xl sm:px-10 space-y-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('الاسم')" />
                        <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                        <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('كلمة المرور')" />
                        <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                      type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition">
                            إنشاء الحساب
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative text-center text-sm text-gray-500 dark:text-gray-400">
                    <span class="bg-white dark:bg-gray-800 px-2">أو سجل باستخدام</span>
                </div>

                <!-- Social Login -->
                <div class="flex flex-col gap-3">
                    <a href="{{ url('auth/google') }}"
                       class="flex items-center justify-center py-2 px-4 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                        تسجيل عبر Google
                    </a>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-4 text-sm text-gray-600 dark:text-gray-300">
                    لديك حساب بالفعل؟ 
                    <a href="{{ route('login') }}" class="text-green-600 hover:underline dark:text-green-400">
                        تسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
