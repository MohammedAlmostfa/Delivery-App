<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RestaurantController;
use App\Models\Restaurant;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Email verification routes
Route::post('/verify-email', [AuthController::class, 'verify']); // Verifies user's email
Route::post('/resendCode', [AuthController::class, 'resendCode']); // Resends the verification code


Route::post('/changePassword', [ForgetPasswordController::class, 'changePassword']); // Handles password change
Route::post('/checkEmail', [ForgetPasswordController::class, 'checkEmail']); // Checks if the email exists for password reset
Route::post('/checkCode', [ForgetPasswordController::class, 'checkCode']); // Verifies a password reset code

Route::middleware('jwt')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::get('/restaurant/near', [RestaurantController::class,'getNearRestauran']);

    Route::apiResource("/restaurant", RestaurantController::class);
    Route::put("/restaurant/permanent/{id}", [ RestaurantController::class,'permanentDelete']);
    Route::put("/restaurant/rstour/{id}", [ RestaurantController::class,'permanentDelete']);

    Route::apiResource("/meal", MealController::class);
    Route::post("/meal/permanent/{id}", [ MealController::class,'permanentDelete']);
    Route::post("/meal/restore/{id}", [ MealController::class,'restore']);
    Route::apiResource("/offer", OfferController::class);



});
// Change password routes
