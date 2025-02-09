<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Models\Store;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    $shop_page = Store::join('categories', 'stores.id', '=', 'categories.store_id')
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->select(
            'stores.id as store_id',
            'stores.store_name as stores_name',  // Fixed column name
            'categories.id as category_id',
            'categories.category_name as categories_name', // Fixed column name
            'products.id as product_id',
            'products.product_name as products_name' // Fixed column name
        )
        ->orderBy('stores.id')
        ->orderBy('categories.id')
        ->get()
        ->groupBy('store_id'); // Moved after get()
    //   return $shop_page;
    return view('ShopPage', compact('shop_page'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/merchants/dashboard', [MerchantController::class, 'MerchantsDashboard'])->name('merchants.dashboard');


// Admin Merchant list Part
Route::prefix('admin/')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/merchant-list', [AdminController::class, 'MerchantList'])->name('merchant.list');
});




// Merchant Store Part
Route::prefix('merchant/')->middleware('auth')->name('merchant.')->group(function () {
    Route::get('/store-list', [StoreController::class, 'MerchantStoreList'])->name('store.list');
    Route::post('/store-add', [StoreController::class, 'MerchantAddList'])->name('store.add');
    Route::get('/store-destroy-{id}', [StoreController::class, 'MerchantStoreDestroy'])->name('store.destroy');
    Route::get('/store-details-{id}', [StoreController::class, 'MerchantStoreDetails'])->name('store.details');
});


// Merchant Category Part
Route::prefix('merchant/')->middleware('auth')->name('merchant.')->group(function () {
    Route::get('/category-list', [CategoryController::class, 'MerchantCategoryList'])->name('category.list');
    Route::post('/category-add', [CategoryController::class, 'MerchantCategoryAdd'])->name('category.add');
    Route::get('/category-destroy-{id}', [CategoryController::class, 'MerchantCategoryDestroy'])->name('category.destroy');
});


// Merchant Product Part
Route::prefix('merchant/')->middleware('auth')->name('merchant.')->group(function () {
    Route::get('/product-list', [ProductController::class, 'MerchantProductList'])->name('product.list');
    Route::get('/shop-wise-category', [ProductController::class, 'shop_wise_category'])->name('shop_wise_category');
    Route::post('/product-add', [ProductController::class, 'MerchantProductAdd'])->name('product.add');
    Route::get('/product-destroy-{id}', [ProductController::class, 'MerchantProductDestroy'])->name('product.destroy');
});
