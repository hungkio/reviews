<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\QueueManagementController;
use App\Http\Controllers\Apps\ReviewDestinationController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);

    });

    Route::name('manage.')->group(function () {
        Route::resource('/manage/queue', QueueManagementController::class);
    });


    Route::name('settings.')->group(function () {
        Route::resource('/settings/review-destination', ReviewDestinationController::class);
        Route::post('/settings/review-destination/save', [ReviewDestinationController::class, 'saveSetting'])->name('settings.save-review-destination');
    });

});

Route::resource('/business', BusinessController::class);
Route::post('/webhook_endpoints', [StripeController::class, 'getDataStripe'])->name('stripe');
Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
