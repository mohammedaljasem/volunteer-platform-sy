<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('خريطة المواقع') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">{{ __('المواقع المضافة') }}</h1>
                        <a href="{{ route('map') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                            {{ __('عرض الخريطة الكاملة') }}
                        </a>
                    </div>

                    <div class="mb-6">
                        <div class="flex flex-wrap space-x-4 space-x-reverse mb-4">
                            <button id="show-all" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 mb-2">
                                {{ __('عرض الكل') }}
                            </button>
                            <button id="show-ads" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 mb-2">
                                {{ __('حملات التبرع') }}
                            </button>
                            <button id="show-organizations" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 mb-2">
                                {{ __('المنظمات') }}
                            </button>
                        </div>
                    </div>
                    
                    <div id="map" style="height: 500px; width: 100%;" class="rounded-lg border border-gray-300 shadow-md"></div>

                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">{{ __('قائمة المواقع المضافة') }}</h2>
                        
                        @if($locations->isEmpty())
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                <p class="text-yellow-700">{{ __('لا توجد مواقع مضافة حالياً') }}</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                                @foreach($locations as $location)
                                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-4">
                                        <div class="flex items-center mb-2">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-2 
                                                {{ $location->type == 'ad' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                                <i class="fas {{ $location->type == 'ad' ? 'fa-hand-holding-heart' : 'fa-building' }}"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $location->title }}</h3>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($location->description, 100) }}</p>
                                        
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                {{ $location->type == 'ad' ? __('حملة تبرع') : __('منظمة') }}
                                            </span>
                                            <a href="#" 
                                               class="text-blue-600 hover:text-blue-800 text-sm view-on-map"
                                               data-lat="{{ $location->lat }}"
                                               data-lng="{{ $location->lng }}"
                                               data-title="{{ $location->title }}">
                                                {{ __('عرض على الخريطة') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
        crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        .popup-content h3 {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .popup-content p {
            margin-bottom: 0.5rem;
        }
        .popup-content .btn {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0.25rem;
            text-decoration: none;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .popup-content .btn:hover {
            background-color: #2563eb;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة الخريطة مع تركيز على سوريا
            const map = L.map('map').setView([35.0, 38.0], 7);
            
            // إضافة طبقة الخريطة
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            // تخزين جميع العلامات
            const allMarkers = [];
            const adMarkers = [];
            const orgMarkers = [];
            
            // إعداد البيانات من الـ Blade
            const locations = <?php echo json_encode($locations); ?>;
            
            // إضافة العلامات للخريطة
            locations.forEach(location => {
                let marker;
                let icon;
                
                // تخصيص الأيقونة حسب النوع
                if (location.type === 'ad') {
                    icon = L.divIcon({
                        html: `<div style="background-color: #4CAF50; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; font-weight: bold;">D</div>`,
                        className: 'custom-div-icon',
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });
                } else {
                    icon = L.divIcon({
                        html: `<div style="background-color: #FFB100; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; font-weight: bold;">O</div>`,
                        className: 'custom-div-icon',
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });
                }
                
                // إنشاء العلامة
                marker = L.marker([location.lat, location.lng], { icon: icon });
                
                // إضافة النافذة المنبثقة
                const popupContent = `
                    <div class="popup-content">
                        <h3>${location.title}</h3>
                        <p>${location.description}</p>
                        <a href="${location.type === 'ad' ? '/ads/' + location.id : '/organizations/' + location.id}" class="btn">عرض التفاصيل</a>
                    </div>
                `;
                marker.bindPopup(popupContent);
                
                // إضافة العلامة إلى المجموعة المناسبة
                if (location.type === 'ad') {
                    adMarkers.push(marker);
                } else {
                    orgMarkers.push(marker);
                }
                
                // إضافة العلامة إلى مجموعة الكل
                allMarkers.push(marker);
                
                // إضافة العلامة إلى الخريطة
                marker.addTo(map);
            });
            
            // إعداد الأزرار
            document.getElementById('show-all').addEventListener('click', function() {
                // إزالة جميع العلامات
                clearAllMarkers();
                
                // إضافة جميع العلامات
                allMarkers.forEach(marker => marker.addTo(map));
                
                // التركيز على جميع العلامات إذا وجدت
                if (allMarkers.length > 0) {
                    const group = new L.featureGroup(allMarkers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            });
            
            document.getElementById('show-ads').addEventListener('click', function() {
                // إزالة جميع العلامات
                clearAllMarkers();
                
                // إضافة علامات الحملات
                adMarkers.forEach(marker => marker.addTo(map));
                
                // التركيز على علامات الحملات إذا وجدت
                if (adMarkers.length > 0) {
                    const group = new L.featureGroup(adMarkers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            });
            
            document.getElementById('show-organizations').addEventListener('click', function() {
                // إزالة جميع العلامات
                clearAllMarkers();
                
                // إضافة علامات المنظمات
                orgMarkers.forEach(marker => marker.addTo(map));
                
                // التركيز على علامات المنظمات إذا وجدت
                if (orgMarkers.length > 0) {
                    const group = new L.featureGroup(orgMarkers);
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            });
            
            // إضافة معالج نقر للروابط "عرض على الخريطة"
            document.querySelectorAll('.view-on-map').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const lat = parseFloat(this.getAttribute('data-lat'));
                    const lng = parseFloat(this.getAttribute('data-lng'));
                    const title = this.getAttribute('data-title');
                    
                    // التركيز على الموقع
                    map.setView([lat, lng], 12);
                    
                    // العثور على العلامة المناسبة وفتح النافذة المنبثقة
                    allMarkers.forEach(marker => {
                        const latLng = marker.getLatLng();
                        if (latLng.lat === lat && latLng.lng === lng) {
                            marker.openPopup();
                        }
                    });
                });
            });
            
            // وظيفة لإزالة جميع العلامات من الخريطة
            function clearAllMarkers() {
                allMarkers.forEach(marker => {
                    if (map.hasLayer(marker)) {
                        map.removeLayer(marker);
                    }
                });
            }
            
            // إذا كانت هناك علامات، ضبط الخريطة لتظهر جميع العلامات
            if (allMarkers.length > 0) {
                const group = new L.featureGroup(allMarkers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>
    @endpush
</x-app-layout> 