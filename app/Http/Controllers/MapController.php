<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MapController extends Controller
{
    /**
     * Mostrar la vista del mapa con las ubicaciones.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('map.index');
    }

    /**
     * استرجاع بيانات المواقع للخريطة
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocations()
    {
        $locations = new Collection();

        // جلب مواقع الحملات التطوعية (الإعلانات)
        $adLocations = Ad::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select('id', 'title', 'description', 'latitude', 'longitude', 'image')
            ->get()
            ->map(function ($ad) {
                return [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'description' => $ad->description,
                    'lat' => (float) $ad->latitude,
                    'lng' => (float) $ad->longitude,
                    'image' => $ad->image,
                    'type' => 'ad'
                ];
            });

        $locations = $locations->concat($adLocations);

        // جلب مواقع المنظمات
        $orgLocations = Organization::whereHas('location', function ($query) {
                $query->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->with('location')
            ->get()
            ->map(function ($org) {
                return [
                    'id' => $org->id,
                    'title' => $org->name,
                    'description' => $org->description,
                    'lat' => (float) $org->location->latitude,
                    'lng' => (float) $org->location->longitude,
                    'type' => 'organization'
                ];
            });

        $locations = $locations->concat($orgLocations);

        return response()->json($locations);
    }
}
