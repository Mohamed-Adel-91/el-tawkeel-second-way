<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarInfoFeatureController;
use App\Http\Controllers\Admin\CarInteriorController;
use App\Http\Controllers\Admin\InstallmentOrderController;
use App\Http\Controllers\Admin\KnowMoreController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarTermController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ShapeController;
use App\Http\Controllers\Admin\ServiceCenterController;
use App\Http\Controllers\Admin\FeatureCategoryController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\InstallmentProgramController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\InsuranceOrderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CarExteriorController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\WriterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can find all the admin routes for the admin panel.
|
*/

/***************************** ADMIN ROUTES **********************************/

Route::group(['prefix' => 'dashboard', 'as' => 'admin.'], function () {
    Route::group(['middleware' => ['guest:admin', 'throttle:10,1']], function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login_page');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login/verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
    });
    Route::group(['middleware' => ['AuthPerson:admin']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('update', [ProfileController::class, 'update'])->name('update');
            Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('updatePassword');
            Route::post('verify-otp', [ProfileController::class, 'verifyPasswordOtp'])->name('verifyPasswordOtp');
        });

        Route::middleware('role:1')->group(function () {
            Route::resource('admins', AdminController::class)->except(['show']);
            Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');
            Route::get('activity-logs/download', [ActivityLogController::class, 'download'])->name('activity_logs.download');
        });

        Route::post('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggle-status');
        Route::resource('brands', BrandController::class)->except(['show']);
        Route::resource('seo_metas', SeoMetaController::class)->except(['show']);
        Route::resource('banks', BankController::class)->except(['show']);
        Route::resource('car_models', CarModelController::class)->except(['show']);
        Route::post('car_terms/{car_term}/toggle-status', [CarTermController::class, 'toggleStatus'])->name('car_terms.toggle-status');
        Route::post('car_terms/{car_term}/duplicate', [CarTermController::class, 'duplicate'])->name('car_terms.duplicate');
        Route::get('car_terms/export', [CarTermController::class, 'export'])->name('car_terms.export');
        Route::resource('car_terms', CarTermController::class)->except(['show']);
        Route::resource('colors', ColorController::class)->except(['show']);
        Route::resource('shapes', ShapeController::class)->except(['show']);
        Route::resource('service_centers', ServiceCenterController::class)->except(['show']);
        Route::resource('feature_categories', FeatureCategoryController::class)->except(['show']);
        Route::get('features/export', [FeatureController::class, 'export'])->name('features.export');
        Route::resource('features', FeatureController::class)->except(['show']);
        Route::resource('installment_programs', InstallmentProgramController::class)->except(['show']);
        Route::resource('installment_orders', InstallmentOrderController::class);
        Route::resource('insurances', InsuranceController::class)->except(['show']);
        Route::resource('insurance_orders', InsuranceOrderController::class);
        Route::resource('know_more', KnowMoreController::class)->except(['show']);
        Route::resource('car_exteriors', CarExteriorController::class)->except(['show']);
        Route::resource('car_interiors', CarInteriorController::class)->except(['show']);
        Route::resource('car_info_features', CarInfoFeatureController::class)->except(['show']);
        Route::resource('videos', VideoController::class)->except(['show']);
        Route::resource('writers', WriterController::class)->except(['show']);
        Route::resource('news', NewsController::class)->except(['show']);

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/newsletter', [NewsLetterController::class, 'index'])->name('newsletter.index');
        Route::get('/newsletter/download', [NewsLetterController::class, 'download'])->name('newsletter.download');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
});
