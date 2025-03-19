<!-- مكون إشعارات توست للتنبيهات -->
<div
    x-data="{ 
        notifications: [],
        add(notification) {
            notification.id = Date.now();
            this.notifications.push(notification);
            setTimeout(() => { this.remove(notification) }, notification.timeout || 3000);
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id);
        },
        init() {
            const sessionSuccessMessage = '{{ session('success') }}';
            const sessionErrorMessage = '{{ session('error') }}';
            
            if (sessionSuccessMessage) {
                this.add({
                    type: 'success',
                    message: sessionSuccessMessage
                });
            }
            
            if (sessionErrorMessage) {
                this.add({
                    type: 'error',
                    message: sessionErrorMessage
                });
            }
            
            window.addEventListener('toast', event => {
                this.add(event.detail);
            });
        }
    }"
    class="fixed inset-0 z-50 flex flex-col items-end justify-start gap-4 p-6 px-4 pointer-events-none sm:px-6 sm:py-6"
    style="transform: translateZ(0px)"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-2 opacity-0"
            class="relative w-full max-w-sm overflow-hidden rounded-lg shadow-lg pointer-events-auto ring-1 dark:ring-white/10 sm:w-96"
            :class="{
                'bg-white dark:bg-gray-900 ring-gray-200': notification.type !== 'error' && notification.type !== 'success' && notification.type !== 'warning',
                'bg-green-50 dark:bg-green-900/50 ring-green-200 dark:ring-green-800': notification.type === 'success', 
                'bg-red-50 dark:bg-red-900/50 ring-red-200 dark:ring-red-800': notification.type === 'error',
                'bg-yellow-50 dark:bg-yellow-900/50 ring-yellow-200 dark:ring-yellow-800': notification.type === 'warning'
            }"
        >
            <div class="relative p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 ltr:mr-3 rtl:ml-3">
                        <!-- نجاح -->
                        <template x-if="notification.type === 'success'">
                            <div class="p-1.5 rounded-full bg-green-100 dark:bg-green-800">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </template>
                        
                        <!-- خطأ -->
                        <template x-if="notification.type === 'error'">
                            <div class="p-1.5 rounded-full bg-red-100 dark:bg-red-800">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                        </template>
                        
                        <!-- تحذير -->
                        <template x-if="notification.type === 'warning'">
                            <div class="p-1.5 rounded-full bg-yellow-100 dark:bg-yellow-800">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                        </template>
                        
                        <!-- معلومات -->
                        <template x-if="notification.type !== 'success' && notification.type !== 'error' && notification.type !== 'warning'">
                            <div class="p-1.5 rounded-full bg-blue-100 dark:bg-blue-800">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                        </template>
                    </div>
                    
                    <div class="flex-1 pt-0.5 w-0">
                        <p class="text-sm font-medium"
                            :class="{
                                'text-gray-900 dark:text-gray-100': notification.type !== 'error' && notification.type !== 'success' && notification.type !== 'warning',
                                'text-green-800 dark:text-green-100': notification.type === 'success', 
                                'text-red-800 dark:text-red-100': notification.type === 'error',
                                'text-yellow-800 dark:text-yellow-100': notification.type === 'warning'
                            }"
                        >
                            <span x-text="notification.message"></span>
                        </p>
                        <p x-show="notification.description" x-text="notification.description" class="mt-1 text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>
                    
                    <div class="flex flex-shrink-0 mr-0 ltr:ml-4 rtl:mr-4">
                        <button 
                            @click="remove(notification)"
                            class="inline-flex text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-full p-0.5"
                        >
                            <span class="sr-only">إغلاق</span>
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="notification.progress" class="h-1 bg-gray-200 dark:bg-gray-700">
                <div 
                    :class="{
                        'bg-indigo-500': notification.type !== 'error' && notification.type !== 'success' && notification.type !== 'warning',
                        'bg-green-500': notification.type === 'success', 
                        'bg-red-500': notification.type === 'error',
                        'bg-yellow-500': notification.type === 'warning'
                    }"
                    class="h-full transition-all ease-out duration-300"
                    :style="{ width: `${notification.progress || 100}%` }"
                ></div>
            </div>
        </div>
    </template>
</div>

<script>
    // إضافة طريقة عامة لإظهار الإشعارات من أي مكان في التطبيق
    window.showToast = function(options) {
        window.dispatchEvent(new CustomEvent('toast', { detail: options }));
    }
    
    // أمثلة لاستخدام الإشعارات من JavaScript
    // showToast({ type: 'success', message: 'تمت العملية بنجاح!' });
    // showToast({ type: 'error', message: 'حدث خطأ أثناء تنفيذ العملية.' });
    // showToast({ type: 'warning', message: 'تحذير: هذا الإجراء غير قابل للتراجع', timeout: 5000 });
    // showToast({ message: 'معلومة إضافية', description: 'هذا نص وصفي إضافي للمعلومة' });
</script> 