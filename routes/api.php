<?php

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'auth']);
Route::middleware('auth:api')->group(function(){
    Route::apiResource('customer', CustomersController::class)->except('create','edit');
    Route::apiResource('address', AddressesController::class)->except('create','edit');
});

// if routing !found
Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => 'Not Found'
    ],404);
});

