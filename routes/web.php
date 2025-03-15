<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WhatsAppController;

Route::get('/', [WhatsAppController::class, 'index']);
Route::post('whatsapp', [WhatsAppController::class, 'store']);
