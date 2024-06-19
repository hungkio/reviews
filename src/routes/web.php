<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\QueueManagementController;
use App\Http\Controllers\Apps\ReviewsController;
use App\Http\Controllers\Apps\ReviewDestinationController;
use App\Http\Controllers\Apps\WidgetManagementController;
use App\Http\Controllers\Apps\MailController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewRequestController;
use App\Http\Controllers\FrequencyController;

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
    Route::post('/edit-profile', [DashboardController::class, 'update'])->name('edit-profile');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);

    });

    Route::name('manage.')->group(function () {
        Route::resource('/manage/queue', QueueManagementController::class);
        Route::post('/manage/queue/update-status', [QueueManagementController::class, 'updateStatus']);
        Route::resource('/manage/widget', WidgetManagementController::class);
        Route::resource('/manage/form', StripeController::class);
        Route::resource('/manage/reviews', ReviewsController::class);
        Route::post('/manage/reviews/update-status', [ReviewsController::class, 'updateStatus']);
        Route::post('/manage/reviews/update-order', [ReviewsController::class, 'updateOrder']);
        Route::post('/manage/reviews/update-multiple-status', [ReviewsController::class, 'updateMultipleStatus']);
        Route::post('/manage/form/save', [StripeController::class, 'saveInformation']);
    });


    Route::name('settings.')->group(function () {
        Route::resource('/settings/review-destination', ReviewDestinationController::class);
        Route::post('/settings/review-destination/save', [ReviewDestinationController::class, 'saveSetting']);
        Route::resource('/settings/frequency', FrequencyController::class)->only(['index', 'store'])->names([
            'index' => 'frequency.index',
            'store' => 'frequency.store',
        ]);
    });

    Route::post('/send-mail-queue', [MailController::class, 'sendEmailQueue'])->name('send-mail-queue');
    Route::get('/save-customer', [MailController::class, 'insertCustomers']);
    Route::get('/preview/wall', [WidgetManagementController::class, 'previewWall']);
    Route::get('/preview/badge', [WidgetManagementController::class, 'previewBadge']);
    Route::get('/preview/toast', [WidgetManagementController::class, 'previewToast']);
    Route::get('/preview/carousel', [WidgetManagementController::class, 'previewCarousel']);

    Route::resource('/review-request', ReviewRequestController::class);
    Route::post('/review-request/get-template-info', [ReviewRequestController::class, 'getTemplateInfo']);
    Route::post('/review-request/update', [ReviewRequestController::class, 'update']);
    Route::post('/review-request/delete', [ReviewRequestController::class, 'delete']);

});

Route::get('/send-mail/{emailOrder?}', [MailController::class, 'sendEmail'])->name('send-mail');
Route::post('/webform/store', [ReviewsController::class, 'insertReview'])->name('webform.store');
Route::post('/save-review', [ReviewRequestController::class, 'saveReview'])->name('save-review');
Route::get('/webform/show', [MailController::class, 'show'])->name('webform.show');
Route::resource('/business', BusinessController::class);
Route::post('/webhook_endpoints', [StripeController::class, 'getDataStripe'])->name('stripe');
Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
