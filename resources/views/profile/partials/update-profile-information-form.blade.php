<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
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
                <div class="relative mb-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-200 dark:border-gray-700">
                        @php
                            $profilePath = $user->profile_photo_url;
                        @endphp
                        <img id="preview-image" src="{{ $profilePath }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="change-photo-btn" class="absolute bottom-0 left-0 bg-blue-600 text-white rounded-full p-2 hover:bg-blue-700 transition">
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
                <div>
                    <x-input-label for="name" :value="__('الاسم')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('بريدك الإلكتروني غير مُفعّل.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
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
                <div>
                    <x-input-label for="phone" :value="__('رقم الهاتف')" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '')" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('حفظ') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
                        previewImage.src = e.target.result;
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
