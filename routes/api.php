<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamAdminController;
use App\Models\Exam;

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
Route::controller(ExamAdminController::class)->prefix("exams")->group(function () {
    Route::get("/", "getExams");
    Route::get("{parentId}", "getChildren");
    Route::post("create", "create");
    Route::put("rename", "rename");
    Route::put("/", "editExam");
    Route::delete("delete/{id}", "delete");
});
