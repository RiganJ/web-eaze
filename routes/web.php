<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\HomeCleaningController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\LandingController;

Route::get('/', [LandingController::class, 'index']);
/*LAYANAN*/
Route::get('/layanan/laundry', [LaundryController::class, 'index'])
     ->name('laundry.index');
Route::get('/layanan/home-cleaning', [HomeCleaningController::class, 'index'])
    ->name('layanan.homecleaning');     
Route::get('/layanan/detailing', [ServiceController::class, 'detailing'])
    ->name('layanan.detailing');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin/dashboard');
Route::get('/admin/layanan', [AdminLayananController::class, 'index'])
    ->name('admin.layanan');
Route::get('/admin/layanan/{category}', [AdminLayananController::class, 'orders'])
    ->whereIn('category', ['laundry', 'home_cleaning', 'car_wash', 'motor_wash'])
    ->name('admin.layanan.orders');
Route::get('/admin/laporan-keuangan', [ReportController::class, 'index'])
    ->name('admin.report.finance');
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
       
    });
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('layanan/harga', [AdminLayananController::class, 'prices'])->name('layanan.prices');
    Route::post('layanan/harga', [AdminLayananController::class, 'storePrice'])->name('layanan.prices.store');
    Route::put('layanan/harga/{service}', [AdminLayananController::class, 'updatePrice'])->name('layanan.prices.update');
    Route::delete('layanan/harga/{service}', [AdminLayananController::class, 'destroyPrice'])->name('layanan.prices.destroy');
});
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->get('/dashboard', function () {
    return view('admin.dashboard.admin');
})->name('dashboard');

use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\LaundryAdminController;

/* ADMIN */
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/testimoni', [TestimonialController::class, 'index']);
    Route::post('/testimoni/{id}/approve', [TestimonialController::class, 'approve']);
    Route::post('/testimoni/{id}/reject', [TestimonialController::class, 'reject']);
        Route::get('/testimoni/create', [TestimonialController::class, 'create']);
    Route::post('/testimoni', [TestimonialController::class, 'storeAdmin']);

    Route::get('/testimoni/{id}/edit', [TestimonialController::class, 'edit']);
    Route::put('/testimoni/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimoni/{id}', [TestimonialController::class, 'destroy']);
});

/* PUBLIC */
Route::post('/testimoni/kirim', [TestimonialController::class, 'store']);

Route::post('/testimoni/store', [TestimonialController::class, 'store'])->name('testimoni.store');


Route::get('/admin/dashboard', [App\Http\Controllers\Dashboard\AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('laundry')->name('laundry.')->group(function () {

        Route::get('/dashboard', [LaundryAdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/orders', [LaundryAdminController::class, 'orders'])
            ->name('orders');

        Route::get('/orders/create', [LaundryAdminController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [LaundryAdminController::class, 'store'])
            ->name('orders.store');

        Route::get('/orders/{id}', [LaundryAdminController::class, 'show'])
            ->name('orders.show');

        Route::post('/orders/{id}/status', [LaundryAdminController::class, 'updateStatus'])
            ->name('orders.status');
        
        Route::get('/orders/{id}/edit', [LaundryAdminController::class, 'edit'])
            ->name('orders.edit');

        Route::put('/orders/{id}', [LaundryAdminController::class, 'update'])
            ->name('orders.update');

        Route::get('/orders/{order}/send-wa', [LaundryAdminController::class, 'sendWa'])
            ->name('orders.sendWa');

    });

});
use App\Http\Controllers\Admin\HomecleaningAdminController;

// Prefix untuk HomeCleaning admin
Route::prefix('admin/homecleaning')->group(function () {

    // Dashboard HomeCleaning
    Route::get('/dashboard', [HomecleaningAdminController::class, 'dashboard'])
        ->name('homecleaning.dashboard');


});
Route::prefix('admin')->name('admin.')->group(function () {

    // HomeClean Routes
    Route::get('/homecleaning/orders', [HomecleaningAdminController::class, 'orders'])
        ->name('homecleaning.orders');

    Route::get('/homecleaning/orders/create', [HomecleaningAdminController::class, 'create'])
        ->name('homecleaning.orders.create');

    Route::post('/homecleaning/orders', [HomecleaningAdminController::class, 'store'])
        ->name('homecleaning.orders.store');

    Route::post('/homecleaning/orders/{id}/status', [HomecleaningAdminController::class, 'updateStatus'])
        ->name('homecleaning.orders.status');
    Route::get('/homecleaning/orders/{order}/send-wa', [HomecleaningAdminController::class, 'sendWa'])
        ->name('homecleaning.orders.sendWa');
    Route::get('/hommecleaning/orders/{order}', [HomecleaningAdminController::class, 'show'])
        ->name('homecleaning.orders.show');

});


use App\Http\Controllers\Admin\DetailingAdminController;

Route::prefix('admin/detailing')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DetailingAdminController::class, 'dashboard'])
        ->name('detailing.dashboard');

    // Orders
    Route::get('/orders', [DetailingAdminController::class, 'orders'])
        ->name('detailing.orders');

    // Create order (form)
    Route::get('/orders/create', [DetailingAdminController::class, 'create'])
        ->name('detailing.orders.create');

    // Store order (action)
    Route::post('/orders', [DetailingAdminController::class, 'store'])
        ->name('detailing.orders.store'); // Pastikan nama route ini benar

    // Update status order
    Route::post('/orders/{id}/status', [DetailingAdminController::class, 'updateStatus'])
        ->name('detailing.orders.status');
});



