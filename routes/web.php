<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\TokenAuthenticate;


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
Route::get('/ListReviewByProduct/{id}', [ProductController::class,'ListReviewByProduct']);

// Route::get('/SendOTP/{UserEmail}',[UserController::class,'SendOTP']);
// Route::get('/SendOTPLATTER/{UserEmail}',[UserController::class,'SendOTPLATTER']);
// user auth

Route::get('/UserLogin/{UserEmail}',[UserController::class,'UserLogin']);
Route::get('VerifyLogin/{UserEmail}/{OTP}',[UserController::class,'VerifyLogin']);
Route::get('/Logout',[UserController::class,'Logout']);

// user profile
Route::post('/CreateProfile',[ProfileController::class,'CreateProfile'])->Middleware([TokenAuthenticate::class]);
Route::get('/ReadProfile',[ProfileController::class,'ReadProfile'])->Middleware([TokenAuthenticate::class]);

// Review
Route::post('/CreateProductReview',[ProfileController::class,'CreateProductReview'])->Middleware([TokenAuthenticate::class]);