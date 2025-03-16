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
                        document.getElementById('map').innerHTML += '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert"><p>لا توجد مواقع لعرضها على الخريطة</p></div>';
                    }
                    
                    data.forEach((location, index) => {
                        console.log(`معالجة الموقع ${index}:`, location);
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
                            console.log(`تم إضافة علامة إعلان في الموقع: [${location.lat}, ${location.lng}]`);
                            
                            // محتوى النافذة المنبثقة للحملات التطوعية
                            popupContent = `
                                <div>
                                    <h3 class="font-bold text-lg">${location.title}</h3>
                                    <p>${location.description}</p>
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
                            console.log(`تم إضافة علامة منظمة في الموقع: [${location.lat}, ${location.lng}]`);
                            
                            // محتوى النافذة المنبثقة للمنظمات
                            popupContent = `
                                <div>
                                    <h3 class="font-bold text-lg">${location.title}</h3>
                                    <p>${location.description}</p>
                                    <a href="/organizations/${location.id}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">عرض التفاصيل</a>
                                </div>
                            `;
                        }
                        
                        marker.bindPopup(popupContent);
                        markers.addLayer(marker);
                    });
                    
                    map.addLayer(markers);
                    console.log('تم إضافة كل العلامات إلى الخريطة');
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                    document.getElementById('map').innerHTML += `
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                            <p class="font-bold">خطأ</p>
                            <p>${error.message}</p>
                        </div>
                    `;
                });
        });
    </script>
    @endpush
</x-app-layout> 