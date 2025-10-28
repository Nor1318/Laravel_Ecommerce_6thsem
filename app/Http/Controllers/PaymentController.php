<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Str;

class PaymentController extends Controller
{
    public function paideSewa()
    {
        $user_id = auth()->id();
        $cartItems = Carts::where('user_id', $user_id)->get();
        $amount = $cartItems->sum('total_price');
        $skey = '8gBm/:&EnhH.1/q';
        $transaction_uuid = Str::random(10);
        $product_code = 'EPAYTEST';

        $dataString = "total_amount={$amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";
        $hash = hash_hmac('sha256', $dataString, $skey, true);
        $signature = base64_encode($hash);

        $form = '
        <form id="esewa_form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="'.$amount.'" required>
            <input type="hidden" name="tax_amount" value="0" required>
            <input type="hidden" name="total_amount" value="'.$amount.'" required>
            <input type="hidden" name="transaction_uuid" value="'.$transaction_uuid.'" required>
            <input type="hidden" name="product_code" value="'.$product_code.'" required>
            <input type="hidden" name="product_service_charge" value="0" required>
            <input type="hidden" name="product_delivery_charge" value="0" required>
            <input type="hidden" name="success_url" value="'.route('esewa.success').'" required>
            <input type="hidden" name="failure_url" value="'.route('esewa.failure').'" required>
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="hidden" name="signature" value="'.$signature.'" required>
            <input type="submit" value="Submit" style="opacity: 0;">
        </form>
        <script type="text/javascript">document.getElementById("esewa_form").submit();</script>
        ';

        return response($form);
    }


    public function esewaSuccess(Request $request)
    {
        $encodedData = $request->data;
        $decodedData = base64_decode($encodedData);
        $paymentData = json_decode($decodedData, true);

        $transactionUuid = $paymentData['transaction_uuid'];
        $amount = str_replace(',', '', $paymentData['total_amount']);
        $referenceId = $paymentData['transaction_code'];

        $cartItems = Carts::where('user_id', auth()->id())->get();
        $cartData = $cartItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->total_price
            ];
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_id' => $transactionUuid,
            'amount' => $amount,
            'status' => 'paid',
            'payment_method' => 'esewa',
            'payment_reference' => $referenceId,
            'cart_data' => json_encode($cartData),
        ]);

        Carts::where('user_id', auth()->id())->delete();

        return redirect()->route('viewCart')->with('success', 'Successfully ordered.');
    }



    public function esewaFailure()
    {
        return redirect()->route('viewCart')->with('failure', 'Failed to pay.');
    }
}
