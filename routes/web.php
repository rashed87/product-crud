<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/products', function () {
        return view('products');
    })->name('products');

    Route::get('/product/create', function () {
        return view('product.product-create');
    })->name('product.product-create');

    Route::get('/product/single', function () {
        return view('product.product-single');
    })->name('product.product-single');

    Route::get('/product/update', function () {
        return view('product.product-update');
    })->name('product.product-update');

});
