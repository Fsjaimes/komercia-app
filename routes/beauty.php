<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Beauty\DashboardController;
use App\Http\Controllers\Beauty\ClientController;
use App\Http\Controllers\Beauty\ServiceController;
use App\Http\Controllers\Beauty\AppointmentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/beauty', [DashboardController::class, 'index'])->name('beauty.dashboard');

    Route::resource('beauty/clients', ClientController::class)->names('beauty.clients');
    Route::resource('beauty/services', ServiceController::class)->names('beauty.services');
    Route::resource('beauty/appointments', AppointmentController::class)->names('beauty.appointments');
});