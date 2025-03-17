<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('تحديث كلمة المرور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للبقاء آمناً.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" id="password-form">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="update_password_current_password" :value="__('كلمة المرور الحالية')" />
                <div class="relative">
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full pe-10" autocomplete="current-password" />
                    <button type="button" class="toggle-password absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 mt-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="space-y-6">
                <div>
                    <x-input-label for="update_password_password" :value="__('كلمة المرور الجديدة')" />
                    <div class="relative">
                        <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full pe-10" autocomplete="new-password" />
                        <button type="button" class="toggle-password absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 mt-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('تأكيد كلمة المرور')" />
                    <div class="relative">
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full pe-10" autocomplete="new-password" />
                        <button type="button" class="toggle-password absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 mt-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="password-strength-meter hidden">
                <div class="text-sm font-medium mb-1">{{ __('قوة كلمة المرور') }}</div>
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="password-strength-bar h-full bg-red-500" style="width: 0%"></div>
                </div>
                <div class="password-strength-text text-xs mt-1 text-gray-600"></div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('حفظ') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('تم الحفظ.') }}</p>
            @endif
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentNode.querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Password strength meter
            const passwordInput = document.getElementById('update_password_password');
            const strengthMeter = document.querySelector('.password-strength-meter');
            const strengthBar = document.querySelector('.password-strength-bar');
            const strengthText = document.querySelector('.password-strength-text');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password.length > 0) {
                    strengthMeter.classList.remove('hidden');
                    
                    // Calculate password strength
                    let strength = 0;
                    
                    // Length check
                    if (password.length >= 8) strength += 25;
                    
                    // Uppercase check
                    if (/[A-Z]/.test(password)) strength += 25;
                    
                    // Lowercase check
                    if (/[a-z]/.test(password)) strength += 25;
                    
                    // Number/special character check
                    if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
                    
                    // Update UI
                    strengthBar.style.width = strength + '%';
                    
                    // Update color based on strength
                    if (strength < 25) {
                        strengthBar.className = 'password-strength-bar h-full bg-red-500';
                        strengthText.textContent = 'ضعيفة جداً';
                    } else if (strength < 50) {
                        strengthBar.className = 'password-strength-bar h-full bg-orange-500';
                        strengthText.textContent = 'ضعيفة';
                    } else if (strength < 75) {
                        strengthBar.className = 'password-strength-bar h-full bg-yellow-500';
                        strengthText.textContent = 'متوسطة';
                    } else {
                        strengthBar.className = 'password-strength-bar h-full bg-green-500';
                        strengthText.textContent = 'قوية';
                    }
                } else {
                    strengthMeter.classList.add('hidden');
                }
            });

            // Form validation
            const form = document.getElementById('password-form');
            const confirmInput = document.getElementById('update_password_password_confirmation');
            
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;
                
                if (password && password !== confirmPassword) {
                    e.preventDefault();
                    alert('{{ __("كلمة المرور وتأكيد كلمة المرور غير متطابقين!") }}');
                }
            });
        });
    </script>
    @endpush
</section>
