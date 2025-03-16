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
}
