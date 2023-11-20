<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;

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


// AdminPage = Quando um gajo que faz frontend tenta fazer backend e não sabe o que está a fazer :D
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
});

Route::get('/adminOrders', function () {
    return view('pages.adminOrders');
})->name('adminOrders');

Route::get('/adminProducts', function () {
    return view('pages.adminProducts');
})->name('adminProducts');

Route::get('/adminProductsDiscounts', function () {
    return view('pages.adminProductsDiscounts');
})->name('adminProductsDiscounts');

Route::get('/adminProductsHighlights', function () {
    return view('pages.adminProductsHighlights');
})->name('adminProductsHighlights');

Route::get('/adminProductsManage', function () {
    return view('pages.adminProductsManage');
})->name('adminProductsManage');

Route::get('/adminShipping', function () {
    return view('pages.adminShipping');
})->name('adminShipping');

Route::get('/adminUsers', function () {
    return view('pages.adminUsers');
})->name('adminUsers');


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
