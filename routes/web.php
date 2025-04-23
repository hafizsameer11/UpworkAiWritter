<?php

use App\Http\Controllers\admin\BotsController;
use App\Http\Controllers\admin\NichesController;
use App\Http\Controllers\admin\ProjectsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\WebsiteController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
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

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('/chatbots', [WebsiteController::class, 'bots'])->name('webiste.bots');
    Route::get('/CreateProposal/{id}', [WebsiteController::class, 'chatCan'])->name('webiste.chatCan');
    Route::get('/logout', [WebsiteController::class, "logout"])->name('auth.logout');
});

Route::middleware( AdminMiddleware::class)->group(function () {
    Route::get('admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('admin/niches', NichesController::class);
    Route::resource('admin/bots', BotsController::class);
    Route::resource('admin/projects', ProjectsController::class);
});
