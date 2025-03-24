<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 rtl">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-primary dark:text-primary-400 mb-6">
                {{ __('إنشاء حساب جديد') }}
            </h2>
            <img class="mx-auto h-16 w-auto" src="{{ asset('storage/auth/@logo-login.jpeg') }}" alt="منصة التطوع">
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('الاسم')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <div class="mt-1">
                            <x-text-input id="name" class="form-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('البريد الإلكتروني')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <div class="mt-1">
                            <x-text-input id="email" class="form-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
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
                                required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
                        <div class="mt-1">
                            <x-text-input id="password_confirmation" class="form-input dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-secondary hover:bg-secondary-dark dark:bg-secondary-700 dark:hover:bg-secondary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-light dark:focus:ring-offset-gray-800 dark:focus:ring-secondary-500">
                            {{ __('إنشاء الحساب') }}
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm text-secondary hover:text-secondary-dark dark:text-secondary-400 dark:hover:text-secondary-300">
                            {{ __('لديك حساب بالفعل؟ تسجيل الدخول') }}
                        </a>
                    </div>
                    <div class="flex justify-center mt-4 space-x-4">
                        <a href="{{ url('auth/google') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            تسجيل عبر Google
                        </a>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
