<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('booking.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $appointments = [];
        if (auth()->user()->is_admin) {
            $appointments = \App\Models\Appointment::with(['hairdresser', 'user'])->orderBy('appointment_date', 'asc')->orderBy('start_time', 'asc')->get();
        } else {
            $appointments = \App\Models\Appointment::with('hairdresser')->where('user_id', auth()->id())->orderBy('appointment_date', 'asc')->orderBy('start_time', 'asc')->get();
        }
        return view('dashboard', compact('appointments'));
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking
    Route::get('/booking', [\App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/slots', [\App\Http\Controllers\BookingController::class, 'fetchSlots'])->name('booking.slots');
    Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
    
    // Admin Delete
    Route::delete('/appointments/{appointment}', function(\App\Models\Appointment $appointment) {
        if(auth()->user()->is_admin) {
            $appointment->delete();
            return back()->with('success', 'Appointment deleted.');
        }
        abort(403);
    })->name('appointments.destroy');
});

require __DIR__.'/auth.php';
