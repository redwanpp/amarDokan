<?php

use App\Http\Controllers\AuthManager;
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
