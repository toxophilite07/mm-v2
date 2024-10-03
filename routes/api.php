<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController; // Import your controller
use App\Http\Controllers\ChatController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Define the route for checking notifications
Route::get('/check-notifications', [NotificationController::class, 'checkNotifications']);

// Route::post('/chat', [ChatController::class, 'getAIResponse']);
Route::post('/chat', [ChatController::class, 'chat']);
Route::post('/chat', [ChatController::class, 'handleChat'])->name('chat.handle');
