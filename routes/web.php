<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'sendMessage']);
Route::get('/chat-history', [ChatController::class, 'history']);
Route::post('/chat-clear', [ChatController::class, 'clear']);

