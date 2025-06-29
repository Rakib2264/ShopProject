<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;


Route::get('/BrandList', [BrandController::class, 'BrandList']);
Route::get('/ClearAppCache', [MaintenanceController::class, 'ClearAppCache']);
Route::get('/CategoryList', [CategoryController::class, 'CategoryList']);
Route::get('/PolicyByType/{type}', [PolicyController::class,'PolicyByType']);
Route::get('/ListProductByCategory/{id}', [ProductController::class,'ListProductByCategory']);
Route::get('/ListProductByRemark/{remark}', [ProductController::class,'ListProductByRemark']);
Route::get('/ListProductByBrand/{id}', [ProductController::class,'ListProductByBrand']);
Route::get('/ListProductBySlider', [ProductController::class,'ListProductBySlider']);
Route::get('/ListProductBySlider', [ProductController::class,'ListProductBySlider']);
Route::get('/ProductDetailsById/{id}', [ProductController::class,'ProductDetailsById']);
