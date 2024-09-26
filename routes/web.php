<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerTicketController;
use App\Http\Controllers\Customer\TicketController as ControllersCustomerTicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update/{id}', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/profile/password/update/{id}', [UserController::class, 'passwordUpdate'])->name('profile.password.update');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('/tickets', TicketController::class);
        Route::get('/ticket/status/update/{id}', [TicketController::class, 'updateStatus'])->name('tickets.update.status');
        Route::post('/ticket/response/update/{id}', [TicketController::class, 'respond'])->name('tickets.response');

        Route::resource('/categories', CategoryController::class);
        Route::get('/category/status/update/{id}', [CategoryController::class, 'updateStatus'])->name('category.update.status');

        Route::resource('/labels', LabelController::class);
        Route::get('/label/status/update/{id}', [LabelController::class, 'updateStatus'])->name('label.update.status');

        Route::resource('/customers', AdminCustomerController::class);
    });


    Route::middleware('customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
        Route::resource('/tickets', ControllersCustomerTicketController::class);
        Route::post('/ticket/response/update/{id}', [ControllersCustomerTicketController::class, 'respond'])->name('tickets.response');

    });
});
