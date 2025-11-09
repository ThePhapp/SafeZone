<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\AlertResource;


class AlertUserController extends Controller
{
    //
  public function index(Request $request)
{
    $query = Alert::with('address')->latest();
    $filterMode = $request->get('mode', 'all'); 
    $userAddresses = collect();

    if (auth()->check()) {
        $user = auth()->user();
        $userAddresses = $user->addresses()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'latitude', 'longitude']);
    }

    if ($filterMode === 'near') {
        if ($userAddresses->isNotEmpty()) {
            $query->whereHas('address', function ($q) use ($userAddresses) {
                $q->where(function ($sub) use ($userAddresses) {
                    foreach ($userAddresses as $addr) {
                        $lat = $addr->latitude;
                        $lng = $addr->longitude;

                        // Haversine tính bằng mét
                        $sub->orWhereRaw(
                            "(6371000 * acos(
                                cos(radians(?)) * cos(radians(latitude)) *
                                cos(radians(longitude) - radians(?)) +
                                sin(radians(?)) * sin(radians(latitude))
                            )) <= alerts.radius",
                            [$lat, $lng, $lat]
                        );
                    }
                });
            });
        } else {
            $query->whereRaw('1 = 0');
        }
    }

    if ($request->filled('severity')) $query->where('severity', $request->severity);
    if ($request->filled('type')) $query->where('type', $request->type);
    if ($request->filled('status')) $query->where('status', $request->status);
    if ($request->filled('from_date')) $query->whereDate('issued_at', '>=', $request->from_date);
    if ($request->filled('to_date')) $query->whereDate('issued_at', '<=', $request->to_date);
    if ($request->filled('q')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%'.$request->q.'%')
              ->orWhere('description', 'like', '%'.$request->q.'%');
        });
    }

    $alerts = AlertResource::collection($query->get());
    // dd($userAddresses);

    return view('user.alerts.index', [
        'alerts' => $alerts,
        'mode' => $filterMode,
        'userAddresses' => $userAddresses,
    ]);
}



}
