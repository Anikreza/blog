<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\ProfileController;
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

Route::group([
    'prefix' => 'v1/auth',
    'namespace' => 'Api'
], function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/forgot-password", [AuthController::class, 'forgotPassword']);
    Route::post("/token-verification", [AuthController::class, 'tokenVerification']);
    Route::post("/reset-password", [AuthController::class, 'resetPassword']);
});

Route::group([
    'middleware' => ['auth:sanctum'],
    "prefix" => "v1",
    'namespace' => 'Api'
], function () {
    Route::post("/auth/logout", [AuthController::class, "logout"]);
    Route::post("/auth/save-profile", [ProfileController::class, "update"]);
    Route::post("/email-update", [ProfileController::class, "emailUpdate"]);
    Route::post("/update-password", [ProfileController::class, "passwordUpdate"]);
});
