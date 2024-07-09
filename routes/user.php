<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserAuthController,
    CartController,
    CategoryController,
    CommentController,
    OrderController,
    ProductController,
    WishlistController
};

Route::get('test',function(){
    return "ngrok works"; 
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//  ngrok http http
 //storeproject.test:80

// USER AUTH ROUTES
Route::controller(UserAuthController::class)->prefix('user')->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
    Route::get('/profile', 'profile');
    Route::post('/updateProfile', 'updateProfile');
    Route::post('/deleteMyAccount', 'deleteMyAccount');
    Route::post('/addMyPhoto', 'addMyPhoto');
    Route::post('/deleteMyPhoto', 'deleteMyPhoto');
});



// CART
Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::post('/addtoCart', 'addtoCart');
});
Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::get('/checkoutCart', 'checkoutCart');
});


Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::get('/showMyCart', 'showMyCart');
});

Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::post('/deletefromCart/{id}', 'deletefromCart');
});

Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::get('/MyCartCount', 'MyCartCount');
});

Route::controller(CartController::class)->prefix('user')->group(function () {
    Route::put('/updateQuantity/{id}/{action}', 'updateQuantity');
});







// CATEGORIES
Route::controller(CategoryController::class)->prefix('user')->group(function () {
    Route::get('/getCats', 'getCats');
});




// COMMENTS
Route::controller(CommentController::class)->prefix('user')->group(function () {
    Route::post('/addStars', 'addStars');
});

// ******new*******
Route::controller(CommentController::class)->prefix('user')->group(function () {
    Route::get('/myComments', 'myComments');
});
// ******new*******

// ******new*******
Route::controller(CommentController::class)->prefix('user')->group(function () {
    Route::post('/deletemyComment/{id}', 'deletemyComment');
});
// ******new*******

// ORDERS
Route::controller(OrderController::class)->prefix('user')->group(function () {
    Route::post('/addOrder', 'addOrder');
});

// ******new*******
Route::controller(OrderController::class)->prefix('user')->group(function () {
    Route::get('/myOrders', 'myOrders');
});
// ******new*******



// ******new*******
Route::controller(OrderController::class)->prefix('user')->group(function () {
    Route::post('/deletemyOrder/{id}', 'deletemyOrder');
});
// ******new*******



// PRODUCTS
Route::controller(ProductController::class)->prefix('user')->group(function () {
    Route::get('/getProducts', 'getProducts');
});

Route::controller(ProductController::class)->prefix('user')->group(function () {
    Route::get('/SearchtProducts', 'SearchtProducts');
});

Route::controller(ProductController::class)->prefix('user')->group(function () {
    Route::get('/getProductsForCategory/{id}', 'getProductsForCategory');
});

Route::controller(ProductController::class)->prefix('user')->group(function () {
    Route::get('/product/viewDetails/{id}', 'viewDetails');
});

// WISHLIST
Route::controller(WishlistController::class)->prefix('user')->group(function () {
    Route::post('/addWishlist', 'addWishlist');
});
    


Route::controller(WishlistController::class)->prefix('user')->group(function () {
    Route::get('/myWishlists', 'myWishlists');
});


Route::controller(WishlistController::class)->prefix('user')->group(function () {
    Route::post('/deleteFromWishlists/{id}', 'deleteFromWishlists');
});






