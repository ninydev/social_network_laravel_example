<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\UploadUserAvatarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register', RegisterController::class)->name('api.auth.register');
Route::post('auth/login', LoginController::class)->name('api.auth.login');

Route::group(['middleware' => ['auth:api'], 'prefix' => 'profile'], function () {
    Route::post('/avatar', UploadUserAvatarController::class)->name('profile.avatar.upload');
});

