<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CatalogController as AdminCatalogController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MessageHistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / customer routes (guest checkout, no account needed)
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/catalog/{catalog}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{product}/add-to-cart', [CartController::class, 'add'])->name('cart.add');

Route::middleware(['auth', 'feature:comments'])->group(function () {
    Route::post('/product/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');


/*
|--------------------------------------------------------------------------
| Customer accounts (optional - checkout still works without logging in)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('/my-orders/{order}', [OrderHistoryController::class, 'show'])->name('orders.history.show');
});


/*
|--------------------------------------------------------------------------
| Contact / messages (public form, history is auth-only)
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/my-messages', [MessageHistoryController::class, 'index'])->name('messages.index');
});


/*
|--------------------------------------------------------------------------
| Notifications (shared - works the same for customers and admin/staff)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});


/*
|--------------------------------------------------------------------------
| Admin routes (admin + staff, role-protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Login page - only for guests (already-logged-in admins get redirected)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Everything below requires being logged in as admin OR staff
    Route::middleware(['auth', 'role:admin,staff'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Products - admin & staff can create/edit
        Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');

        // Catalogs - admin & staff can create/edit
        Route::get('catalogs', [AdminCatalogController::class, 'index'])->name('catalogs.index');
        Route::get('catalogs/create', [AdminCatalogController::class, 'create'])->name('catalogs.create');
        Route::post('catalogs', [AdminCatalogController::class, 'store'])->name('catalogs.store');
        Route::get('catalogs/{catalog}/edit', [AdminCatalogController::class, 'edit'])->name('catalogs.edit');
        Route::put('catalogs/{catalog}', [AdminCatalogController::class, 'update'])->name('catalogs.update');

        // Orders - view + update status (no delete route exists for either role)
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // Messages - view + reply (same permission level as orders, no delete)
        Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{contactMessage}', [AdminMessageController::class, 'show'])->name('messages.show');
        Route::post('messages/{contactMessage}/reply', [AdminMessageController::class, 'reply'])->name('messages.reply');

        // Comments moderation - NOT feature-gated, so old comments can still be
        // cleaned up even after the feature is switched off
        Route::get('comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    });

    // Admin-only: delete products/catalogs, manage admin/staff accounts
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('catalogs/{catalog}', [AdminCatalogController::class, 'destroy'])->name('catalogs.destroy');

        Route::resource('users', AdminUserController::class)->except(['show']);

        // Settings - where the "license" toggles live, admin-only
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings/{feature}/toggle', [AdminSettingController::class, 'toggle'])->name('settings.toggle');
    });
});
