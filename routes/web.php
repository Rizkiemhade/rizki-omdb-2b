<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;


//swith language
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
});


//ROUTE

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');


// Route::get('/controlpanel', function () {
//     return view('controlpanel.dashboard');
// });

Route::get('/Favorites', function () {
    return view('panel_control.my');
})->name('favorite');

Route::prefix('panel_control')->middleware('check.login')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});