<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-right">
            {{ __('الإشعارات') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 rtl" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Notification Controls -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('كل الإشعارات') }}
                    </div>
                    <button id="mark-all-read" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md">
                        <i class="fas fa-check-double ml-1"></i> {{ __('تعليم الكل كمقروء') }}
                    </button>
                </div>

                <!-- Notification Filters -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex overflow-x-auto">
                    <button class="px-4 py-2 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-100 font-medium ml-2">{{ __('الكل') }}</button>
                    <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium hover:bg-indigo-100 hover:text-indigo-800 dark:hover:bg-indigo-700 dark:hover:text-indigo-100 ml-2">{{ __('غير مقروء') }}</button>
                    <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium hover:bg-indigo-100 hover:text-indigo-800 dark:hover:bg-indigo-700 dark:hover:text-indigo-100 ml-2">{{ __('اليوم') }}</button>
                    <button class="px-4 py-2 rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300 font-medium hover:bg-indigo-100 hover:text-indigo-800 dark:hover:bg-indigo-700 dark:hover:text-indigo-100">{{ __('هذا الأسبوع') }}</button>
                </div>

                <!-- Notifications List -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if(count($combinedNotifications) > 0)
                        @foreach($combinedNotifications as $notification)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out {{ !isset($notification->read_at) && !($notification->is_read ?? false) ? 'border-r-4 border-indigo-500' : '' }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 ml-4">
                                        @php
                                            $type = $notification->type ?? 'default';
                                            $iconClass = match ($type) {
                                                'success', 'donation_thanks' => 'fas fa-check text-green-600 dark:text-green-400',
                                                'error' => 'fas fa-exclamation-circle text-red-600 dark:text-red-400',
                                                'warning' => 'fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400',
                                                'donation', 'donation_received' => 'fas fa-donate text-blue-600 dark:text-blue-400',
                                                'badge' => 'fas fa-medal text-yellow-600 dark:text-yellow-400',
                                                'participation' => 'fas fa-handshake text-indigo-600 dark:text-indigo-400',
                                                default => 'fas fa-bell text-gray-600 dark:text-gray-400',
                                            };
                                            $bgClass = match ($type) {
                                                'success', 'donation_thanks' => 'bg-green-100 dark:bg-green-800',
                                                'error' => 'bg-red-100 dark:bg-red-800',
                                                'warning' => 'bg-yellow-100 dark:bg-yellow-800',
                                                'donation', 'donation_received' => 'bg-blue-100 dark:bg-blue-800',
                                                'badge' => 'bg-yellow-100 dark:bg-yellow-800',
                                                'participation' => 'bg-indigo-100 dark:bg-indigo-800',
                                                default => 'bg-gray-100 dark:bg-gray-800',
                                            };
                                        @endphp
                                        <div class="h-12 w-12 rounded-full {{ $bgClass }} flex items-center justify-center">
                                            <i class="{{ $iconClass }} text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $notification->data['message'] ?? $notification->message ?? 'إشعار' }}
                                            </p>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        
                                        @if(isset($notification->data['ad_title']) || isset($notification->data['job_title']))
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $notification->data['ad_title'] ?? $notification->data['job_title'] ?? '' }}
                                            </p>
                                        @endif
                                        
                                        @if(isset($notification->data['amount']))
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                المبلغ: {{ $notification->data['amount'] }} ل.س
                                            </p>
                                        @endif
                                        
                                        <div class="mt-2 flex items-center">
                                            @if(isset($notification->data['ad_id']))
                                                <a href="{{ route('ads.show', $notification->data['ad_id']) }}" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 ml-4">
                                                    <i class="fas fa-eye ml-1"></i> عرض الحملة
                                                </a>
                                            @endif
                                            
                                            @if(isset($notification->data['job_id']))
                                                <a href="{{ route('job-offers.show', $notification->data['job_id']) }}" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 ml-4">
                                                    <i class="fas fa-eye ml-1"></i> عرض الفرصة
                                                </a>
                                            @endif
                                            
                                            @if(!isset($notification->read_at) && !($notification->is_read ?? false))
                                                <button 
                                                    class="mark-as-read text-xs font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                                                    data-id="{{ $notification->id }}"
                                                    data-type="{{ $notification instanceof \Illuminate\Notifications\DatabaseNotification ? 'database' : 'custom' }}"
                                                >
                                                    <i class="fas fa-check-circle ml-1"></i> تعليم كمقروء
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                            <p>{{ __('لا توجد إشعارات') }}</p>
                        </div>
                    @endif
                </div>
                
                <!-- Pagination -->
                <div class="p-4">
                    {{ $combinedNotifications->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark as read functionality
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    
                    fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ type: type })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Change the appearance of the notification
                            this.closest('div.border-r-4')?.classList.remove('border-r-4', 'border-indigo-500');
                            this.remove(); // Remove the mark as read button
                        }
                    });
                });
            });
            
            // Mark all as read functionality
            document.getElementById('mark-all-read').addEventListener('click', function() {
                fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Refresh the page to reflect changes
                        window.location.reload();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 