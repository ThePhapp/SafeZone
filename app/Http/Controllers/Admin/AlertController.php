<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alert;
use App\Http\Resources\AlertResource;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;




class AlertController extends Controller
{
    public function index()
    {
        $alerts = AlertResource::collection(
            Alert::with('address')
                ->whereIn('type', ['flood','fire','storm','earthquake'])
                ->whereIn('severity', ['low','medium','high','critical'])
                ->latest()
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
            'address_line' => 'required|string', 
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'address_line.required' => 'Please select an address on the map before creating an alert.',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage'), $imageName);
            $image_path = $imageName;
        } else {
            $image_path = 'base.png';
        }

        $alert = new Alert();
        $alert->title = $request->input('title');
        $alert->image_path = $image_path;
        $alert->description = $request->input('description');
        $alert->type = $request->input('type');
        $alert->severity = $request->input('severity');
        $alert->radius = $request->input('radius', 0);
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
        $alert->refresh();
        Http::post('http://localhost:6001/new-alert', $alert->toArray());

        return redirect()->route('admin.alerts.index')->with('success', 'Alert created successfully.');
    }

    public function edit($id)
    {
        $alert = Alert::with('address')->findOrFail($id);
        return view('admin.alerts.edit', compact('alert'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address_line' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $alert = Alert::with('address')->findOrFail($id);

        // Xử lý ảnh
        $image_path = $alert->image_path;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage'), $imageName);
            $image_path = $imageName;
        }

        $alert->update([
            'title' => $request->input('title'),
            'image_path' => $image_path,
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'severity' => $request->input('severity'),
        ]);

        $alert->address->update([
            'address_line' => $request->input('address_line'),
            'district' => $request->input('district'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'country' => $request->input('country'),
            'postal_code' => $request->input('postal_code'),
            'google_place_id' => $request->input('google_place_id'),
            'formatted_address' => $request->input('formatted_address'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        return redirect()->route('admin.alerts.index')->with('success', 'Alert updated successfully.');
    }



    public function show($id)
    {
        $alert = new AlertResource(
            Alert::with('address')->findOrFail($id)
        );

        return view('admin.alerts.show', [
            'alert' => $alert,
        ]);
    }

    public function destroy($id)
    {
        $alert = Alert::findOrFail($id);
        $image_path = public_path('storage/' . $alert->image_path);

        if ($alert->image_path && file_exists($image_path)) {
            if (unlink($image_path)) {
                Log::info("Xóa ảnh thành công");
            } else {
                Log::error("Xóa ảnh thất bại");
            }
        }
        $alert->delete();
        return redirect()->route('admin.alerts.index')->with('success', 'Alert deleted successfully.');
    }


}
