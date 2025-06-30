<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController;

// 🌐 Welcome Page for Guests
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
    ]);
});

// 🔐 Authenticated Routes
Route::middleware(['auth'])->group(function () {

    // 👤 Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📋 Appointment Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', fn() => Inertia::render('AddAppointment'))->name('appointments.create');
    Route::get('/appointments/completed', [AppointmentController::class, 'completed'])->name('appointments.completed');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::put('/appointments/{appointment}/complete', [AppointmentController::class, 'markComplete'])->name('appointments.complete');

});

// 🔐 Auth scaffolding (login, register, etc.)
require __DIR__ . '/auth.php';
