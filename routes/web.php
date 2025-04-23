<?php

use App\Http\Controllers\admin\BotsController;
use App\Http\Controllers\admin\NichesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/signup', [AuthViewController::class, 'showSignup'])->name('auth.signup');
Route::get('/', [AuthViewController::class, 'showLogin'])->name('auth.login');
Route::get('/forgot-password', [AuthViewController::class, 'showForgot'])->name('auth.forgot');
Route::get('/verify-code', [AuthViewController::class, 'showVerifyCode'])->name('auth.verify');
Route::get('/set-new-password', [AuthViewController::class, 'showNewPassword'])->name('auth.set.password');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'sendResetCode']);
Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::get('/chatbots',[WebsiteController::Class,'bots'])->name('webiste.bots');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('niches',NichesController::class);
    Route::resource('bots',BotsController::class);
});

