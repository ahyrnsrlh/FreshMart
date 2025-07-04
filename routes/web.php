<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

// Authentication Routes
Auth::routes();

// Default home route
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Check user role using role column instead of roles relationship
        if (in_array($user->role, ['Admin', 'Merchant'])) {
            return redirect('/admin');
        } else {
            return view('customer.index');
        }
    }
    return view('customer.index');
})->name('home');

// Home route for authenticated users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.dashboard');

// Customer routes (dapat diakses tanpa login)
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.home');
Route::get('/products', [CustomerController::class, 'products'])->name('customer.products');
Route::get('/products/{product}', [CustomerController::class, 'showProduct'])->name('customer.product.show');

// Customer authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CustomerController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart.index');
    Route::post('/cart/update', [CustomerController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CustomerController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/orders/{transaction}', [CustomerController::class, 'showOrder'])->name('customer.order.show');
    Route::get('/payment/{transaction}', [CustomerController::class, 'showPayment'])->name('customer.payment.show');
    Route::post('/payment/{transaction}', [CustomerController::class, 'processPayment'])->name('customer.payment.process');
});

// Health check route for Railway (ultra simple)
Route::get('/health', function () {
    return response('OK', 200)
        ->header('Content-Type', 'text/plain');
});

// JSON health check
Route::get('/health/json', function () {
    try {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => date('Y-m-d H:i:s'),
            'app' => 'FreshMart',
        ], 200);
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'unhealthy',
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Database health check (separate endpoint)
Route::get('/health/db', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'database_healthy',
            'timestamp' => now()->toISOString(),
        ], 200);
        
    } catch (Exception $e) {
        return response()->json([
            'status' => 'database_unhealthy',
            'error' => $e->getMessage(),
            'timestamp' => now()->toISOString(),
        ], 500);
    }
});
