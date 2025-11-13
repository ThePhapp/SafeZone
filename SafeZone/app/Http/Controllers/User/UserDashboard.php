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
        $criticalAlerts = AlertResource::collection(
            Alert::with(['address', 'creator'])
                ->where('severity', 'critical')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        );

        $highAlerts = AlertResource::collection(
            Alert::with(['address', 'creator'])
                ->where('severity', 'high')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        );

        $recentAlerts = AlertResource::collection(
            Alert::with(['address', 'creator'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
        );

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

        return view('dashboard', compact('criticalAlerts', 'highAlerts', 'recentAlerts', 'stats', 'alertsByType'));
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
