<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CategoryController::class)->group(function(){
    // Route::post('newCategory', 'newCategory');
    Route::get('getCategory', 'getCategories');
    Route::get('getCategoryById/{id}', 'getCategoryById');
    Route::delete('deleteCategory/{id}', 'deleteCategory');
    Route::put('putCategory/{id}', 'updateCategory');

});

Route::post('newCategory', [CategoryController::class, 'newCategory']);

Route::post('newProduct', [ProductController::class, 'newProduct']);

Route::controller(ProductController::class)->group(function(){
    Route::post('newProduct', 'newProduct');
    Route::get('getProduct', 'getProduct');
    Route::get('getProductById/{id}', 'getProductById');
    Route::delete('deleteProduct/{id}', 'deleteProduct');
    Route::put('updateProduct/{id}', 'updateProduct');
});

Route::post('newSale',[SaleController::class,'newSale']);
Route::get('getSale',[SaleController::class,'getSale']);
Route::delete('deleteSale/{id}',[SaleController::class,'deleteSale']);

// Route::delete('deleteProduct', [ProductController::class, 'deleteProduct']);
