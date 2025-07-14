<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowRequestController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\AdminRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserBorrowController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/admin', function () {
    return view('admindashboard');
})->name('admindashboard');

Route::get('/adminabout', function () {
    return view('adminabout');
})->name('adminabout');

Route::post('/borrow-request/{serialNumber}', [UserBorrowController::class, 'requestBorrow'])->name('borrow.request');

Route::post('/admin/accept-request/{id}', [DashboardController::class, 'acceptRequest'])->name('admin.accept-request');

Route::post('/admin/confirm-return/{id}', [DashboardController::class, 'confirmReturn'])->name('admin.confirm-return');

Route::get('/register', function () {
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:web')->get('/user.dashboard', function () {
    return view('user.dashboard'); // or your actual user dashboard view
})->name('user.dashboard');

Route::middleware('auth:admin')->get('/admin.dashboard', function () {
    return view('admin.dashboard'); // or your actual admin dashboard view
})->name('admin.dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/browse', [UserBorrowController::class, 'browse'])->name('user.browse');
Route::post('/borrow-request/{serial_number}', [UserBorrowController::class, 'requestBorrow'])->name('borrow.request');

Route::delete('/admins/{id}', [AdminRegisterController::class, 'destroy'])->name('admin.delete');
Route::get('/browse-admins', [AdminRegisterController::class, 'browse'])->name('admins.browse');
Route::get('/admins', [AdminRegisterController::class, 'index'])->name('admins.index');


Route::get('/forgot-password', function () {
    return view('auth.forgot_password'); 
})->name('forgot.password');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])->name('forgot.password.send');

Route::get('/reset-password-form', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/accept-requests', [DashboardController::class, 'showPendingRequests'])->name('admin.acceptRequests');
    Route::post('/admin/accept-request/{id}', [DashboardController::class, 'acceptRequest'])->name('admin.acceptRequest');
    Route::get('/admin/return-requests', [DashboardController::class, 'showReturnRequests'])->name('admin.returnRequests');
    Route::post('/admin/confirm-return/{id}', [DashboardController::class, 'confirmReturn'])->name('admin.confirmReturn');
    Route::get('/admin/request-history', [DashboardController::class, 'showRequestHistory'])->name('admin.requestHistory');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/user/my-borrowings', [UserBorrowController::class, 'showMyBorrowings'])->name('user.myBorrowings');
    Route::post('/user/return-item/{id}', [UserBorrowController::class, 'returnItem'])->name('user.returnItem');
});

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/announcements/user', function () {
    return view('announcements.user_index');
})->name('announcements.user_index');

Route::get('/announcements/user', [AnnouncementController::class, 'userIndex'])->name('announcements.user_index');
Route::get('/user/announcements', [AnnouncementController::class, 'userView'])->name('user.announcements');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::resource('announcements', AnnouncementController::class);


Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

Route::get('/', function () {
    return view('home');
});