<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('admin/login', [AdminController::class, 'login']);

Route::prefix('admin')->middleware('auth.jwt')->group(function () {

    // Available Times CRUD
    Route::get('/available-times', [AdminController::class, 'getAllAvailableTimes']);
    Route::post('/create-available-time', [AdminController::class, 'createAvailableTime']);
    Route::put('/available-time/{id}', [AdminController::class, 'updateAvailableTime']);
    Route::delete('/available-time/{id}', [AdminController::class, 'deleteAvailableTime']);

    // Appointments CRUD
    Route::get('/appointments', [AdminController::class, 'getAllAppointments']);
    Route::post('/create-appointment', [AdminController::class, 'createAppointment']);
    Route::put('/appointment/{id}', [AdminController::class, 'updateAppointment']);
    Route::delete('/appointment/{id}', [AdminController::class, 'deleteAppointment']);
    Route::post('/appointment/{appointmentId}/complete', [AdminController::class, 'completeExamination']);
});


Route::prefix('user')->group(function () {
    Route::post('/send-otp', [UserController::class, 'sendOtp']);
    Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
    Route::get('/doctor/{doctorId}/available-times', [UserController::class, 'getAvailableTimes']); // النهاية الجديدة
   
    Route::middleware('auth.jwt')->group(function () {
        Route::post('/book-appointment', [UserController::class, 'bookAppointment']);
        Route::delete('/cancel-appointment/{appointmentId}', [UserController::class, 'cancelAppointment']);
    });
});
