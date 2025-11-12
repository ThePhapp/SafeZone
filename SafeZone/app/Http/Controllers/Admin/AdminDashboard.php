<?php
// app/Http/Controllers/Admin/AdminDashboard.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alert;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public function index()
    {
        $alertsCount = Alert::count();
        $usersCount = User::count();
        $activeAlerts = Alert::where('severity', '!=', 'low')->count();
        $statisticsCount = Alert::distinct('type')->count('type');
        $recentAlerts = Alert::orderBy('created_at', 'desc')->take(5)->get();

        // Nếu có map, truyền locations
        $locations = Alert::with('address')->get()->map(function($alert) {
            return [
                'lat' => $alert->address->latitude ?? null,
                'lng' => $alert->address->longitude ?? null,
                'name' => $alert->title,
            ];
        });

        return view('admin.dashboard', compact(
            'alertsCount',
            'usersCount',
            'activeAlerts',
            'statisticsCount',
            'recentAlerts',
            'locations'
        ));
    }
    
        public function statistics()
        {
            $totalAlerts = \App\Models\Alert::count();
            $alertsByType = \App\Models\Alert::select('type')
                ->groupBy('type')
                ->selectRaw('type, COUNT(*) as count')
                ->get();
            $alertsBySeverity = \App\Models\Alert::select('severity')
                ->groupBy('severity')
                ->selectRaw('severity, COUNT(*) as count')
                ->get();
            $recentAlerts = \App\Models\Alert::orderBy('created_at', 'desc')->take(10)->get();
            return view('admin.statistics', compact('totalAlerts', 'alertsByType', 'alertsBySeverity', 'recentAlerts'));
        }
}