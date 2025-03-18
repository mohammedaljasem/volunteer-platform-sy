<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('تحديث كلمة المرور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('تأكد من استخدام كلمة مرور طويلة وعشوائية للحفاظ على أمان حسابك.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="group">
            <x-input-label for="current_password" :value="__('كلمة المرور الحالية')" class="group-focus-within:text-green-600 transition-colors duration-200" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="group">
            <x-input-label for="password" :value="__('كلمة المرور الجديدة')" class="group-focus-within:text-green-600 transition-colors duration-200" />
            <div class="relative">
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" autocomplete="new-password" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm">
                    <button type="button" id="togglePassword" class="text-gray-400 hover:text-green-600 focus:outline-none transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 password-toggle-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <div class="mt-1">
                <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ __('قوة كلمة المرور:') }}</div>
                <div id="password-strength" class="h-1.5 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden transition-all duration-300"></div>
            </div>
        </div>

        <div class="group">
            <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" class="group-focus-within:text-green-600 transition-colors duration-200" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:ring-green-500 transition-all duration-200">
                {{ __('حفظ') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform translate-y-2"
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-3 py-1 rounded-full"
                >{{ __('تم الحفظ بنجاح.') }}</p>
            @endif
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordStrength = document.getElementById('password-strength');
            
            // Toggle password visibility
            togglePasswordBtn?.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                const icon = togglePasswordBtn.querySelector('.password-toggle-icon');
                if (type === 'text') {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
                } else {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
                }
            });
            
            // Password strength checker
            passwordInput?.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 25;
                
                // Complexity checks
                if (/[A-Z]/.test(password)) strength += 25; // Uppercase
                if (/[a-z]/.test(password)) strength += 25; // Lowercase
                if (/[0-9]/.test(password)) strength += 12.5; // Numbers
                if (/[^A-Za-z0-9]/.test(password)) strength += 12.5; // Special chars
                
                // Update visual
                passwordStrength.style.width = `${strength}%`;
                
                // Color based on strength
                if (strength < 25) {
                    passwordStrength.style.backgroundColor = '#ef4444'; // Red
                } else if (strength < 50) {
                    passwordStrength.style.backgroundColor = '#f97316'; // Orange
                } else if (strength < 75) {
                    passwordStrength.style.backgroundColor = '#eab308'; // Yellow
                } else {
                    passwordStrength.style.backgroundColor = '#22c55e'; // Green
                }
            });
        });
    </script>
    @endpush
</section>
