<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\ProductControllerApi;
use App\Http\Controllers\Api\CategoryControllerApi;
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

Route::get('/', function() {
    return view('layouts.master');
});
Route::get('/product', [App\Http\Controllers\ProductController::class, 'index']);
Route::post('/product/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::get('/product/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::get('/product/edit/{id?}', [App\Http\Controllers\ProductController::class, 'edit']);
Route::post('/product/update', [App\Http\Controllers\ProductController::class, 'update']);
Route::post('/product/add', [App\Http\Controllers\ProductController::class, 'insert']);
Route::get('/product/remove/{id}', [App\Http\Controllers\ProductController::class, 'remove']);

Route::get('/category', [App\Http\Controllers\CategoryController::class, 'category']);
Route::get('/category/search', [App\Http\Controllers\CategoryController::class, 'search']);
Route::post('/category/search', [App\Http\Controllers\CategoryController::class, 'search']);
Route::get('/category/edit/{id?}', [App\Http\Controllers\CategoryController::class, 'edit']);
Route::post('/category/update', [App\Http\Controllers\CategoryController::class, 'update']);
Route::post('/category/add', [App\Http\Controllers\CategoryController::class, 'insert']);
Route::get('/category/remove/{id}', [App\Http\Controllers\CategoryController::class, 'remove']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/api/product', [ProductControllerApi::class, 'product_list']);
Route::get('/api/category', [CategoryControllerApi::class, 'category_list']);