/**
 * مكتبة خرائط لعرض المواقع في سوريا
 * Map library for displaying locations in Syria
 */

// تهيئة الخريطة
function initMap(elementId, latitude = 35.2, longitude = 38.6, zoom = 7) {
    // إنشاء خريطة في العنصر المحدد
    const map = L.map(elementId).setView([latitude, longitude], zoom);

    // إضافة طبقة الخريطة من OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    return map;
}

// إضافة علامة على الخريطة
function addMarker(map, latitude, longitude, title, popupContent = null) {
    const marker = L.marker([latitude, longitude]).addTo(map);
    
    if (title) {
        marker.bindTooltip(title);
    }
    
    if (popupContent) {
        marker.bindPopup(popupContent);
    }
    
    return marker;
}

// إضافة مواقع متعددة على الخريطة
function addLocations(map, locations) {
    const markers = [];
    
    locations.forEach(location => {
        const marker = addMarker(
            map, 
            location.latitude, 
            location.longitude, 
            location.title, 
            location.popupContent
        );
        markers.push(marker);
    });
    
    // ضبط الخريطة لتظهر جميع العلامات
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
    
    return markers;
}

// إضافة مواقع المدن السورية الرئيسية
function addSyrianCities(map) {
    const syrianCities = [
        { latitude: 33.5138, longitude: 36.2765, title: "دمشق", popupContent: "<b>دمشق</b><br>عاصمة سوريا" },
        { latitude: 36.2021, longitude: 37.1343, title: "حلب", popupContent: "<b>حلب</b><br>أكبر مدينة في سوريا" },
        { latitude: 34.7324, longitude: 36.7137, title: "حمص", popupContent: "<b>حمص</b>" },
        { latitude: 35.1359, longitude: 36.7594, title: "حماة", popupContent: "<b>حماة</b>" },
        { latitude: 35.9359, longitude: 39.0118, title: "الرقة", popupContent: "<b>الرقة</b>" },
        { latitude: 35.0178, longitude: 38.7584, title: "تدمر", popupContent: "<b>تدمر</b>" },
        { latitude: 35.5296, longitude: 35.7956, title: "اللاذقية", popupContent: "<b>اللاذقية</b>" },
        { latitude: 34.8867, longitude: 35.8853, title: "طرطوس", popupContent: "<b>طرطوس</b>" },
        { latitude: 32.6245, longitude: 36.1045, title: "درعا", popupContent: "<b>درعا</b>" },
        { latitude: 35.9306, longitude: 36.6348, title: "إدلب", popupContent: "<b>إدلب</b>" },
        { latitude: 35.3359, longitude: 40.1408, title: "دير الزور", popupContent: "<b>دير الزور</b>" }
    ];
    
    return addLocations(map, syrianCities);
}

// تحميل مواقع من قاعدة البيانات
function loadLocationsFromDatabase(map, url, type = 'all') {
    fetch(url + '?type=' + type)
        .then(response => response.json())
        .then(data => {
            const locations = data.map(item => ({
                latitude: parseFloat(item.latitude),
                longitude: parseFloat(item.longitude),
                title: item.title || item.name,
                popupContent: createPopupContent(item, type)
            }));
            
            addLocations(map, locations);
        })
        .catch(error => console.error('Error loading locations:', error));
}

// إنشاء محتوى النافذة المنبثقة حسب نوع الموقع
function createPopupContent(item, type) {
    let content = `<div class="popup-content">`;
    
    if (type === 'ad' || type === 'all') {
        content += `<h3>${item.title}</h3>`;
        if (item.description) {
            content += `<p>${item.description.substring(0, 100)}...</p>`;
        }
        content += `<a href="/ads/${item.id}" class="btn btn-primary btn-sm">عرض الحملة</a>`;
    } else if (type === 'organization') {
        content += `<h3>${item.name}</h3>`;
        if (item.description) {
            content += `<p>${item.description.substring(0, 100)}...</p>`;
        }
        content += `<a href="/organizations/${item.id}" class="btn btn-primary btn-sm">عرض المنظمة</a>`;
    }
    
    content += `</div>`;
    return content;
}

// تصدير الدوال للاستخدام العام
window.SyriaMap = {
    initMap,
    addMarker,
    addLocations,
    addSyrianCities,
    loadLocationsFromDatabase
}; 