<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Carts;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $guestSessionId = session('guest_session_id');
        
        if ($guestSessionId) {
            // Find cart items associated with the guest session
            $cartItems = Carts::where('session_id', $guestSessionId)->get();
            
            // If there are cart items for the guest session
            if ($cartItems->count() > 0) {
                // Update the cart items to associate with the logged-in user
                Carts::where('session_id', $guestSessionId)->update([
                    'user_id' => $user->id,
                ]);
            }
            
            // Clear the guest session ID after transferring the cart items
            session()->forget('guest_session_id');
        }
    }
}
