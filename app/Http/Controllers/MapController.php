<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Organization;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * عرض صفحة خريطة المواقع
     */
    public function index()
    {
        return view('map.index');
    }
    
    /**
     * جلب بيانات المواقع للخريطة
     */
    public function getLocations()
    {
        // استخدام مصفوفة ثابتة للاختبار
        $testLocations = [
            [
                'id' => 1,
                'title' => 'موقع تجريبي 1',
                'description' => 'هذا موقع تجريبي لاختبار الخريطة',
                'lat' => 35.0,
                'lng' => 38.0,
                'type' => 'ad'
            ],
            [
                'id' => 2,
                'title' => 'موقع تجريبي 2',
                'description' => 'هذا موقع تجريبي آخر لاختبار الخريطة',
                'lat' => 36.0,
                'lng' => 37.0,
                'type' => 'organization'
            ],
            [
                'id' => 3,
                'title' => 'موقع تجريبي 3',
                'description' => 'موقع تجريبي ثالث لاختبار الخريطة',
                'lat' => 34.0,
                'lng' => 36.0,
                'type' => 'ad'
            ]
        ];
        
        // إرجاع المواقع التجريبية كـ JSON
        return response()->json($testLocations);
    }

    /**
     * عرض صفحة المواقع المضافة سابقاً
     */
    public function savedLocations()
    {
        // جلب معلومات المواقع المضافة سابقاً
        $locations = $this->getSavedLocations();
        
        return view('map.saved', compact('locations'));
    }
    
    /**
     * جلب بيانات المواقع المضافة سابقاً
     */
    private function getSavedLocations()
    {
        // جلب مواقع الإعلانات
        $adLocations = DB::table('ads')
            ->join('locations', 'ads.location_id', '=', 'locations.id')
            ->select(
                'ads.id', 
                'ads.title', 
                'ads.description',
                'locations.latitude as lat', 
                'locations.longitude as lng', 
                DB::raw("'ad' as type")
            )
            ->get();
        
        // جلب مواقع المنظمات
        $orgLocations = DB::table('organizations')
            ->join('locations', 'organizations.location_id', '=', 'locations.id')
            ->select(
                'organizations.id', 
                'organizations.name as title', 
                'organizations.description',
                'locations.latitude as lat', 
                'locations.longitude as lng', 
                DB::raw("'organization' as type")
            )
            ->get();
        
        // دمج مجموعتي البيانات
        $allLocations = $adLocations->concat($orgLocations);
        
        return $allLocations;
    }
}
