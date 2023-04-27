<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\OrderController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// http://127.0.0.1:8000/api/register POST
Route::post('/register', [CustomerController::class, 'register']);
// ->middleware('auth:sanctum');
// http://127.0.0.1:8000/api/login POST
Route::post('/login', [CustomerController::class, 'login']);
// http://127.0.0.1:8000/api/update-profile PUT
Route::put('/update-profile', [CustomerController::class, 'updateProfile']);
// http://127.0.0.1:8000/api/orders OK
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
// http://127.0.0.1:8000/api/orders/4 OK
Route::get('/orders/{order}', [OrderController::class, 'show']);
// Route::post('/orders/{order}' , [OrderController::class , 'update']);

// Put
// TODO > The Update
