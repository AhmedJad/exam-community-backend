<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Tymon\JWTAuth\Facades\JWTAuth;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::controller(AuthController::class)->prefix("auth")->group(function () {
    Route::post("register", "register");
    Route::post("login", "login");
    Route::get("verify-token", "verifyToken");
    Route::post("verify-email", "verifyEmail");
    Route::get("resend-verification-code", "resendVerificationCode");
    Route::get("user-verified", "userVerified");
    Route::get('forget-password/{user:email}', "forgetPassword");
    Route::post('reset-password', "resetPassword");
    Route::get("logout", "logout");
    Route::post('edit-image', "editImage");
    Route::delete('delete-image', "deleteImage");
    Route::get('current-user', "getCurrentUser");
});
