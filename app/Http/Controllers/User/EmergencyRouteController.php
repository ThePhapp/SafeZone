<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shelter;
use Illuminate\Http\Request;

class EmergencyRouteController extends Controller
{
    public function index()
    {
        $shelters = Shelter::where('status', 'active')->get();
        return view('user.emergency-routes', compact('shelters'));
    }

    public function findNearest(Request $request)
    {
        try {
            $lat = $request->latitude;
            $lng = $request->longitude;

            if (!$lat || !$lng) {
                return response()->json(['error' => 'Invalid coordinates'], 400);
            }

            // Tìm shelter gần nhất sử dụng công thức Haversine
            $shelters = Shelter::where('status', 'active')
                ->selectRaw("
                    *,
                    (6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    )) AS distance
                ", [$lat, $lng, $lat])
                ->orderBy('distance')
                ->limit(5)
                ->get();

            return response()->json(['shelters' => $shelters]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
