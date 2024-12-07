<?php

namespace App\Http\Controllers;

use App\Models\Product;
class ProductsManager extends Controller
{
    function index()
    {
        $products = Product::all();
        return view('products', compact( "products"));
    }
}
