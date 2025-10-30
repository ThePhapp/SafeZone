<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Http\Resources\AlertResource;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;




class AlertController extends Controller
{
    public function index()
    {
        $alerts = AlertResource::collection(
            Alert::with('address')
                ->whereIn('type', ['flood','fire','storm','earthquake'])
                ->whereIn('severity', ['low','medium','high','critical'])
                ->get()
        );

        //dd($alerts);
        return view('admin.alerts.index', [
            'alerts' => $alerts,
        ]);
    }

    public function create()
    {
        return view('admin.alerts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
        ]);

        $alert = new Alert();
        $alert->title = $request->input('title');
        $alert->description = $request->input('description');
        $alert->type = $request->input('type');
        $alert->severity = $request->input('severity');
        $alert->created_by = Auth()->user()->id;
        $alert->save();

        $address = new Address();
        $address->address_line = $request->input('address_line');
        $address->district = $request->input('district');
        $address->city = $request->input('city');
        $address->province = $request->input('province');
        $address->country = $request->input('country');
        $address->postal_code = $request->input('postal_code');
        $address->google_place_id = $request->input('google_place_id');
        $address->formatted_address = $request->input('formatted_address');
        $address->latitude = $request->input('latitude');
        $address->longitude = $request->input('longitude');
        $alert->address()->save($address);


        return redirect()->route('admin.alerts.index')->with('success', 'Alert created successfully.');
    }


}
