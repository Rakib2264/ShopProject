<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// // Payment // No Auth / ID/TrxID/Invoice // Auth // Rate Limiting
// Route::get('/PaymentCreate/{id}', [PaymentController::class,'PaymentCreate']);

// // CSRF Disable / Rate Limiting  / No Auth / ID/TrxID/Invoice // Auth
// Route::post('/PaymentSuccess', [PaymentController::class,'PaymentSuccess']);
// Route::post('/PaymentCancel', [PaymentController::class,'PaymentCancel']);
// Route::post('/PaymentFail', [PaymentController::class,'PaymentFail']);

Route::post('/PaymentIPN', [PaymentController::class,'PaymentIPN']);