<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['locale', 'userauth'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'display'])
    ->middleware('guest')
    ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

    Route::get('/login', [AuthenticatedSessionController::class, 'display'])
        ->middleware('guest')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/cart', [CartController::class, 'showCartView'])->name('cart');
    Route::post('/addtocart', [CartController::class, 'addToCart'])->name('addtocart');
    Route::get('/addtocart/{id}', [CartController::class, 'addToCartHomeView'])->name('addtocarthomeview');

    Route::get('/productbycat/{id}', [ProductController::class, 'showProductByCategory'])
        ->name('productbycat');
    Route::get('/productbyprice/{price}', [ProductController::class, 'showProductByPrice'])
        ->name('productbyprice');
    Route::get('/details/{id}', [ProductController::class, 'showDetailProduct'])
        ->name('details');
    Route::post('/search', [ProductController::class, 'searchProduct'])->name('search');
    Route::get('/changeLanguage/{language}', [LocaleController::class, 'changeLanguage'])->name('changeLanguage');
    Route::post('/updatecart', [CartController::class, 'updateCart'])->name('updatecart');
    Route::get('/deletecart/{id}', [CartController::class, 'deleteCart'])->name('deletecart');
});


Route::middleware(['auth','userauth','locale'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'showUserProfile'])->name('profile');
    Route::get('/order', [OrderController::class, 'showOrderView'])->name('order');
    Route::get('/orderdetail/{id}', [OrderController::class, 'showOrderDetailView'])->name('orderdetail');
    Route::get('/payment', [OrderController::class, 'showPaymentView'])->name('payment');
    Route::post('/comment', [CommentController::class, 'commentProduct'])->name('comment');
    Route::post('/updatecustomer', [UserController::class, 'updateCustomer'])->name('updatecustomer');
    Route::post('/insertOrder', [OrderController::class, 'insertOrder'])->name('insertOrder');
    Route::get('/changepassword', [UserController::class, 'showChangePasswordView'])->name('showChangePasswordView');
    Route::post('/changepassword', [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/rating', [RatingController::class, 'ratingProduct'])->name('rating');
});

Route::prefix('admin')->middleware(['adminauth','locale'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admindashboard');
    Route::get('/catadd', [CategoryController::class, 'showAddCategoryView'])->name('catadd');
    Route::get('/catlist', [CategoryController::class, 'showListCategoryView'])->name('catlist');
    Route::get('/productadd', [ProductController::class, 'showAddProductView'])->name('productadd');
    Route::get('/productlist', [ProductController::class, 'showListProductView'])->name('productlist');
    Route::get('/productedit/{id}', [ProductController::class, 'showEditProductView'])->name('showEditProductView');
    Route::get('/deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/adminorderdetail/{id}', [OrderController::class, 'showAdminOrderDetailView'])
        ->name('adminorderdetail');
    Route::get('/lock/{id}', [UserController::class, 'lockUser'])->name('lockUser');
    Route::get('/unlock/{id}', [UserController::class, 'unlockUser'])->name('unlockUser');
    Route::get('/ordersuccess', [OrderController::class, 'showOrderSuccessView'])->name('ordersuccess');
    Route::get('/importlist', [ProductController::class, 'showListImportView'])->name('importlist');
    Route::get('/userlist', [UserController::class, 'showListUserView'])->name('userlist');
    Route::get('/catedit/{id}', [CategoryController::class, 'showEditCategoryView'])->name('catedit');
    Route::get('/catdelete/{id}', [CategoryController::class, 'deleteCategory'])->name('catdelete');
    Route::get('/providenewpassword/{id}', [UserController::class, 'provideNewPassword'])->name('provideNewPassword');
    Route::get('/approveorder', [OrderController::class, 'showOrderPendingView'])->name('showOrderPendingView');
    Route::get('/approveorder/{id}', [OrderController::class, 'approveOrder'])->name('approveOrder');
    Route::get('/denyorder/{id}', [OrderController::class, 'denyOrder'])->name('denyOrder');

    Route::post('/addcategory', [CategoryController::class, 'addCategory'])->name('addcategory');
    Route::post('/editcategory', [CategoryController::class, 'editCategory'])->name('editcategory');
    Route::post('/addproduct', [ProductController::class, 'addProduct'])->name('addproduct');
    Route::post('/editproduct', [ProductController::class, 'editProduct'])->name('editproduct');
    Route::post('/changePasswordUser', [UserController::class, 'changePasswordUser'])->name('changePasswordUser');
});
