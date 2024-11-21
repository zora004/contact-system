<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::get('/login', 'index');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);

    Route::resource('/users', UserController::class);
    Route::post('/users/restore/{user}', [UserController::class, 'restore']);
    Route::post('/search/user', [UserController::class, 'search'])->name('user.search');

    Route::resource('/contacts', ContactController::class);
    Route::post('/contacts/restore/{contact}', [ContactController::class, 'restore']);
    Route::post('/search/contacts', [ContactController::class, 'search'])->name('contact.search');

    Route::post('/logout', [AuthController::class, 'logout']);
});