use App\Http\Controllers\Admin\CarwashAdminController;

Route::prefix('admin/carwash')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CarwashAdminController::class, 'dashboard'])
        ->name('carwash.dashboard');

    // List Orders
    Route::get('/orders', [CarwashAdminController::class, 'orders'])
        ->name('carwash.orders');

    // Create order (form)
    Route::get('/orders/create', [CarwashAdminController::class, 'create'])
        ->name('carwash.orders.create');

    // Store order (action)
    Route::post('/orders', [CarwashAdminController::class, 'store'])
        ->name('carwash.orders.store');

    // Update status order
    Route::post('/orders/{id}/status', [CarwashAdminController::class, 'updateStatus'])
        ->name('carwash.orders.status');
    Route::get('/orders/{order}/send-wa', [CarwashAdminController::class, 'sendWa'])
        ->name('carwash.orders.sendWa');
    Route::get('/orders/{order}', [CarwashAdminController::class, 'show'])
        ->name('carwash.orders.show');
});

use App\Http\Controllers\Admin\CucianMotorAdminController;

Route::prefix('admin/cucianmotor')->group(function(){
    Route::get('/dashboard', [CucianMotorAdminController::class,'dashboard'])
    ->name('cucianmotor.dashboard');
    Route::get('/orders', [CucianMotorAdminController::class,'orders'])
    ->name('cucianmotor.orders');
    Route::get('/orders/create', [CucianMotorAdminController::class,'create'])
    ->name('cucianmotor.orders.create');
    Route::post('/orders', [CucianMotorAdminController::class,'store'])
    ->name('cucianmotor.orders.store');
    Route::post('/orders/{id}/status', [CucianMotorAdminController::class,'updateStatus'])
    ->name('cucianmotor.orders.status');
    Route::get('/orders/{order}/send-wa', [CucianMotorAdminController::class, 'sendWa'])
        ->name('cucianmotor.orders.sendWa');
    Route::get('/orders/{order}', [CucianMotorAdminController::class, 'show'])
        ->name('cucianmotor.orders.show');
});

use App\Http\Controllers\Admin\KarsobedAdminController;

Route::prefix('admin/karsobed')->group(function(){
    Route::get('/dashboard', [KarsobedAdminController::class, 'dashboard'])->name('karsobed.dashboard');
    Route::get('/orders', [KarsobedAdminController::class,'orders'])->name('karsobed.orders');
    Route::get('/orders/create', [KarsobedAdminController::class,'create'])->name('karsobed.orders.create');
    Route::post('/orders', [KarsobedAdminController::class,'store'])->name('karsobed.orders.store');
    Route::post('/orders/{id}/status', [KarsobedAdminController::class,'updateStatus'])->name('karsobed.orders.status');
});
use App\Http\Controllers\Admin\PolishAdminController;

Route::prefix('admin/polish')->middleware('auth')->group(function() {

    Route::get('/dashboard', [PolishAdminController::class, 'dashboard'])
        ->name('polish.dashboard');

    // Daftar Orders
    Route::get('orders', [PolishAdminController::class, 'orders'])
        ->name('polish.orders.index');

    // Form tambah order
    Route::get('orders/create', [PolishAdminController::class, 'create'])
        ->name('polish.orders.create');

    // Simpan order
    Route::post('orders/store', [PolishAdminController::class, 'store'])
        ->name('polish.orders.store');

    // Update status order
    Route::post('orders/status/{id}', [PolishAdminController::class, 'updateStatus'])
        ->name('polish.orders.status');

});
use App\Http\Controllers\User\LayananUserController;

Route::prefix('user')->name('user.')->group(function () {
    Route::get('services', [LayananUserController::class, 'index'])->name('services.index');
    Route::get('services/{service}', [LayananUserController::class, 'show'])->name('services.show');
});



// routes/web.php
use App\Http\Controllers\ServiceVideoController;

Route::get('/video-review', [ServiceVideoController::class, 'index'])
  ->name('videos.index');

Route::prefix('admin')->group(function () {

  Route::get('/video', [ServiceVideoController::class, 'adminIndex'])
        ->name('admin.video.index');

  Route::get('/video/create', [ServiceVideoController::class, 'create'])
        ->name('admin.video.create');

  Route::post('/video', [ServiceVideoController::class, 'store'])
        ->name('admin.video.store');

  Route::delete('/video/{id}', [ServiceVideoController::class, 'destroy'])
        ->name('admin.video.destroy');
});
