<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('user', [UserController::class, 'show'])->middleware('auth.jwt');
Route::get('products', [ProductController::class, 'index']);

require __DIR__.'/auth.php';
