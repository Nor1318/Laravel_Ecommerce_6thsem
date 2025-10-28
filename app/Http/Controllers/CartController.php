<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            session(['guest_session_id' => session()->getId()]);
        }

        $totalPrice = $request->price * $request->quantity;

        $userId = auth()->check() ? auth()->id() : null;
        $sessionId = session('guest_session_id');

        $cartItem = Carts::where('product_id', $request->product_id)
            ->where(function ($query) use ($userId, $sessionId) {
                $query->where('user_id', $userId)
                    ->orWhere('session_id', $sessionId);
            })
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $request->quantity,
                'total_price' => ($request->quantity) * $request->price,
            ]);
            $message = 'Cart item updated successfully!';
        } else {
            $cartItem = Carts::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);
            $message = 'Product added to cart successfully!';
        }

        return redirect()->route('viewCart')->with('success', $message);
    }


    public function viewCart()
    {
        $userId = auth()->check() ? auth()->id() : null;
        $sessionId = session()->getId();

        $cartItems = Carts::with('product')
            ->where(function ($query) use ($userId, $sessionId) {
                $query->where('user_id', $userId)->orWhere('session_id', $sessionId);
            })
            ->get();

        $totalPrice = $cartItems->sum('total_price');
        return view('cart', compact('cartItems', 'totalPrice'));
    }

    public function editCart(int $id)
    {
        $userId = auth()->id();
        $sessionId = session()->getId();

        $cartItem = Carts::where('product_id', $id)
            ->where(function ($query) use ($userId, $sessionId) {
                $query->where('user_id', $userId)
                    ->orWhere('session_id', $sessionId);
            })
            ->first();

        if ($cartItem) {
            return response()->json([
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->product->name,
                'price' => $cartItem->price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        return response()->json(['error' => 'Cart item not found'], 404);
    }

    public function deleteCartItem(int $id)
    {
        $cart = Carts::findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Cart Item deleted successfully!');
    }
}
