<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Http\Resources\AlertResource;
use Illuminate\Http\Request;

class UserDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy alerts theo severity
        $criticalAlerts = Alert::with(['address', 'creator'])
            ->where('severity', 'critical')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $highAlerts = Alert::with(['address', 'creator'])
            ->where('severity', 'high')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentAlerts = Alert::with(['address', 'creator'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Thống kê
        $stats = [
            'total_alerts' => Alert::count(),
            'critical_alerts' => Alert::where('severity', 'critical')->count(),
            'high_alerts' => Alert::where('severity', 'high')->count(),
            'medium_alerts' => Alert::where('severity', 'medium')->count(),
            'low_alerts' => Alert::where('severity', 'low')->count(),
            'active_disasters' => Alert::whereIn('type', ['storm', 'flood', 'earthquake', 'fire', 'other'])->count(),
        ];

        // Thống kê theo loại thiên tai
        $alertsByType = Alert::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        // Đảm bảo tất cả các loại thiên tai đều có trong mảng (kể cả khi count = 0)
        $allTypes = ['flood', 'storm', 'earthquake', 'fire', 'other'];
        foreach ($allTypes as $type) {
            if (!isset($alertsByType[$type])) {
                $alertsByType[$type] = 0;
            }
        }

        // Calculate user safety status based on nearby alerts
        $safetyStatus = 'safe';
        $nearbyAlerts = [];

        $user = auth()->user();
        $userAddresses = $user ? $user->addresses : collect();

        if ($userAddresses->count() > 0) {
            foreach ($userAddresses as $userAddress) {
                // Get all alerts with addresses
                $alerts = Alert::with('address')
                    ->whereHas('address')
                    ->get();
                
                foreach ($alerts as $alert) {
                    if ($alert->address) {
                        // Calculate distance using Haversine formula
                        $earthRadius = 6371000; // meters
                        
                        $lat1 = deg2rad($userAddress->latitude);
                        $lon1 = deg2rad($userAddress->longitude);
                        $lat2 = deg2rad($alert->address->latitude);
                        $lon2 = deg2rad($alert->address->longitude);
                        
                        $deltaLat = $lat2 - $lat1;
                        $deltaLon = $lon2 - $lon1;
                        
                        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
                             cos($lat1) * cos($lat2) *
                             sin($deltaLon / 2) * sin($deltaLon / 2);
                        
                        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                        $distance = $earthRadius * $c;
                        
                        $alertRadius = ($alert->radius ?? 500) + 1000; // Alert radius + 1km buffer
                        
                        if ($distance <= $alertRadius) {
                            $nearbyAlerts[] = [
                                'alert' => $alert,
                                'distance' => $distance
                            ];
                            
                            // Update safety status based on severity
                            if ($alert->severity === 'critical') {
                                $safetyStatus = 'dangerous';
                                break 2; // Exit both loops
                            } elseif ($alert->severity === 'high' && $safetyStatus !== 'dangerous') {
                                $safetyStatus = 'unsafe';
                            }
                        }
                    }
                }
            }
        }

        return view('dashboard', compact('criticalAlerts', 'highAlerts', 'recentAlerts', 'stats', 'alertsByType', 'safetyStatus', 'nearbyAlerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
