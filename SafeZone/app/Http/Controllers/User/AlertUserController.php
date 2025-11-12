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

                        $extraDistance = 1000; // 100 mét

                        $sub->orWhereRaw(
                            "(6371000 * acos(
                                cos(radians(?)) * cos(radians(latitude)) *
                                cos(radians(longitude) - radians(?)) +
                                sin(radians(?)) * sin(radians(latitude))
                            )) <= alerts.radius + ?",
                            [$lat, $lng, $lat, $extraDistance]
                        );

                    }
                });
            });
        } else {
            $query->whereRaw('1 = 0');
        }
    }else if($filterMode === 'in'){
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

    // Paginate results for listing and keep a resource collection for the map
    $alertsPaginated = $query->paginate(12)->withQueryString();
    $alertsForMap = AlertResource::collection($alertsPaginated);

    return view('user.alerts.index', [
        // paginator used for rendering the list and links
        'alertsPaginated' => $alertsPaginated,
        // resource collection (transformed) used for the map component
        'alerts' => $alertsForMap,
        'mode' => $filterMode,
        'userAddresses' => $userAddresses,
    ]);
}
    public function show($id)
{
    $alert = Alert::with('address')->findOrFail($id);
    $userAddresses = collect();
    $user = auth()->user();
        $userAddresses = $user->addresses()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'latitude', 'longitude']);
    return view('user.alerts.show', [
        'alerts' => AlertResource::collection(collect([$alert])),
        'userAddresses' => $userAddresses,
    ]);

}






}
