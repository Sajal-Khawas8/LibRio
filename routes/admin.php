<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReadersController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::controller(BookController::class)->prefix('books')->name('books.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('create');
        Route::post('/add', 'store')->name('store');
        Route::get('/update/{book:uuid}', 'edit')->name('edit');
        Route::put('/update/{book:uuid}', 'update')->name('update');
        Route::delete('/delete/{book:uuid}', 'destroy')->name('destroy');
        Route::get('/rented-books', 'rentedBooks')->name('rented');
    });

    Route::controller(CategoryController::class)->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'create')->name('create');
        Route::post('/add', 'store')->name('store');
        Route::get('/update/{category}', 'edit')->name('edit');
        Route::patch('/update/{category}', 'update')->name('update');
        Route::delete('/delete/{category}', 'destroy')->name('destroy');
    });

    Route::controller(ReadersController::class)->prefix('readers')->name('readers.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/block/{user:uuid}', 'destroy')->name('block');
    });

    
    Route::get('/payment', [PaymentController::class, 'index'])->name('payments');

    Route::controller(ProfileController::class)->prefix('settings')->name('settings.profile.')->group(function (){
        Route::get('/', 'show')->name('show');
        Route::get('/update', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::delete('/delete', 'destroy')->name('delete');
    });

    Route::controller(AdminController::class)->group(function (){
        Route::prefix('team')->name('team.')->group(function(){
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
        });
        Route::middleware('can:modify-admin-status')->group(function (){
            Route::patch('/make-super-admin/{user:uuid}', 'makeSuperAdmin')->name('makeSuperAdmin');
            Route::patch('/remove-super-admin/{user:uuid}', 'removeSuperAdmin')->name('removeSuperAdmin');
            Route::delete('/remove-admin/{user:uuid}', 'removeAdmin')->name('removeAdmin');
        });

    });
});