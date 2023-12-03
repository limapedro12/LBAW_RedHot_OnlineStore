<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\PurchaseController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailController;

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
Route::redirect('/', 'welcome');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');





// Catalogue
Route::controller(ProductsController::class)->group(function () {
    Route::get('/products', 'listProducts')->name('productsList');
    Route::get('/products/search/{stringToSearch}/filter/{filter}', 'searchAndFilterProducts')->name('productsSearchAndFilter');
    Route::get('/products/search/{stringToSearch}/filter/{filter}/API', 'searchAndFilterProductsAPI')->name('productsSearchAndFilterAPI');
    Route::get('/products/add', 'addProductForm')->name('addProductForm');
    Route::post('/products/add', 'addProduct')->name('addProduct');
    Route::get('/products/{id}/edit', 'editProductForm')->name('editProductForm');
    Route::post('/products/{id}/edit', 'editProduct')->name('editProduct');
    Route::get('/products/{id}', 'productsDetails')->name('productsdetails');
    Route::get('/products/{id}', 'productsDetails')->name('productsdetails');
    Route::get('/products/search/{stringToSearch}', 'searchProducts')->name('productsSearch');
    Route::get('/products/filter/{filter}', 'filterProducts')->name('productsFilter');
    Route::get('/products/search/{stringToSearch}/filter/{filter}', 'searchAndFilterProducts')->name('productsSearchAndFilter');
    Route::post('/products/{id}/delete', 'deleteProduct')->name('deleteProduct');
});

// Cart and Purchases
Route::controller(ProductCartController::class)->group(function () {
    Route::post('/products/{id}/add_to_cart', 'addToCart');
    Route::get('/cart', 'showCart');
    Route::post('/cart/remove_product', 'removeFromCart');
});
Route::controller(PurchaseController::class)->group(function () {
    Route::get('/cart/checkout', 'showCheckoutForm');
    Route::post('/cart/checkout', 'checkout');
    Route::get('/users/{id}/orders', 'showOrders');
    Route::get('/users/{userId}/orders/{orderId}', 'showOrderDetails');
    Route::post('/users/{userId}/orders/{orderId}/cancel', 'cancelOrder');
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

// Forget Password
Route::get('/forgetPassword', function () {
    return view('auth.forgetPassword');
})->name('forgetPassword');



// AdminPage = Quando um gajo que faz frontend tenta fazer backend e não sabe o que está a fazer :D
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
    Route::get('/adminOrders', 'adminOrders')->name('adminOrders');
    Route::get('/adminProducts', 'adminProducts')->name('adminProducts');
    Route::get('/adminProductsDiscounts', 'adminProductsDiscounts')->name('adminProductsDiscounts');
    Route::get('/adminProductsHighlights', 'adminProductsHighlights')->name('adminProductsHighlights');
    Route::get('/adminProductsManage', 'adminProductsManage')->name('adminProductsManage');
    Route::get('/adminShipping', 'adminShipping')->name('adminShipping');
    Route::get('/adminUsers', 'adminUsers')->name('adminUsers');
});

// PPs
Route::get('/pps', function () {
    return view('pages.pps');
})->name('pps');

// TOUs
Route::get('/tous', function () {
    return view('pages.tous');
})->name('tous');

// About
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// faqs
Route::get('/faqs', function () {
    return view('pages.faqs');
})->name('faqs');

//Reviews
Route::controller(ReviewsController::class)->group(function () {
    Route::get('/products/{id_product}/reviews', 'listReviews')->name('reviews');
});
Route::controller(ReviewsController::class)->group(function () {
    Route::post('/products/{id_product}/reviews/add_review', 'addReview')->name('addReview');
    Route::post('/products/{id_product}/reviews/{id_review}/edit_review', 'editReview')->name('editReview');
    Route::post('/products/{id_product}/reviews/{id_review}/delete_review', 'deleteReview')->name('deleteReview');
});

//Emails
Route::post('/send', [MailController::class, 'send']);
