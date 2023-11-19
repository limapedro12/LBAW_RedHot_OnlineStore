<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\AdminController;

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

// Home
Route::redirect('/', '/login');

Route::controller(ProductsController::class)->group(function () {
    Route::get('/products', 'listProducts')->name('productsList');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/search/{stringToSearch}', 'searchProducts')->name('productsSearch');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/filter/{filter}', 'filterProducts')->name('productsFilter');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/search/{stringToSearch}/filter/{filter}', 'searchAndFilterProducts')->name('productsSearchAndFilter');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/search/{stringToSearch}/filter/{filter}/API', 'searchAndFilterProductsAPI')->name('productsSearchAndFilterAPI');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/add', 'addProductForm')->name('addProductForm');
});
Route::controller(ProductsController::class)->group(function () {
    Route::post('/products/add', 'addProduct')->name('addProduct');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/{id}/edit', 'editProductForm')->name('editProductForm');
});
Route::controller(ProductsController::class)->group(function () {
    Route::post('/products/{id}/edit', 'editProduct')->name('editProduct');
});
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products/{id}', 'productsDetails')->name('productsdetails');
});

// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});

// User
Route::controller(UserController::class)->group(function() {
    Route::get('/users/{id}', 'showProfileDetails');
    Route::get('/users/{id}/edit', 'editProfileForm');
    Route::post('/users/{id}/edit', 'editProfile');
    Route::get('/users/{id}/delete_account', 'deleteAccountForm');
    Route::post('/users/{id}/delete_account', 'deleteAccount');
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});


// AdminPage
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
});

// PPs
Route::get('/pps', function () {
    return view('pages.pps');
})->name('pps');

// TOUs
Route::get('/tous', function () {
    return view('pages.tous');
})->name('tous');

