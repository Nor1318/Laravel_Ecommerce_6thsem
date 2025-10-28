<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAddresses(){
        $user_id = auth()->id();
        $addresses = Addresses::where('user_id', $user_id)->get();
        return view('addressBook', compact('addresses'));
    }

    public function addAddress(Request $request){
        $address = new Addresses();
        $address->user_id = auth()->id();
        $address->name = $request->input('name');
        $address->phone = $request->input('phone');
        $address->address_line1 = $request->input('address_line1');
        $address->address_line2 = $request->input('address_line2');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->country = $request->input('country');
        $address->postal_code = $request->input('postal_code');
        $address->is_default = $request->has('is_default');
        $address->save();

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function editAddress(int $id){
        $address = Addresses::findOrFail($id);
        return response()->json($address);
    }

    public function updateAddress(Request $request){
        $address = Addresses::findOrFail($request->id);
        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->back()->with('success', 'Address updated successfully.');
    }

    public function deleteAddress(int $id){
        $address = Addresses::findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }
}
