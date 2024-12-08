<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                )
            ->where("user_id", auth()->user()->id)
            ->groupBy(
                'product_id',
                'products.price')
            ->get();

        if($cartItems->isEmpty()) {
            return redirect(route('cart.show') )->with('error', 'Cart is empty');
        }

        $productIds = array();
        $quantities = array();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
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
            return redirect()->route('cart.show')->with('success', 'Order placed successfully');
        }
        return redirect(route('cart.show'))->with('error', 'Error occurred while processing your order');
    }
}
