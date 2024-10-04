<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangayHealthWorkerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\ChatController;
use OpenAI\Laravel\Facades\OpenAI;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::view('/', 'auth/login')->name('login.page');

Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'postForgotPassword'])->name('password.email');

// Reset Password Routes
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'getResetPassword'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'postResetPassword'])->name('password.update');

Route::get('/reload-captcha', [App\Http\Controllers\Auth\RegisterController::class, 'reloadCaptcha']);
Route::post('/accept-cookie-consent', [CookieConsentController::class, 'acceptConsent'])->name('accept.cookie.consent');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/chat', [ChatController::class, 'getAIResponse']);
Route::get('/chat', [ChatController::class, 'processChat']);
Route::get('/chat', [ChatController::class, 'chat']);
Route::post'/chat', [ChatController::class, 'sendMessage']);
Route::get('/chat', [ChatController::class, 'handleChat'])->name('chat.handle');
// In routes/web.php or routes/api.php





Route::group(['middleware' => 'auth'], function () {
    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('admin/feminine-list', [AdminController::class, 'feminineList']);
        Route::get('admin/feminine-data', [AdminController::class, 'feminineData']);
        Route::get('admin/pie-chart-data', [AdminController::class, 'pieChartData']);
        Route::get('/admin/menstrual-cycle-prediction', [AdminController::class, 'menstrualCyclePrediction']);
        Route::get('admin/graph-data', [AdminController::class, 'graphData']);
        Route::post('admin/new-feminine', [AdminController::class, 'postnewfeminine']);
        Route::post('admin/confirm-feminine', [AdminController::class, 'confirmFeminine']);
        Route::post('/admin/confirm-health-worker', [AdminController::class, 'confirmHealthWorker'])->name('confirmHealthWorker');
        Route::post('admin/update-feminine', [AdminController::class, 'postFeminine']);
        Route::post('admin/delete-feminine', [AdminController::class, 'deleteFeminie']);
        Route::post('admin/post-seen/period-notification', [AdminController::class, 'postSeenPeriodNotification']);

        Route::get('admin/calendar', [AdminController::class, 'calendarIndex']);
        Route::get('admin/calendar-data', [AdminController::class, 'calendarData']);

        Route::get('admin/account-settings', [AdminController::class, 'accountSettings']);
        Route::get('admin/account-data', [AdminController::class, 'accountData']);
        Route::post('admin/account-reset', [AdminController::class, 'accountReset']);

        Route::get('admin/health-worker', [AdminController::class, 'healthWorkerIndex']);
        Route::get('admin/health-worker-data', [AdminController::class, 'healthWorkerData']);
        Route::get('admin/health-worder/feminine-list', [AdminController::class, 'healthWorkerFeminineList']);
        Route::post('admin/post-health-worker', [AdminController::class, 'postnewhbw']);
        Route::post('/admin/health-worker/add', [AdminController::class, 'addHealthWorker'])->name('admin.addHealthWorker');
        Route::post('admin/update-health-worker', [AdminController::class, 'postHealthWorker']);
        Route::post('admin/delete-health-worker', [AdminController::class, 'deleteHealthWorker']);
        Route::post('admin/health-worker/post-assign-feminine', [AdminController::class, 'postAssignFeminine']);
        Route::post('admin/health-worker/delete-assign-feminine', [AdminController::class, 'deleteAssignFeminine']);
    });

    // User Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        Route::get('user/esimated-next-period', [UserController::class, 'estimatedNextPeriod']);
        Route::get('user/calendar/menstruation-periods', [UserController::class, 'menstruationCalendarPeriod']);

        Route::get('user/menstrual', [UserController::class, 'menstrualIndex']);
        Route::get('user/menstrual-data', [UserController::class, 'menstrualData']);
        Route::post('user/post-menstruation-period', [UserController::class, 'postMenstruationPeriod']);
        Route::post('user/update-menstruation-period', [UserController::class, 'updateMenstruationPeriod']);
        Route::post('user/delete-menstruation-period', [UserController::class, 'deleteMenstruationPeriod']);

        Route::get('user/profile', [UserController::class, 'profileIndex']);
        Route::post('user/update-profile', [UserController::class, 'updateProfile']);
        Route::post('user/change-password', [UserController::class, 'changePassword']);
        Route::post('/user/auto-add-period', [UserController::class, 'autoAddPeriod']);

    });

// Health Worker Routes
    Route::middleware(['role:health_worker'])->group(function () {
    Route::get('health-worker/dashboard', [BarangayHealthWorkerController::class, 'index'])->name('health-worker.dashboard');
    Route::get('health-worker/feminine-list', [BarangayHealthWorkerController::class, 'feminineList']);
    Route::get('health-worker/feminine-data', [BarangayHealthWorkerController::class, 'feminineData']);
    Route::get('health-worker/assign-feminine-list', [BarangayHealthWorkerController::class, 'healthWorkerFeminineList']);
    Route::post('health-worker/new-feminine', [BarangayHealthWorkerController::class, 'postnewfeminine']);
    Route::post('health-worker/update-feminine', [BarangayHealthWorkerController::class, 'postFeminine']);
    Route::post('health-worker/delete-feminine', [BarangayHealthWorkerController::class, 'deleteFeminie']);
    Route::post('health-worker/post-assign-feminine', [BarangayHealthWorkerController::class, 'postAssignFeminine']);

    Route::get('health-worker/calendar', [BarangayHealthWorkerController::class, 'calendarIndex']);
    Route::get('health-worker/calendar-data', [BarangayHealthWorkerController::class, 'calendarData']);
    
    Route::get('health-worker/account', [BarangayHealthWorkerController::class, 'accountSettings']);
    Route::post('health-worker/update-profile', [BarangayHealthWorkerController::class, 'updateProfile']);
    Route::post('health-worker/change-password', [BarangayHealthWorkerController::class, 'changePassword']);

    Route::get('health-worker/pie-chart-data', [BarangayHealthWorkerController::class, 'pieChartData']);
    // In routes/web.php or routes/api.php
    Route::get('/health-worker/forecast', [BarangayHealthWorkerController::class, 'generateAdvancedForecastData']);


});

});
