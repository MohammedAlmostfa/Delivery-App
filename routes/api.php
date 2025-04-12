<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Auth\ForgetPasswordController;

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

// ==================== Public Routes (No Authentication) ====================

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']); // User registration
Route::post('/login', [AuthController::class, 'login']); // User login

// Email Verification Routes
Route::post('/verify-email', [AuthController::class, 'verify']); // Verify user's email with code
Route::post('/resendCode', [AuthController::class, 'resendCode']); // Resend verification code

// Password Reset Routes
Route::post('/checkEmail', [ForgetPasswordController::class, 'checkEmail']); // Check if email exists for password reset
Route::post('/checkCode', [ForgetPasswordController::class, 'checkCode']); // Verify password reset code
Route::post('/changePassword', [ForgetPasswordController::class, 'changePassword']); // Change user password

// ==================== Protected Routes (JWT Authentication Required) ====================
Route::middleware('jwt')->group(function () {

    // User Profile Routes
    Route::get('/user', [AuthController::class, 'getUser']); // Get authenticated user data
    Route::put('/user', [AuthController::class, 'updateUser']); // Update user profile
    Route::post('/logout', [AuthController::class, 'logout']); // Logout user (invalidate token)

    // Restaurant Routes
    Route::get('/restaurant/near', [RestaurantController::class, 'getNearRestaurant']); // Get nearby restaurants (typo fixed)
    Route::apiResource("/restaurant", RestaurantController::class); // Standard CRUD for restaurants
    Route::put("/restaurant/permanent/{id}", [RestaurantController::class, 'permanentDelete']); // Permanent delete (soft delete reversal)
    Route::put("/restaurant/restore/{id}", [RestaurantController::class, 'restore']); // Restore soft-deleted restaurant (typo fixed)

    // Meal Routes
    Route::apiResource("/meal", MealController::class); // Standard CRUD for meals
    Route::post("/meal/permanent/{id}", [MealController::class, 'permanentDelete']); // Permanent delete (soft delete reversal)
    Route::post("/meal/restore/{id}", [MealController::class, 'restore']); // Restore soft-deleted meal

    // Offer Routes
    Route::apiResource("/offer", OfferController::class); // Standard CRUD for offers

    // Order Routes (Corrected: Previously pointed to OfferController)
    Route::apiResource("/order", OrderController::class); // Standard CRUD for orders
});
