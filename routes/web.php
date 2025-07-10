<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserBorrowController;
use App\Http\Controllers\EmployeeController;


//  Homepage
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

// Custom Dashboard Route (UI-based design)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


//  Contact Us Page
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/admin', function () {
    return view('admindashboard');
})->name('admindashboard');

Route::get('/adminabout', function () {
    return view('adminabout');
})->name('adminabout');


Route::get('/register', function () {
    return view('layouts.register_type');
})->name('register_type');

Route::get('/user_register', function () {
    return view('user_register');
})->name('user_register');

Route::get('/admin_register', function () {
    return view('admin_register');
})->name('admin_register');


Route::get('/forgot_password', function () {
    return view('forgot_password');
})->name('forgot_password');

Route::resource('items', ItemController::class);

Route::post('/user_register', [UserRegisterController::class, 'store'])->name('user.register');
Route::post('/admin_register', [AdminRegisterController::class, 'store'])->name('admin.register');


// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Dashboards
Route::middleware('auth:web')->get('/user.dashboard', function () {
    return view('user.dashboard'); // or your actual user dashboard view
});

Route::middleware('auth:admin')->get('/admin.dashboard', function () {
    return view('admin.dashboard'); // or your actual admin dashboard view
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/browse', [UserBorrowController::class, 'browse'])->name('user.browse');
Route::post('/borrow-request/{serial_number}', [UserBorrowController::class, 'requestBorrow'])->name('borrow.request');


Route::delete('/admins/{id}', [AdminRegisterController::class, 'destroy'])->name('admin.delete');
Route::get('/browse-admins', [AdminRegisterController::class, 'browse'])->name('admins.browse');
Route::get('/admins', [AdminRegisterController::class, 'index'])->name('admins.index');