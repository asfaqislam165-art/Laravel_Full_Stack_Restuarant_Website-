<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MenuController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ReservationController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MenuItemController as AdminMenuItemController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ManualOrderController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SpecialOfferController as AdminSpecialOfferController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\SettingController;

// ==========================================
// PUBLIC FRONTEND ROUTES
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{menuItem:slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/special-offers', [HomeController::class, 'offers'])->name('offers');
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');

// Table Reservation
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Shopping Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{menuItem}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{menuItem}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{menuItem}', [CartController::class, 'remove'])->name('remove');
    Route::post('/apply-offer', [CartController::class, 'applyOffer'])->name('applyOffer');
    Route::post('/remove-offer', [CartController::class, 'removeOffer'])->name('removeOffer');
});

// Checkout & Order Confirmation
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order-confirmation/{order:order_number}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// ==========================================
// REGULAR USER DASHBOARD & PROFILE (BREEZE)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// PROTECTED ADMIN DASHBOARD ROUTES
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class);
    Route::resource('menu-items', AdminMenuItemController::class);
    Route::resource('reviews', AdminReviewController::class);
    Route::resource('offers', AdminSpecialOfferController::class);

    // Orders & Manual Order Creation
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])->name('orders.updatePayment');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('manual-orders/create', [ManualOrderController::class, 'create'])->name('manual-orders.create');
    Route::post('manual-orders', [ManualOrderController::class, 'store'])->name('manual-orders.store');

    // Reservations
    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::patch('reservations/{reservation}/status', [AdminReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::delete('reservations/{reservation}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');

    // Contact Messages
    Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Restaurant Settings
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
});

require __DIR__ . '/auth.php';