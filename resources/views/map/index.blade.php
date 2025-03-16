<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('خريطة المواقع') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
    </style>
    @endpush

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إنشاء خريطة مع تركيز على سوريا
            const map = L.map('map').setView([35.0, 38.0], 7);

            // إضافة طبقة الخريطة
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // إنشاء مجموعات للعلامات
            const markers = L.markerClusterGroup();
            
            // الحصول على البيانات من API
            fetch('/api/locations')
                .then(response => response.json())
                .then(data => {
                    data.forEach(location => {
                        let marker;
                        let popupContent = '';
                        
                        // تخصيص المحتوى حسب نوع الموقع
                        if (location.type === 'ad') {
                            // أيقونة للحملات التطوعية
                            const adIcon = L.divIcon({
                                html: `<div style="background-color: #4CAF50; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;"><i class="fas fa-hand-holding-heart"></i></div>`,
                                className: 'custom-div-icon',
                                iconSize: [30, 30],
                                iconAnchor: [15, 15]
                            });
                            
                            marker = L.marker([location.lat, location.lng], { icon: adIcon });
                            
                            // محتوى النافذة المنبثقة للحملات التطوعية
                            popupContent = `
                                <div>
                                    <h3 class="font-bold text-lg">${location.title}</h3>
                                    <p>${location.description}</p>
                                    <div class="mt-2">
                                        <div class="bg-gray-200 rounded-full h-2.5 mb-1">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${(location.current_amount / location.goal_amount) * 100}%"></div>
                                        </div>
                                        <p class="text-sm">${location.current_amount} / ${location.goal_amount}</p>
                                    </div>
                                    <a href="/ads/${location.id}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">عرض التفاصيل</a>
                                </div>
                            `;
                        } else if (location.type === 'organization') {
                            // أيقونة للمنظمات
                            const orgIcon = L.divIcon({
                                html: `<div style="background-color: #2196F3; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;"><i class="fas fa-building"></i></div>`,
                                className: 'custom-div-icon',
                                iconSize: [30, 30],
                                iconAnchor: [15, 15]
                            });
                            
                            marker = L.marker([location.lat, location.lng], { icon: orgIcon });
                            
                            // محتوى النافذة المنبثقة للمنظمات
                            const verifiedBadge = location.verified 
                                ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">موثق</span>' 
                                : '';
                                
                            popupContent = `
                                <div>
                                    <h3 class="font-bold text-lg">${location.name} ${verifiedBadge}</h3>
                                    <p>${location.description}</p>
                                    <a href="/organizations/${location.id}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">عرض التفاصيل</a>
                                </div>
                            `;
                        }
                        
                        marker.bindPopup(popupContent);
                        markers.addLayer(marker);
                    });
                    
                    map.addLayer(markers);
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                });
        });
    </script>
    @endpush
</x-app-layout> 