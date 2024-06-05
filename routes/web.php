<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordConfirmationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PromoCodeController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/', [ProfileController::class, 'profileForHome'])
    ->name('home');
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password', [ResetPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'store'])
        ->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::any('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, '__invoke'])
        ->name('verification.send');

    Route::get('/confirm-password', [PasswordConfirmationController::class, 'show'])
        ->name('password.confirm');

    Route::post('/confirm-password', [PasswordConfirmationController::class, 'store']);
});
Route::get('login', [LoginController::class,'login'])->name('login');
Route::get('сars', [CarController::class, 'CarController'])->name('Cars');
Route::get('services', [ServicesController::class, 'services'])->name('services');
Route::get('services', [ServicesController::class, 'showServices'])->name('services');
Route::post('services.submit', [ServicesController::class, 'submitForm'])->name('services.submitForm');
Route::get('orders', [OrdersController::class, 'orders'])->name('orders');
Route::get('/order/form', [OrderController::class, 'showOrderForm'])->name('pages.order.form');
Route::get('profile', [ProfileController::class, 'profile'])->name('profile');


// тут ордера
// Show order form
Route::get('order/form', [OrderController::class, 'showOrderForm'])->name('order/form');

// Store order
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('store', [OrderController::class, 'store'])->name('order.ch');
// Show order details
Route::get('order/{id}', [OrderController::class, 'showOrderForm'])->name('order.show');

// Page for payment



Route::any('/payment/calculateTotal', [PaymentController::class, 'calculateTotal'])->name('payment.calculateTotal');
Route::any('/payment/placeOrder', [PaymentController::class, 'placeOrder'])->name('payment.placeOrder');
Route::any('/payment', [PaymentController::class, 'showForm'])->name('payment.show');
Route::any('/paymen', [PaymentController::class, 'calculateTotal'])->name('payment.calculateTotal');
Route::any('/show', [PaymentController::class, 'show'])->name('payment.sho');
// Home route
Route::get('/', [ProfileController::class, 'profileForHome'])
    ->name('home');
Route::middleware(['web', 'auth'])->group(function () {
Route::get('/show', [PaymentController::class, 'show'])->name('payment.sho');
     Route::get('/cars/showactivecar', [CarController::class, 'setActive'])->name('cars.setActive');
     Route::get('show_active_car', [OrderController::class, 'showActiveCar'])->name('cars.show_active_car');
});
Route::middleware(['auth'])->group(function () {
    Route::post('checkExistingOrder', [OrderController::class, 'checkExistingOrder'])->name('checkExistingOrder');
    Route::post('saveserviceId', [OrderController::class, 'saveserviceId'])->name('save-serviceId');
    Route::post('savecardatetime', [OrderController::class, 'saveCarDateTime'])->name('savecardatetime');
    Route::get('savecardatetime', [OrderController::class, 'saveCarDateTime'])->name('savecardatetime');
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/cars/store', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/edit/{car}', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/update/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::put('/cars/set-active/{car}', [CarController::class, 'setActive'])->name('cars.setActive');
    Route::delete('/cars/delete/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::get('/payment-methods', [PaymentMethodController::class, 'index']);
    Route::get('orders', [OrdersController::class, 'orders'])->name('orders');
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::get('services', [ServicesController::class, 'services'])->name('services');
Route::get('services', [ServicesController::class, 'showServices'])->name('services');
});
Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create.form');
//Головна машина метод пут вище впринципі все можли вверх додати але навіщо)
Route::get('cars/set-active/{car}', [CarController::class,'setActive'])->name('cars.setActive');
Route::post('cars/set-active/{car}', [CarController::class,'setActive'])->name('cars.setActive');
// Профіль додатково
Route::post('/update-profile', [ProfileController::class,'update'])->name('update-profile');
// Address and Payment Method routes
Route::get('/paymentname/{id}', [PaymentController::class, 'getPaymentMethodName'])->name('getPaymentMethodNameById');
Route::get('/address/{id}', [PaymentController::class, 'getAddressName'])->name('getAddressNameById');
Route::get('/success', [PaymentController::class, 'orderSuccess'])->name('pages.order.success');
//can
Route::get('order/cancel/', 'YourController@cancelOrder')->name('order.cancel');
//Тест
Route::post('ordercreation', [OrderController::class, 'ordercreation'])->name('ordercreation');