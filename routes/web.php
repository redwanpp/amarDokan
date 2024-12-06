<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::get("login", [AuthManager::class, "login"])
    ->name("login");

Route::post("auth", [AuthManager::class, "loginPost"])
    ->name("login.post");

Route::get("register", [AuthManager::class, "register"])
    ->name("register");

Route::post("registerPost", [AuthManager::class, "registerPost"])
    ->name('register.post');