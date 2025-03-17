<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-600 dark:text-red-400">
            {{ __('حذف الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.') }}
        </p>
    </header>

    <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-md border border-red-200 dark:border-red-800">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 dark:text-red-400"></i>
            </div>
            <div class="mr-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">{{ __('تحذير: لا يمكن التراجع عن هذا الإجراء') }}</h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                    <p>{{ __('عند حذف حسابك:') }}</p>
                    <ul class="list-disc pr-5 mt-1 space-y-1">
                        <li>{{ __('سيتم حذف جميع معلوماتك الشخصية') }}</li>
                        <li>{{ __('ستتم إزالة مشاركتك في أي فعاليات') }}</li>
                        <li>{{ __('سيتم إخفاء هوية مساهماتك') }}</li>
                        <li>{{ __('لا يمكن استعادة حسابك') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full sm:w-auto flex justify-center items-center"
    >
        <i class="fas fa-trash-alt ml-2"></i>
        {{ __('حذف الحساب') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
                </div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('هل أنت متأكد أنك تريد حذف حسابك؟') }}
                </h2>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. الرجاء إدخال كلمة المرور الخاصة بك لتأكيد رغبتك في حذف حسابك نهائياً.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('كلمة المرور') }}" class="sr-only" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="{{ __('كلمة المرور') }}"
                    />
                    <button type="button" class="toggle-password absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto justify-center">
                    <i class="fas fa-times ml-2"></i>{{ __('إلغاء') }}
                </x-secondary-button>

                <x-danger-button class="w-full sm:w-auto justify-center">
                    <i class="fas fa-trash-alt ml-2"></i>{{ __('حذف الحساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleBtn = document.querySelector('.toggle-password');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
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
            }
        });
    </script>
    @endpush
</section>
