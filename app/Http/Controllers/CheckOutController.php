<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Addresses;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CheckOut()
    {
        $user_id = auth()->id();
        $cartItems = Carts::where('user_id', $user_id)->get();
        $totalPrice = $cartItems->sum('total_price');

        $address = Addresses::where('user_id', $user_id)
                            ->where('is_default', 1)
                            ->first();
        return view('checkout', compact('cartItems', 'totalPrice','address'));
    }
}
