<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Ad;
use App\Models\Organization;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Get locations based on type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'all');
        $locations = [];

        switch ($type) {
            case 'ad':
                // الحصول على مواقع الحملات التطوعية
                $locations = $this->getAdLocations();
                break;
            case 'organization':
                // الحصول على مواقع المنظمات
                $locations = $this->getOrganizationLocations();
                break;
            case 'all':
            default:
                // الحصول على جميع المواقع
                $locations = array_merge(
                    $this->getAdLocations(),
                    $this->getOrganizationLocations()
                );
                break;
        }

        return response()->json($locations);
    }

    /**
     * Get ad locations.
     *
     * @return array
     */
    private function getAdLocations()
    {
        // Obtener anuncios que tienen ubicación
        $ads = Ad::with('location')->whereHas('location')->get();
        $locations = [];

        foreach ($ads as $ad) {
            if ($ad->location) {
                $locations[] = [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'description' => $ad->description,
                    'latitude' => $ad->location->latitude,
                    'longitude' => $ad->location->longitude,
                    'type' => 'ad',
                    'status' => $ad->status,
                    'goal_amount' => $ad->goal_amount,
                    'current_amount' => $ad->current_amount,
                ];
            }
        }

        return $locations;
    }

    /**
     * Get organization locations.
     *
     * @return array
     */
    private function getOrganizationLocations()
    {
        // Obtener organizaciones que tienen ubicación
        $organizations = Organization::with('location')->whereHas('location')->get();
        $locations = [];

        foreach ($organizations as $organization) {
            if ($organization->location) {
                $locations[] = [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'description' => $organization->description,
                    'latitude' => $organization->location->latitude,
                    'longitude' => $organization->location->longitude,
                    'type' => 'organization',
                    'verified' => $organization->verified,
                ];
            }
        }

        return $locations;
    }
}
