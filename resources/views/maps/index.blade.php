<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('خريطة المواقع') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <div class="flex space-x-4 space-x-reverse">
                            <button id="show-all" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                {{ __('عرض الكل') }}
                            </button>
                            <button id="show-ads" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                {{ __('حملات التبرع') }}
                            </button>
                            <button id="show-organizations" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                {{ __('المنظمات') }}
                            </button>
                            <button id="show-cities" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                {{ __('المدن السورية') }}
                            </button>
                        </div>
                    </div>
                    
                    <div id="map" style="height: 600px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
        crossorigin="" />
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
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة الخريطة
            const map = SyriaMap.initMap('map');
            let cityMarkers = [];
            let dataMarkers = [];
            
            // أزرار التحكم
            document.getElementById('show-all').addEventListener('click', function() {
                clearMarkers();
                loadAllLocations();
                cityMarkers = SyriaMap.addSyrianCities(map);
            });
            
            document.getElementById('show-ads').addEventListener('click', function() {
                clearMarkers();
                SyriaMap.loadLocationsFromDatabase(map, '/api/locations', 'ad');
            });
            
            document.getElementById('show-organizations').addEventListener('click', function() {
                clearMarkers();
                SyriaMap.loadLocationsFromDatabase(map, '/api/locations', 'organization');
            });
            
            document.getElementById('show-cities').addEventListener('click', function() {
                clearMarkers();
                cityMarkers = SyriaMap.addSyrianCities(map);
            });
            
            // تحميل جميع المواقع
            function loadAllLocations() {
                SyriaMap.loadLocationsFromDatabase(map, '/api/locations', 'all');
            }
            
            // إزالة جميع العلامات
            function clearMarkers() {
                // إزالة علامات المدن
                if (cityMarkers.length > 0) {
                    cityMarkers.forEach(marker => map.removeLayer(marker));
                    cityMarkers = [];
                }
                
                // إزالة علامات البيانات
                if (dataMarkers.length > 0) {
                    dataMarkers.forEach(marker => map.removeLayer(marker));
                    dataMarkers = [];
                }
            }
            
            // تحميل المدن السورية افتراضيًا
            cityMarkers = SyriaMap.addSyrianCities(map);
        });
    </script>
    @endpush
</x-app-layout> 