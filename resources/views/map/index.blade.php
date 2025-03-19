<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('خريطة المواقع') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex justify-between items-center">
                        <h2 class="text-xl font-semibold">{{ __('خريطة تفاعلية') }}</h2>
                        <a href="{{ route('map.saved') }}" class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white px-4 py-2 rounded-md transition-colors">
                            {{ __('المواقع المضافة') }}
                        </a>
                    </div>
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .marker-cluster-small {
            background-color: rgba(181, 226, 140, 0.6);
        }
        .marker-cluster-small div {
            background-color: rgba(110, 204, 57, 0.6);
        }
        .marker-cluster-medium {
            background-color: rgba(241, 211, 87, 0.6);
        }
        .marker-cluster-medium div {
            background-color: rgba(240, 194, 12, 0.6);
        }
        .marker-cluster-large {
            background-color: rgba(253, 156, 115, 0.6);
        }
        .marker-cluster-large div {
            background-color: rgba(241, 128, 23, 0.6);
        }
        .marker-cluster {
            background-clip: padding-box;
            border-radius: 20px;
        }
        .marker-cluster div {
            width: 30px;
            height: 30px;
            margin-left: 5px;
            margin-top: 5px;
            text-align: center;
            border-radius: 15px;
            font: 12px "Helvetica Neue", Arial, Helvetica, sans-serif;
        }
        .marker-cluster span {
            line-height: 30px;
        }
        
        /* تنسيقات الوضع الداكن للخريطة */
        @media (prefers-color-scheme: dark) {
            .leaflet-tile {
                filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7) !important;
            }
            .leaflet-container {
                background: #303030 !important;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إنشاء خريطة مع تركيز على سوريا
            const map = L.map('map').setView([35.0, 38.0], 7);
            console.log('تم إنشاء الخريطة');

            // إضافة طبقة الخريطة
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            console.log('تم إضافة طبقة الخريطة');

            // إنشاء مجموعات للعلامات
            const markers = L.markerClusterGroup();
            
            // الحصول على البيانات من API
            console.log('جاري الاتصال بـ API على العنوان:', '/api/locations');
            fetch('/api/locations')
                .then(response => {
                    console.log('تم استلام الرد:', response.status);
                    if (!response.ok) {
                        throw new Error('فشل الاتصال بواجهة برمجة التطبيقات: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('تم استلام البيانات:', data);
                    console.log('عدد المواقع:', data.length);
                    
                    if (data.length === 0) {
                        document.getElementById('map').innerHTML += '<div class="bg-yellow-100 dark:bg-yellow-800/30 border-l-4 border-yellow-500 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 p-4" role="alert"><p>لا توجد مواقع لعرضها على الخريطة</p></div>';
                    }
                    
                    data.forEach((location, index) => {
                        console.log(`معالجة الموقع ${index}:`, location);
                        
                        // تحقق من صحة الإحداثيات
                        if (!location.latitude || !location.longitude) {
                            console.warn(`تم تخطي الموقع ${index} لعدم وجود إحداثيات صالحة:`, location);
                            return;
                        }
                        
                        // إنشاء علامة
                        const marker = L.marker([location.latitude, location.longitude]);
                        
                        // إضافة نافذة منبثقة
                        const popupContent = `
                            <div class="popup-content">
                                <h3 class="text-lg font-bold mb-1">${location.name || 'موقع بدون اسم'}</h3>
                                ${location.address ? `<p class="text-sm mb-2">${location.address}</p>` : ''}
                                ${location.description ? `<p class="text-sm text-gray-600">${location.description}</p>` : ''}
                                <div class="mt-3">
                                    <a href="/locations/${location.id}" class="text-blue-500 hover:text-blue-700 text-sm">عرض التفاصيل</a>
                                </div>
                            </div>
                        `;
                        
                        marker.bindPopup(popupContent);
                        
                        // إضافة العلامة إلى المجموعة
                        markers.addLayer(marker);
                    });
                    
                    // إضافة المجموعة إلى الخريطة
                    map.addLayer(markers);
                    console.log('تمت إضافة العلامات إلى الخريطة');
                })
                .catch(error => {
                    console.error('حدث خطأ:', error);
                    document.getElementById('map').innerHTML += `<div class="bg-red-100 dark:bg-red-800/30 border-l-4 border-red-500 dark:border-red-600 text-red-700 dark:text-red-300 p-4" role="alert"><p>حدث خطأ أثناء تحميل بيانات الخريطة: ${error.message}</p></div>`;
                });
                
            // إضافة زر لإضافة موقع جديد
            const addLocationBtn = L.control({position: 'topleft'});
            addLocationBtn.onAdd = function() {
                const button = L.DomUtil.create('button', 'bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white px-3 py-2 rounded-md shadow-md');
                button.innerHTML = '<i class="fas fa-plus ml-1"></i> إضافة موقع';
                button.style.margin = '10px';
                
                button.onclick = function() {
                    window.location.href = '{{ route("locations.create") }}';
                }
                
                return button;
            }
            
            addLocationBtn.addTo(map);
            
            // تعديل النمط ليناسب الوضع الداكن
            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (isDarkMode) {
                document.querySelectorAll('.leaflet-tile').forEach(tile => {
                    tile.style.filter = 'brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7)';
                });
            }
            
            // استمع للتغييرات في وضع العرض
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                const isDarkMode = e.matches;
                document.querySelectorAll('.leaflet-tile').forEach(tile => {
                    tile.style.filter = isDarkMode ? 
                        'brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) saturate(0.3) brightness(0.7)' : 
                        '';
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 