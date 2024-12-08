<?php

use App\Http\Controllers\AuthManager;
use \App\Http\Controllers\OrderManager;
use App\Http\Controllers\ProductsManager;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductsManager::class, 'index'])->name("home");

Route::get("login", [AuthManager::class, "login"])
    ->name("login");

Route::get("logout", [AuthManager::class, "logout"])
    ->name("logout");

Route::post("auth", [AuthManager::class, "loginPost"])
    ->name("login.post");

Route::get("register", [AuthManager::class, "register"])
    ->name("register");

Route::post("registerPost", [AuthManager::class, "registerPost"])
    ->name('register.post');

Route::get("/product/{slug}", [ProductsManager::class, 'details'])
    ->name("product.details");

Route::middleware("auth")->group(function () {
    Route::get("/cart/{id}", [ProductsManager::class, 'addToCart'])
        ->name("cart.add");

    Route::get("/cart", [ProductsManager::class, 'showCart'])
        ->name("cart.show");

    Route::get("/checkout", [OrderManager::class, 'showCheckout'])
        ->name("checkout.show");

    Route::post("/checkout", [OrderManager::class, 'checkoutPost'])
        ->name("checkout.post");
});
