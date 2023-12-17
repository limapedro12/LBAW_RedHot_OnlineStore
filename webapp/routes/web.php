<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\OrderController;

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
    Route::get('/products/search/{stringToSearch}/filter/{filter}/API', 'searchAndFilterProductsAPI')->name('productsSearchAndFilterAPI');
    Route::get('/products/add', 'addProductForm')->name('addProductForm');
    Route::post('/products/add', 'addProduct')->name('addProduct');
    Route::get('/products/{id}/edit', 'editProductForm')->name('editProductForm');
    Route::post('/products/{id}/edit', 'editProduct')->name('editProduct');
    Route::get('/products/{id}/changeStock', 'changeStockProductForm')->name('changeStockProductForm');
    Route::post('/products/{id}/changeStock', 'changeStockProduct')->name('changeStockProduct');
    Route::get('/products/{id}', 'productsDetails')->name('productsdetails');
    Route::get('/products/search/{stringToSearch}', 'searchProducts')->name('productsSearch');
    Route::get('/products/filter/{filter}', 'filterProducts')->name('productsFilter');
    Route::get('/products/search/{stringToSearch}/filter/{filter}', 'searchAndFilterProducts')->name('productsSearchAndFilter');
    Route::delete('/products/{id}/delete', 'deleteProduct')->name('deleteProduct');
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
    Route::post('/users/{userId}/orders/{orderId}/change_state', 'changeState');
    Route::put('/cart/change_quantity/', 'changeQuantity');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/users/{id}', 'showProfileDetails');
    Route::get('/users/{id}/edit', 'editProfileForm');
    Route::post('/users/{id}/edit', 'editProfile');
    Route::get('/users/{id}/delete_account', 'deleteAccountForm');
    Route::post('/users/{id}/delete_account', 'deleteAccount');
    Route::get('/users/{id}/edit_password', 'editPasswordForm');
    Route::post('/users/{id}/edit_password', 'editPassword');
    Route::get('/users/{id}/change_password/{token}', 'changePasswordForm');
    Route::post('/users/{id}/change_password/{token}', 'changePassword');
    Route::post('/users/{id}/ban', 'banUser');
    Route::post('/users/{id}/promote', 'becomeAdmin');
});

Route::controller(NotificationController::class)->group(function () {
    Route::get('/users/{user_id}/notifications', 'listNotifications')->name('notifications');

    Route::get('admin/{admin_id}/notifications', 'adminNotifications')->name('adminNotifications');

    Route::delete('notifications/{notification_id}/delete', 'deleteNotification')->name('deleteNotification');
    Route::put('notifications/{notification_id}/markAsRead', 'markNotificationAsRead')->name('markNotificationAsRead');
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



// AdminPage
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'admin')->name('admin');
    Route::get('/adminOrders', 'adminOrders')->name('adminOrders');
    Route::get('/adminProductsAdd', 'adminProductsAdd')->name('adminProductsAdd');
    Route::get('/adminProductsHighlights', 'adminProductsHighlights')->name('adminProductsHighlights');
    Route::post('/adminProductsHighlights/addHighlight/{id}', 'addHighlight')->name('addHighlight');
    Route::post('/adminProductsHighlights/removeHighlight/{id}', 'removeHighlight')->name('removeHighlight');
    Route::get('/adminProductsManage', 'adminProductsManage')->name('adminProductsManage');
    Route::get('/adminProfile', 'adminProfile')->name('adminProfile');
    Route::get('/adminProfile/edit', 'editProfileForm');
    Route::post('/adminProfile/edit', 'editProfile');
    Route::get('/adminProfile/edit_password', 'editPasswordForm');
    Route::post('/adminProfile/edit_password', 'editPassword');
    Route::get('/adminFAQ', 'adminFAQ')->name('adminFAQ');
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

//Reviews
Route::controller(ReviewsController::class)->group(function () {
    Route::get('/products/{id_product}/reviews', 'listReviews')->name('reviews');
});
Route::controller(ReviewsController::class)->group(function () {
    Route::post('/products/{id_product}/reviews/add_review', 'addReview')->name('addReview');
    Route::get('/products/{id_product}/reviews/{id_review}/edit_review', 'editReviewForm')->name('editReviewForm');
    Route::post('/products/{id_product}/reviews/{id_review}/edit_review', 'editReview')->name('editReview');
    Route::post('/products/{id_product}/reviews/{id_review}/delete_review', 'deleteReview')->name('deleteReview');
    Route::post('/products/{id_product}/reviews/{id_review}/admin_delete_review', 'adminDeleteReview')->name('adminDeleteReview');
});

//Emails
Route::post('/send', [MailController::class, 'send']);


//Wishlist
Route::controller(WishlistController::class)->group(function () {
    Route::get('/users/{id}/wishlist', 'listWishlist')->name('listWishlist');
    Route::post('/users/{id}/wishlist/{id_product}/add_to_wishlist', 'addToWishlist')->name('addToWishlist');
    Route::post('/users/{id}/wishlist/{id_product}/remove_from_wishlist', 'removeFromWishlist')->name('removeFromWishlist');
});

// Faqs
Route::controller(FaqsController::class)->group(function () {
    Route::get('/faqs', 'listFaqs')->name('faqs');
    Route::get('/faqs/{id}', 'faq')->name('faq');
    Route::get('/adminFAQ/add', 'addFaqForm')->name('addFaqForm');
    Route::post('/adminFAQ/add', 'createFaqs')->name('createFaqs');
    Route::post('/adminFAQ/{id}/edit', 'editFaqs')->name('editFaqs');
    Route::delete('/adminFAQ/{id}/delete', 'deleteFaqs')->name('deleteFaqs');
});
