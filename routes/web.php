<?php
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ProductsCollection;
use App\Product;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where the routes are registered for our application.
|
*/

// Named route required for SendsPasswordResetEmails.


Route::get('reset-password', function() {
    return view('index');
})->name('password.reset');

// Catches all other web routes.
Route::get('{slug}', function () {
    return view('index');
})->where('slug', '^(?!api).*$');

