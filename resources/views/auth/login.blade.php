<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 rtl">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-primary dark:text-primary-400 mb-6">
                {{ __('منصة التطوع السورية') }}
            </h2>
            <img class="mx-auto h-16 w-auto" src="{{ asset('storage/auth/@logo-login.jpeg') }}" alt="منصة التطوع">
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('البريد الإلكتروني')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <div class="mt-1">
                            <x-text-input id="email" class="form-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('كلمة المرور')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <div class="mt-1">
                            <x-text-input id="password" class="form-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded" name="remember">
                            <label for="remember_me" class="mr-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('تذكرني') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-secondary hover:text-secondary-dark dark:text-secondary-400 dark:hover:text-secondary-300" href="{{ route('password.request') }}">
                                {{ __('نسيت كلمة المرور؟') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-dark dark:bg-secondary-700 dark:hover:bg-secondary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-light dark:focus:ring-offset-gray-800 dark:focus:ring-secondary-500">
                            {{ __('تسجيل الدخول') }}
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="text-sm text-secondary hover:text-secondary-dark dark:text-secondary-400 dark:hover:text-secondary-300">
                            {{ __('ليس لديك حساب؟ سجل الآن') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
