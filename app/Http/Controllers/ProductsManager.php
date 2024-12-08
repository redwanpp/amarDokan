<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;

class ProductsManager extends Controller
{
    /**
     * @return Factory|View|Application
     */
    function index()
    {
        $products = Product::paginate(8);
        return view('products', compact( "products"));
    }

    function details($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return view('details', compact("product"));
    }

    function addToCart($id)
    {
        $cart = new Cart();
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $id;
        if ($cart->save()) {
            return redirect()->back()
                ->with('success', 'Product added to cart successfully!');
        }
    }

    function showCart()
    {
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'cart.product_id',
                DB::raw("count(*) as quantity"),
                'products.title', 'products.price',
                'products.image',
                'products.slug')
            ->where("user_id", auth()->user()->id)
            ->groupBy(
                'product_id',
                'products.title',
                'products.price',
                'products.image',
                'products.slug')
            ->paginate(3);
        if($cartItems->isEmpty()){
            return view('emptyCart');
        }

        return view('cart', compact('cartItems'));


    }
}
