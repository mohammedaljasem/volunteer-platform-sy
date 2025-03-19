import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Notification functions
document.addEventListener('DOMContentLoaded', function() {
    // Notifications dropdown functionality
    const notificationsDropdown = document.querySelector('#notifications-container');
    const notificationBadge = document.querySelector('#notification-badge');
    const markAllReadBtn = document.querySelector('#mark-all-read-dropdown');
    
    // Only initialize if the notifications dropdown exists
    if (notificationsDropdown) {
        let currentFilter = 'all';
        let notificationsData = null;
        
        // Load notifications when dropdown opens
        document.addEventListener('dropdown-opened', function(event) {
            if (event.detail && event.detail.dropdown === 'notifications') {
                loadNotifications();
            }
        });
        
        // Load notifications function
        function loadNotifications() {
            const loadingEl = document.querySelector('#notifications-loading');
            const groupsEl = document.querySelector('#notification-groups');
            const noNotificationsEl = document.querySelector('#no-notifications');
            
            loadingEl.classList.remove('hidden');
            groupsEl.classList.add('hidden');
            noNotificationsEl.classList.add('hidden');
            
            fetch('/notifications/data')
                .then(response => response.json())
                .then(data => {
                    notificationsData = data;
                    
                    // Update badge count
                    if (data.unreadCount > 0) {
                        notificationBadge.textContent = data.unreadCount;
                        notificationBadge.style.display = '';
                    } else {
                        notificationBadge.style.display = 'none';
                    }
                    
                    // Render notifications
                    renderNotifications(data, currentFilter);
                    
                    loadingEl.classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    loadingEl.classList.add('hidden');
                    noNotificationsEl.classList.remove('hidden');
                });
        }
        
        // Render notifications based on the filter
        function renderNotifications(data, filter) {
            const groupsEl = document.querySelector('#notification-groups');
            const noNotificationsEl = document.querySelector('#no-notifications');
            
            // Clear previous content
            groupsEl.innerHTML = '';
            
            let hasNotifications = false;
            
            // Process notification groups
            const groups = {
                'today': { label: 'اليوم', notifications: data.notifications.today },
                'yesterday': { label: 'الأمس', notifications: data.notifications.yesterday },
                'thisWeek': { label: 'هذا الأسبوع', notifications: data.notifications.thisWeek },
                'older': { label: 'سابقاً', notifications: data.notifications.older }
            };
            
            // Filter notifications if needed
            if (filter === 'unread') {
                Object.keys(groups).forEach(key => {
                    groups[key].notifications = groups[key].notifications.filter(notification => 
                        !notification.read_at && !(notification.is_read === true)
                    );
                });
            } else if (filter === 'today') {
                // Keep only today's notifications
                groups.yesterday.notifications = [];
                groups.thisWeek.notifications = [];
                groups.older.notifications = [];
            }
            
            // Render each group
            Object.keys(groups).forEach(key => {
                const group = groups[key];
                
                if (group.notifications.length > 0) {
                    hasNotifications = true;
                    
                    // Create group container
                    const groupDiv = document.createElement('div');
                    
                    // Create group header
                    const headerDiv = document.createElement('div');
                    headerDiv.className = 'px-4 py-2 bg-gray-50 dark:bg-gray-800 text-xs text-gray-500 dark:text-gray-400 font-medium';
                    headerDiv.textContent = group.label;
                    groupDiv.appendChild(headerDiv);
                    
                    // Create notification items
                    group.notifications.forEach(notification => {
                        const isUnread = !notification.read_at && !(notification.is_read === true);
                        const notificationType = notification.type || (notification.data && notification.data.type) || 'default';
                        
                        // Create notification link
                        const notificationLink = document.createElement('a');
                        notificationLink.href = '#';
                        notificationLink.className = `block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out ${isUnread ? 'border-r-4 border-indigo-500' : ''}`;
                        
                        // Create notification content
                        const content = createNotificationContent(notification, isUnread);
                        notificationLink.appendChild(content);
                        
                        groupDiv.appendChild(notificationLink);
                    });
                    
                    groupsEl.appendChild(groupDiv);
                }
            });
            
            if (hasNotifications) {
                groupsEl.classList.remove('hidden');
                noNotificationsEl.classList.add('hidden');
            } else {
                groupsEl.classList.add('hidden');
                noNotificationsEl.classList.remove('hidden');
            }
        }
        
        // Create notification content element
        function createNotificationContent(notification, isUnread) {
            const containerDiv = document.createElement('div');
            containerDiv.className = 'flex';
            
            // Icon container
            const iconContainer = document.createElement('div');
            iconContainer.className = 'flex-shrink-0 ml-3';
            
            const iconDiv = document.createElement('div');
            iconDiv.className = 'h-10 w-10 rounded-full flex items-center justify-center';
            
            // Determine notification type and set appropriate icon/color
            const type = notification.type || (notification.data && notification.data.type) || 'default';
            
            let iconClass, bgClass;
            
            switch (type) {
                case 'success':
                case 'donation_thanks':
                    iconClass = 'fas fa-check text-green-600 dark:text-green-300';
                    bgClass = 'bg-green-100 dark:bg-green-800';
                    break;
                case 'error':
                    iconClass = 'fas fa-exclamation-circle text-red-600 dark:text-red-300';
                    bgClass = 'bg-red-100 dark:bg-red-800';
                    break;
                case 'warning':
                    iconClass = 'fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-300';
                    bgClass = 'bg-yellow-100 dark:bg-yellow-800';
                    break;
                case 'donation':
                case 'donation_received':
                    iconClass = 'fas fa-donate text-blue-600 dark:text-blue-300';
                    bgClass = 'bg-blue-100 dark:bg-blue-800';
                    break;
                case 'badge':
                    iconClass = 'fas fa-medal text-yellow-600 dark:text-yellow-300';
                    bgClass = 'bg-yellow-100 dark:bg-yellow-800';
                    break;
                default:
                    iconClass = 'fas fa-bell text-gray-600 dark:text-gray-300';
                    bgClass = 'bg-gray-100 dark:bg-gray-800';
            }
            
            iconDiv.className += ` ${bgClass}`;
            
            const icon = document.createElement('i');
            icon.className = iconClass;
            
            iconDiv.appendChild(icon);
            iconContainer.appendChild(iconDiv);
            
            // Content container
            const contentDiv = document.createElement('div');
            contentDiv.className = 'flex-1';
            
            // Message
            const message = document.createElement('p');
            message.className = 'text-sm font-medium text-gray-900 dark:text-gray-100';
            message.textContent = notification.data && notification.data.message ? notification.data.message : (notification.message || 'إشعار');
            contentDiv.appendChild(message);
            
            // Description if available
            if (notification.data && notification.data.description) {
                const description = document.createElement('p');
                description.className = 'text-xs text-gray-500 dark:text-gray-400';
                description.textContent = notification.data.description;
                contentDiv.appendChild(description);
            }
            
            // Time
            const time = document.createElement('p');
            time.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
            
            // Format the time
            const createdAt = new Date(notification.created_at);
            const now = new Date();
            const diffMs = now - createdAt;
            const diffMins = Math.round(diffMs / 60000);
            const diffHours = Math.round(diffMs / 3600000);
            const diffDays = Math.round(diffMs / 86400000);
            
            if (diffMins < 60) {
                time.textContent = `منذ ${diffMins} دقيقة`;
            } else if (diffHours < 24) {
                time.textContent = `منذ ${diffHours} ساعة`;
            } else {
                time.textContent = `منذ ${diffDays} يوم`;
            }
            
            contentDiv.appendChild(time);
            
            // Mark as read button for unread notifications
            if (isUnread) {
                const actionsDiv = document.createElement('div');
                actionsDiv.className = 'self-center';
                
                const markReadBtn = document.createElement('button');
                markReadBtn.className = 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200';
                markReadBtn.title = 'تعليم كمقروء';
                markReadBtn.setAttribute('data-id', notification.id);
                markReadBtn.setAttribute('data-type', notification.read_at !== undefined ? 'database' : 'custom');
                
                markReadBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    markAsRead(notification.id, notification.read_at !== undefined ? 'database' : 'custom');
                });
                
                const btnIcon = document.createElement('i');
                btnIcon.className = 'fas fa-circle text-xs';
                markReadBtn.appendChild(btnIcon);
                
                actionsDiv.appendChild(markReadBtn);
                containerDiv.appendChild(actionsDiv);
            }
            
            containerDiv.appendChild(iconContainer);
            containerDiv.appendChild(contentDiv);
            
            return containerDiv;
        }
        
        // Mark notification as read
        function markAsRead(id, type) {
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
                    // Reload notifications to update UI
                    loadNotifications();
                }
            });
        }
        
        // Mark all notifications as read
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
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
                        // Reload notifications to update UI
                        loadNotifications();
                    }
                });
            });
        }
        
        // Filter buttons
        document.querySelectorAll('.notification-filter').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active filter styling
                document.querySelectorAll('.notification-filter').forEach(btn => {
                    btn.classList.remove('bg-indigo-100', 'text-indigo-800', 'dark:bg-indigo-700', 'dark:text-indigo-100');
                    btn.classList.add('bg-gray-100', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-300');
                });
                
                this.classList.remove('bg-gray-100', 'text-gray-600', 'dark:bg-gray-700', 'dark:text-gray-300');
                this.classList.add('bg-indigo-100', 'text-indigo-800', 'dark:bg-indigo-700', 'dark:text-indigo-100');
                
                // Update current filter and re-render
                currentFilter = filter;
                if (notificationsData) {
                    renderNotifications(notificationsData, currentFilter);
                }
            });
        });
    }
});
