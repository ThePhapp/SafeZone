<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $addresses = AddressResource::collection($user->addresses);
        return view('user.addresses.index', ['addresses' => $addresses]);
    }
    public function createAddressForUser()
    {
        return view('user.addresses.create');
    }
    public function storeAddressForUser(Request $request)
    {
        $user = Auth::user();
    
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
    
        $existing = Address::where('addressable_id', $user->id)
            ->where('addressable_type', User::class)
            ->where('latitude', $latitude)
            ->where('longitude', $longitude)
            ->first();
    
        if ($existing) {
            return back()->withErrors(['duplicate' => 'You already have an address at this location.']);
        }

        $address = new Address();
        $address->address_line = $request->input('address_line');
        $address->district = $request->input('district');
        $address->city = $request->input('city');
        $address->province = $request->input('province');
        $address->country = $request->input('country');
        $address->postal_code = $request->input('postal_code');
        $address->google_place_id = $request->input('google_place_id');
        $address->formatted_address = $request->input('formatted_address');
        $address->latitude = $latitude;
        $address->longitude = $longitude;
        $address->addressable_id = $user->id;
        $address->addressable_type = User::class;
        $address->save();
    
        return redirect()->route('addresses.index')->with('success', 'Address created successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $address = Address::where('id', $id)
            ->where('addressable_id', $user->id)
            ->where('addressable_type', User::class)
            ->first();

        if (!$address) {
            return redirect()->route('addresses.index')->withErrors(['not_found' => 'Address not found or you do not have permission to delete it.']);
        }

        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');
    }
}
