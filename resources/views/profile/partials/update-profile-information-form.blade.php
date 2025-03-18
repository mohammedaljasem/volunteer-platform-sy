<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            {{ __('معلومات الملف الشخصي') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("تحديث معلومات حسابك وعنوان بريدك الإلكتروني.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" id="profile-form">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div class="flex flex-col sm:flex-row gap-6 mb-6">
            <div class="flex flex-col items-center">
                <div class="relative mb-4 group">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-100 dark:border-green-900 shadow-md transition-transform duration-300 group-hover:shadow-lg group-hover:border-green-200 dark:group-hover:border-green-800">
                        @php
                            $profilePath = $user->profile_photo_url;
                        @endphp
                        <img id="preview-image" src="{{ $profilePath }}" alt="{{ $user->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <button type="button" id="change-photo-btn" class="absolute bottom-0 left-0 bg-green-600 text-white rounded-full p-2 hover:bg-green-700 shadow-md transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
                <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*">
                <div class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    {{ __('انقر لتحديث صورتك الشخصية') }}
                    <p class="text-xs mt-1">{{ __('الحد الأقصى لحجم الملف: 2 ميجابايت') }}</p>
                </div>
            </div>

            <div class="space-y-4 flex-1">
                <!-- Name -->
                <div class="group">
                    <x-input-label for="name" :value="__('الاسم')" class="group-focus-within:text-green-600 transition-colors duration-200" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div class="group">
                    <x-input-label for="email" :value="__('البريد الإلكتروني')" class="group-focus-within:text-green-600 transition-colors duration-200" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('بريدك الإلكتروني غير مُفعّل.') }}

                                <button form="send-verification" class="underline text-sm text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                    {{ __('انقر هنا لإعادة إرسال رسالة التفعيل.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('تم إرسال رابط تفعيل جديد إلى عنوان بريدك الإلكتروني.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Phone Number -->
                <div class="group">
                    <x-input-label for="phone" :value="__('رقم الهاتف')" class="group-focus-within:text-green-600 transition-colors duration-200" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full focus:border-green-500 focus:ring-green-500 transition-colors duration-200" :value="old('phone', $user->phone ?? '')" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:ring-green-500 transition-all duration-200">
                {{ __('حفظ التغييرات') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
        // Profile picture preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profilePhotoInput = document.getElementById('profile_photo');
            const previewImage = document.getElementById('preview-image');
            const changePhotoBtn = document.getElementById('change-photo-btn');
            const profileForm = document.getElementById('profile-form');

            changePhotoBtn.addEventListener('click', function() {
                profilePhotoInput.click();
            });

            profilePhotoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (max 2MB = 2 * 1024 * 1024)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('{{ __("حجم الملف يتجاوز 2 ميجابايت. يرجى اختيار صورة أصغر.") }}');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'];
                    if (!validTypes.includes(file.type)) {
                        alert('{{ __("يُسمح فقط بصور JPG و PNG و GIF و SVG.") }}');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Add a fade effect
                        previewImage.style.opacity = '0.5';
                        previewImage.src = e.target.result;
                        
                        // After image loads, fade it back in
                        previewImage.onload = function() {
                            setTimeout(() => {
                                previewImage.style.opacity = '1';
                            }, 100);
                        };
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            profileForm.addEventListener('submit', function(e) {
                // Show loading indicator or disable button if needed
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i>{{ __("جارٍ الحفظ...") }}';
                }
            });
        });
    </script>
    @endpush
</section>
