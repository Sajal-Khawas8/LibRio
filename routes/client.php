<?php

use App\Http\Controllers\Client\BookController;
use App\Http\Controllers\Client\BookHistoryController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\RentController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;
 
Route::middleware('client')->name('client.')->group(function () {
    Route::controller(BookController::class)->name('books.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/book/{book:uuid}', 'show')->whereUuid('book')->name('show');
    });

    Route::controller(UserController::class)->group(function () {
        Route::middleware('guest')->prefix('/register')->name('register.')->group(function () {
            Route::get('/', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
    });

    Route::middleware('auth')->group(function (){
        Route::controller(UserController::class)->name('user.')->group(function () {
            Route::get('/settings', 'show')->name('show');
            Route::get('/update', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('destroy');
        });

        Route::controller(CartController::class)->prefix('/cart')->name('cart.')->group(function (){
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/', 'destroy')->name('destroy');
        });

        Route::controller(RentController::class)->name('payment.')->group(function (){
            Route::post('/initiate-payment', 'initiatePayment')->name('initiate');
            Route::post('/accept-payment', 'acceptPayment')->name('accept');
        });

        Route::controller(BookHistoryController::class)->name('myBooks.')->group(function (){
            Route::get('/my-books', 'index')->name('index');
            Route::get('/return-book/{book:uuid}', 'show')->whereUuid('book')->name('return');
            Route::post('/return-book/{book:uuid}', 'return')->whereUuid('book')->name('return');
            Route::post('/fine', 'fine')->name('fine');
            Route::get('/rent-history/{book:uuid}', 'history')->whereUuid('book')->name('history');
        });
    });
});