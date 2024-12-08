<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;

class OrderManager extends Controller
{
    function showCheckout()
    {
        return view('checkout');
    }

    function checkoutPost(Request $request) {
        $request->validate([
           'address' => 'required',
           'phone' => 'required',
           'pincode' => 'required',
        ]);

        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'cart.product_id',
                DB::raw(
                    "count(*) as quantity"),
                    'products.price',
                    'products.title',
                )
            ->where("user_id", auth()->user()->id)
            ->groupBy(
                'product_id',
                'products.price',
            'products.title')
            ->get();

        if($cartItems->isEmpty()) {
            return redirect(route('cart.show') )->with('error', 'Cart is empty');
        }

        $productIds = array();
        $quantities = array();
        $totalPrice = 0;
        $lineItems = array();

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => $cartItem->title,
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->pincode = $request->pincode;
        $order->product_id = json_encode($productIds);
        $order->quantity = json_encode($quantities);
        $order->total_price = json_encode($totalPrice);
        if ($order->save()) {
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();
            $stripe = new StripeClient(config('app.stripe_secret'));

            $checkoutSession = $stripe->checkout->sessions->create([
               'success_url' => route('payment.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.error'),
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'order_id' => $order->id,
                ]
            ]);
            return redirect($checkoutSession->url);
        }
        return redirect(route('cart.show'))->with('error', 'Error occurred while processing your order');
    }

    function paymentError()
    {
        return "error";
    }

    function paymentSuccess($order_id)
    {
        return "success " . $order_id;
    }

    function webhookStripe(Request $request)
    {
        $endpoint_secret = config('app.stripe_secret');
        $payload = $request->getContent();
        $signHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload, $endpoint_secret, $signHeader
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid Signature'], 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id;
            $paymentId = $session->payment_intent;

            $order = Orders::find($orderId);
            if ($orderId) {
                $order->payment_id = $paymentId;
                $order->payment_status = 'completed';
                $order->save();
            }
        }

        return response()->json(["status" => "success"], 200);
    }
}
