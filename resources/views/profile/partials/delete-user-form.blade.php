<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('حذف الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع الموارد والبيانات الخاصة به نهائيًا. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.') }}
        </p>
    </header>

    <div class="p-6 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-lg shadow-sm">
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500 mr-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h3 class="text-lg font-medium text-red-800 dark:text-red-300">{{ __('تحذير: هذا الإجراء لا يمكن التراجع عنه') }}</h3>
                <p class="text-sm text-red-700 dark:text-red-400 mt-1">{{ __('بمجرد حذف حسابك، لن يكون هناك أي طريقة لاستعادة بياناتك.') }}</p>
            </div>
        </div>

        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="w-full flex justify-center py-3 transition-all duration-200 hover:bg-red-700 focus:ring-red-500 focus:ring-offset-red-200"
        >{{ __('حذف الحساب') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ __('هل أنت متأكد من رغبتك في حذف حسابك؟') }}
            </h2>

            <div class="mb-5">
                <div class="flex p-4 mb-4 bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 text-yellow-800 dark:text-yellow-300 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="text-sm">{{ __('سيتم حذف جميع المعلومات المرتبطة بحسابك بشكل دائم. يرجى إدخال كلمة المرور الخاصة بك لتأكيد رغبتك في حذف حسابك بشكل نهائي.') }}</p>
                    </div>
                </div>
            </div>

            <div class="group mb-5">
                <x-input-label for="password" value="{{ __('كلمة المرور') }}" class="group-focus-within:text-red-600 transition-colors duration-200 sr-only" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full focus:border-red-500 focus:ring-red-500 transition-colors duration-200"
                        placeholder="{{ __('كلمة المرور') }}"
                    />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <button type="button" id="toggleDeletePassword" class="hover:text-red-600 focus:outline-none transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 password-toggle-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="mr-3 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-danger-button class="transition-all duration-200 hover:bg-red-700">
                    {{ __('حذف الحساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggleDeletePassword');
            
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
        });
    </script>
    @endpush
</section>
