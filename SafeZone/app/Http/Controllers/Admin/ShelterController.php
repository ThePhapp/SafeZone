<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelter;
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    public function index()
    {
        $shelters = Shelter::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.shelters.index', compact('shelters'));
    }

    public function create()
    {
        return view('admin.shelters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:0',
            'type' => 'required|string',
            'status' => 'required|string',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/shelters'), $imageName);
            $image_path = 'shelters/' . $imageName;
        }

        Shelter::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'status' => $request->status,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'facilities' => $request->facilities ?? [],
            'image_path' => $image_path,
        ]);

        return redirect()->route('admin.shelters.index')->with('success', 'Shelter created successfully.');
    }

    public function edit($id)
    {
        $shelter = Shelter::findOrFail($id);
        return view('admin.shelters.edit', compact('shelter'));
    }

    public function update(Request $request, $id)
    {
        $shelter = Shelter::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'capacity' => 'required|integer|min:0',
        ]);

        $image_path = $shelter->image_path;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/shelters'), $imageName);
            $image_path = 'shelters/' . $imageName;
        }

        $shelter->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'status' => $request->status,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'facilities' => $request->facilities ?? [],
            'image_path' => $image_path,
        ]);

        return redirect()->route('admin.shelters.index')->with('success', 'Shelter updated successfully.');
    }

    public function destroy($id)
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();
        return redirect()->route('admin.shelters.index')->with('success', 'Shelter deleted successfully.');
    }
}
