<?php

use App\Http\Controllers\Auth\GuestBroadcastAuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Web\CarsModuleController;
use App\Http\Controllers\Web\InstallmentController;
use App\Http\Controllers\Web\InsuranceController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PagesController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\NewsLetterController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can find all the web routes for the frontend.
|
*/

Route::get('/', function () {
    return redirect(app()->getLocale());
});

/***************************** Frontend ROUTES **********************************/

Route::group(['as' => 'web.'], function () {

    Route::controller(PagesController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/search', 'mobileSearch')->name('search');
        Route::get('/service-centers', 'serviceCenters')->name('service-centers');
        Route::get('/Videos', 'videos')->name('videos');
        Route::get('/faqs', 'faqs')->name('faqs');
        Route::get('/search-result', 'searchResult')->name('search-result');
        Route::get('/brands/{brand}/models', 'modelsByBrand')->name('brands.models');
        Route::get('/models/{car}/terms', 'termsByCar')->name('models.terms');
        Route::get('/price', 'priceForSelection')->name('price');
    });

    Route::controller(CarsModuleController::class)->group(function () {
        Route::get('/new-cars', 'newCars')->name('new-cars');
        Route::get('/car-info/{id}/{slug}', 'carInfo')->name('cars.carinfo');
        Route::get('/brand-car/{id}/{slug}', 'brandCar')->name('cars.brandcar');
        Route::get('/comparison', 'comparison')->name('comparison');
        Route::post('/car-info/{car}/view', 'incrementView')->name('cars.increment-view');
    });

    Route::controller(InsuranceController::class)->group(function () {
        Route::get('/insurance', 'insurance')->name('insurance');
        Route::get('/insurance-form', 'insuranceForm')->name('insurance-form');
        Route::get('/insurance-thanks/{insuranceOrder}', 'thanks')->name('insurance.thanks');
        Route::post('/insurance', 'submitInsurance')->name('insurance.submit')->middleware(['AuthPerson:user']);
    });

    Route::controller(InstallmentController::class)->group(function () {
        Route::get('/installment', 'installment')->name('installment');
        Route::get('/installment-form', 'installmentForm')->name('installment-form');
        Route::post('/installment', 'submitInstallment')->name('installment.submit')->middleware(['AuthPerson:user']);
        Route::get('/installment-thanks/{installmentOrder}', 'thanks')->name('installment.thanks');
    });

    Route::controller(NewsController::class)->group(function () {
        Route::get('/News', 'index')->name('news');
        Route::get('/News/{id}/{slug}', 'details')->name('news.details');
    });

    Route::post('/newsletter', [NewsLetterController::class, 'store'])
        ->name('newsletter.store');

    Route::controller(SocialAuthController::class)->group(function () {
        Route::get('/auth/google/redirect', 'redirectToGoogle')->name('auth.google.redirect');
        Route::get('/auth/google/callback', 'handleGoogleCallback')->name('auth.google.callback');
        Route::get('/auth/facebook/redirect', 'redirectToFacebook')->name('auth.facebook.redirect');
        Route::get('/auth/facebook/callback', 'handleFacebookCallback')->name('auth.facebook.callback');
    });

    Route::group(['middleware' => ['guest:user', 'throttle:10,1']], function () {
        Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');
        Route::get('/signup', [UserAuthController::class, 'showSignUpForm'])->name('signup');
        Route::post('/register', [UserAuthController::class, 'register'])->name('register');
    });


    Route::group(['middleware' => ['AuthPerson:user']], function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');


        Route::controller(OrderController::class)->group(function () {
            Route::get('/booking', 'booking')->name('booking');
            Route::post('/booking/color',  'updateColor')->name('booking.update-color');
            Route::post('/confirm-booking', 'store')->name('confirm-booking.store');
            Route::get('/confirm-booking/{order}', 'confirmBooking')->name('confirm-booking');
            Route::get('/orders/{order}/status', 'status')->name('orders.status');
            Route::get('/orders/{order}/invoice', 'invoice')->name('orders.invoice');
            Route::get('/thanks/{order}', 'thanks')->name('thanks');
            Route::get('/order-details/{order}', 'notPaidThanks')->name('thanks.not-paid');
        });
    });
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/payment/success', 'success')->name('payment.success');
        Route::get('/payment/failed', 'failed')->name('payment.failed');
    });
    //TODO: implement webhook
    Route::post('/payment/webhook/kashier', [PaymentController::class, 'webhook'])->name('payment.webhook');
});

/***************************** Fallback ROUTES **********************************/

Route::post('/broadcasting/auth', [GuestBroadcastAuthController::class, 'authenticate'])
    ->name('broadcast.auth')
    ->middleware(['web'])
    ->withoutMiddleware([Authenticate::class]);

Route::get('clear-cache-migrate', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('migrate', ['--force' => true]);

    dd("✅ All caches cleared, optimizations reset, and migrations run at: " . now()->toDateTimeString());
});

Route::fallback(function () {
    return view('404');
});
