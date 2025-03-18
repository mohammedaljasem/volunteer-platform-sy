<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-green-600 dark:text-green-400 leading-tight">
            {{ __('الملف الشخصي') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Flash Messages -->
            @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <div>{{ session('error') }}</div>
                </div>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <span>إغلاق</span>
                </button>
            </div>
            @endif
            
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                    <div>{{ session('success') }}</div>
                </div>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <span>إغلاق</span>
                </button>
            </div>
            @endif

            <!-- Profile Tabs -->
            <div x-data="{ activeTab: 'personal' }" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'personal'" :class="{ 'text-green-600 dark:text-green-400 border-b-2 border-green-500': activeTab === 'personal', 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-300': activeTab !== 'personal' }" class="py-4 px-6 font-medium text-sm transition-colors duration-200 ease-in-out focus:outline-none">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('المعلومات الشخصية') }}
                            </div>
                        </button>
                        <button @click="activeTab = 'security'" :class="{ 'text-green-600 dark:text-green-400 border-b-2 border-green-500': activeTab === 'security', 'text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-300': activeTab !== 'security' }" class="py-4 px-6 font-medium text-sm transition-colors duration-200 ease-in-out focus:outline-none">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ __('الأمان') }}
                            </div>
                        </button>
                        <button @click="activeTab = 'danger'" :class="{ 'text-red-600 dark:text-red-400 border-b-2 border-red-500': activeTab === 'danger', 'text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-300': activeTab !== 'danger' }" class="py-4 px-6 font-medium text-sm transition-colors duration-200 ease-in-out focus:outline-none">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                {{ __('منطقة الخطر') }}
                            </div>
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Personal Info Tab -->
                    <div x-show="activeTab === 'personal'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Security Tab -->
                    <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Danger Zone Tab -->
                    <div x-show="activeTab === 'danger'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Load Font Awesome for icons
        document.addEventListener('DOMContentLoaded', function () {
            // Check if Font Awesome is already loaded
            if (!document.querySelector('link[href*="fontawesome"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
                document.head.appendChild(link);
            }
            
            // Handle alert dismissal
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                const dismissBtn = alert.querySelector('button');
                if (dismissBtn) {
                    dismissBtn.addEventListener('click', () => {
                        alert.remove();
                    });
                }
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 5000);
            });
        });
    </script>
    @endpush
</x-app-layout>
