<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file registers API routes for the application.
| Routes are grouped based on authentication requirements.
| Public routes do not require authentication, while protected routes require JWT authentication.
|
*/

// ==================== Public Routes (No Authentication) ====================

/*
| Authentication Routes
| These routes handle user registration and login.
*/

Route::post('/register', [AuthController::class, 'register']); // Register a new user
Route::post('/login', [AuthController::class, 'login']); // Login an existing user

/*
| Email Verification Routes
| Handle verification of user email and resending verification codes.
*/
Route::post('/verify-email', [AuthController::class, 'verify']); // Verify user's email using a code
Route::post('/resendCode', [AuthController::class, 'resendCode']); // Resend a verification code

/*
| Password Reset Routes
| Allow users to reset their passwords.
*/
Route::post('/checkEmail', [ForgetPasswordController::class, 'checkEmail']); // Validate if email exists for password reset
Route::post('/checkCode', [ForgetPasswordController::class, 'checkCode']); // Validate password reset code
Route::post('/changePassword', [ForgetPasswordController::class, 'changePassword']); // Update the user's password

// ==================== Protected Routes (JWT Authentication Required) ====================
Route::middleware('jwt')->group(function () {

    /*
    | User Profile Routes
    | Handle user data retrieval and updates.
    */
    Route::post('/user/setlocation/{user}', [AuthController::class, 'setLocation']); // Update user's location
    Route::get('/user', [AuthController::class, 'getUser']); // Fetch authenticated user details
    Route::put('/user', [AuthController::class, 'updateUser']); // Update user profile data
    Route::post('/logout', [AuthController::class, 'logout']); // Logout user and invalidate JWT token

    /*
    | Restaurant Routes
    | Handle restaurant-related operations.
    */
    Route::get('/restaurant/near', [RestaurantController::class, 'getNearRestaurant']); // Get nearby restaurants
    Route::apiResource("/restaurant", RestaurantController::class); // Standard CRUD operations for restaurants
    Route::put("/restaurant/permanent/{id}", [RestaurantController::class, 'permanentDelete']); // Permanently delete a restaurant (undo soft delete)
    Route::put("/restaurant/restore/{id}", [RestaurantController::class, 'restore']); // Restore a soft-deleted restaurant

    /*
    | Meal Routes
    | Manage meals associated with restaurants.
    */
    Route::get('/meal/randoum', [MealController::class, 'getRandoumMeal']);

    Route::get('/meal/restaurant/{restaurant}', [MealController::class, 'getMeal']);
    Route::apiResource("/meal", MealController::class); // Standard CRUD operations for meals
    Route::post("/meal/permanent/{id}", [MealController::class, 'permanentDelete']); // Permanently delete a meal (undo soft delete)
    Route::post("/meal/restore/{id}", [MealController::class, 'restore']); // Restore a soft-deleted meal

    /*
    | Offer Routes
    | Manage restaurant offers.
    */
    Route::apiResource("/offer", OfferController::class); // Standard CRUD operations for offers

    /*
  | Rating Routes
  | Manage restaurant Rating.
  */
    Route::apiResource("/rating", RatingController::class);

    /*
    | Order Routes
    | Handle customer orders.
    */
    Route::apiResource("/order", OrderController::class); // Standard CRUD operations for orders
});
