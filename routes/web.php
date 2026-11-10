<?php

use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login')->name('login');
    Route::livewire('/subscription', 'pages::subscription')->name('subscription');
});

Route::middleware('auth')->group(function () {
    Route::livewire('/', 'pages::subscription')->name('home');
    Route::get('/logout', LogoutController::class)->name('logout');
    Route::livewire('/admin/raffle', 'pages::admin.raffle')->middleware('can:admin')->name('admin.raffle');
});
