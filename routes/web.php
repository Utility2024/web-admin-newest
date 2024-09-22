<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrScannerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/get-employee-details', [RegisterController::class, 'getEmployeeDetails']);

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('reset-password', [PasswordResetController::class, 'reset'])
    ->name('password.update');

// Add authentication middleware to the routes for QrScannerController
Route::middleware('auth')->group(function () {
    Route::get('/scanner', [QrScannerController::class, 'index'])->name('indexScanner');
    Route::get('/qr-scanner', [QrScannerController::class, 'getData'])->name('getData');
    Route::get('/download-pdf', [QrScannerController::class, 'downloadDocument'])->name('downloadDocument');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
