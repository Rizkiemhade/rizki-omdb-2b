<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('auth.login');
// });
// Route::get('/register', function () {
//     return view('auth.register');
// });

// Route::get('/dashboard', function () {
//     return view('controlpanel.dashboard');
// });

// Route::get('/My', function () {
//     return view('controlpanel.My');
// });


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');

Route::get('/controlpanel', function () {
    return view('controlpanel.index');
});