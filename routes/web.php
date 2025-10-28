<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\PaymentController;

Route::get('/',[SiteController::class,'getHome']);

//SiteController
Route::get('services',[SiteController::class,'getServices']);
Route::get('product',[SiteController::class,'getProduct']);
Route::get('products',[SiteController::class, 'getProducts'])->name('getProducts');
Route::get('product/{id}',[SiteController::class, 'getProduct'])->name('getProduct');
Route::get('allproducts', [SiteController::class, 'allProducts'])->name('allProducts');

Auth::routes();

//HomeController
Route::get('home', [HomeController::class, 'index'])->name('home');

//CategoryController
Route::get('manage/category',[CategoryController::class, 'getManageCategory'])->name('getManageCategory');
Route::get('manage/category/list',[CategoryController::class, 'getCategoryList'])->name('getCategoryList');
Route::post('manage/category/create',[CategoryController::class, 'addCategory'])->name('addCategory');
Route::get('manage/category/{id}/edit',[CategoryController::class, 'editCategory'])->name('editCategory');
Route::put('manage/category/update', [CategoryController::class, 'updateCategory'])->name('updateCategory');
Route::delete('manage/category/{id}/delete',[CategoryController::class, 'deleteCategory'])->name('deleteCategory');

//ProductController
Route::get('manage/product',[ProductController::class, 'getManageProduct'])->name('getManageProduct');
Route::post('manage/product/create',[ProductController::class, 'addProduct'])->name('addProduct');
Route::get('manage/product/{id}/edit',[ProductController::class, 'editProduct'])->name('editProduct');
Route::put('manage/product/update', [ProductController::class, 'updateProduct'])->name('updateProduct');
Route::delete('manage/product/{id}/delete',[ProductController::class, 'deleteProduct'])->name('deleteProduct');

//CartController
Route::post('addToCart',[CartController::class, 'addToCart'])->name('addToCart');
Route::get('cart',[CartController::class, 'viewCart'])->name('viewCart');
Route::get('cart/{id}/edit',[CartController::class, 'editCart'])->name('editCartItem');
Route::delete('cart/{id}/delete',[CartController::class, 'deleteCartItem'])->name('deleteCartItem');

//AddressController
Route::get('addressBook',[AddressController::class, 'getAddresses'])->name('getAddresses');
Route::post('addressBook/create',[AddressController::class, 'addAddress'])->name('addAddress');
Route::get('addressBook/{id}/edit',[AddressController::class, 'editAddress'])->name('editAddress');
Route::put('addressBook/update',[AddressController::class, 'updateAddress'])->name('updateAddress');
Route::delete('addressBook/{id}/delete',[AddressController::class, 'deleteAddress'])->name('deleteAddress');

//CheckOutController
Route::get('checkout',[CheckOutController::class, 'CheckOut'])->name('CheckOut');

//PaymentController
Route::get('/esewa/pay', [PaymentController::class, 'paideSewa'])->name('esewa.pay');
Route::get('/esewa/success', [PaymentController::class, 'esewaSuccess'])->name('esewa.success');
Route::get('/esewa/failure', [PaymentController::class, 'esewaFailure'])->name('esewa.failure');