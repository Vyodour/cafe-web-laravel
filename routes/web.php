<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\CafeController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\OrderController as PublicOrderController;
use App\Http\Controllers\Public\PaymentNotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');

Route::get('/cafes', [CafeController::class, 'index'])->name('public.cafes.index');
Route::get('/cafes/{slug}', [CafeController::class, 'show'])->name('public.cafes.show');

Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'destroy'])->name('cart.clear');

Route::middleware('auth')->post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::post('/midtrans/notification', [PaymentNotificationController::class, 'handle'])->name('midtrans.notification');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin' || $user->role === 'super_admin') {
        return redirect()->route('admin.products.index');
    }
    return redirect()->route('public.cafes.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-orders', [PublicOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/check', [PublicOrderController::class, 'checkStatus'])->name('orders.check');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', EnsureUserIsAdmin::class])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tables', TableController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
});


