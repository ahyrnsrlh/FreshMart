<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->id }} - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        }
        .status-pending { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
        .status-paid { background: linear-gradient(135deg, #10b981, #059669); }
        .status-processing { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .status-completed { background: linear-gradient(135deg, #10b981, #059669); }
        .status-cancelled { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .status-failed { background: linear-gradient(135deg, #ef4444, #dc2626); }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100 min-h-screen">
    <div class="min-h-screen">
        <!-- Modern Navigation -->
        <nav class="bg-white/90 backdrop-blur-sm shadow-lg border-b border-green-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-leaf text-white text-lg"></i>
                            </div>
                            <div>
                                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">
                                    FreshMart
                                </a>
                                <p class="text-xs text-green-600 font-medium">Fresh & Natural</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('customer.products') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors duration-200 flex items-center space-x-2">
                            <i class="fas fa-shopping-basket text-green-500"></i>
                            <span>Products</span>
                        </a>
                        @auth
                            <a href="{{ route('cart.index') }}" class="relative bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Cart</span>
                                @if(session('cart'))
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold shadow-lg">
                                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                    </span>
                                @else
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center font-bold shadow-lg">
                                        0
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('customer.orders') }}" class="text-gray-700 hover:text-green-600 font-medium transition-colors duration-200 flex items-center space-x-2">
                                <i class="fas fa-clipboard-list text-green-500"></i>
                                <span>My Orders</span>
                            </a>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="/admin/login" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2.5 px-5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-sign-in-alt mr-2"></i>Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>        </nav>

        <!-- Content -->
        <div class="max-w-5xl mx-auto py-8 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Modern Breadcrumb -->
                <nav class="flex mb-8" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-4 bg-white/90 backdrop-blur-sm rounded-xl px-6 py-3 shadow-lg border border-green-100">
                        <li>
                            <div>
                                <a href="{{ route('home') }}" class="text-gray-500 hover:text-green-600 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-home mr-2"></i>
                                    <span class="font-medium">Home</span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                                <a href="{{ route('customer.orders') }}" class="text-gray-500 hover:text-green-600 transition-colors duration-200 font-medium">
                                    My Orders
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                                <span class="text-green-600 font-semibold">Order #{{ $order->id }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Order Detail Card -->
                <div class="bg-white/90 backdrop-blur-sm shadow-xl overflow-hidden rounded-2xl border border-green-100">
                    <div class="px-6 py-8 sm:p-8">                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">Order Detail</h1>
                                <p class="text-gray-600 mt-2 flex items-center">
                                    <i class="fas fa-receipt mr-2 text-green-500"></i>
                                    Order ID: #{{ $order->id }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="space-y-3">
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white shadow-lg status-{{ $order->payment_status }}">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Payment: 
                                        @if($order->payment_status === 'pending')
                                            Menunggu Pembayaran
                                        @elseif($order->payment_status === 'paid')
                                            Sudah Dibayar
                                        @elseif($order->payment_status === 'failed')
                                            Pembayaran Gagal
                                        @else
                                            {{ ucfirst($order->payment_status) }}
                                        @endif
                                    </span>
                                    <br>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white shadow-lg status-{{ $order->order_status }}">
                                        <i class="fas fa-truck mr-2"></i>
                                        Order: 
                                        @if($order->order_status === 'pending')
                                            Sedang Diproses
                                        @elseif($order->order_status === 'processing')
                                            Sedang Disiapkan
                                        @elseif($order->order_status === 'shipped')
                                            Dalam Pengiriman
                                        @elseif($order->order_status === 'completed')
                                            Selesai
                                        @elseif($order->order_status === 'cancelled')
                                            Dibatalkan
                                        @else
                                            {{ ucfirst($order->order_status) }}
                                        @endif
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-3 flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="border-t border-gray-200 pt-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Order Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d F Y, H:i') }}</dd>
                                </div>                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->payment_status_badge }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Order Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->order_status_badge }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Customer</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</dd>
                                </div>                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->payment_method_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                                    <dd class="mt-1 text-lg font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>                        <!-- Product Details -->
                        <div class="border-t border-green-100 pt-8 mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-box mr-3 text-green-500"></i>
                                Product Details
                            </h3>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 shadow-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-6">
                                        <div class="w-20 h-20 bg-white rounded-2xl p-3 shadow-lg">
                                            @if($order->product->image && file_exists(public_path('storage/' . $order->product->image)))
                                                <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                     alt="{{ $order->product->name }}" 
                                                     class="w-full h-full object-cover rounded-xl">
                                            @else
                                                @php
                                                    $productName = strtolower($order->product->name ?? '');
                                                    $iconClass = 'fas fa-apple-alt text-green-500';
                                                    if (str_contains($productName, 'apel')) $iconClass = 'fas fa-apple-alt text-red-500';
                                                    elseif (str_contains($productName, 'jeruk')) $iconClass = 'fas fa-lemon text-orange-500';
                                                    elseif (str_contains($productName, 'pisang')) $iconClass = 'fas fa-seedling text-yellow-500';
                                                    elseif (str_contains($productName, 'anggur')) $iconClass = 'fas fa-circle text-purple-500';
                                                    elseif (str_contains($productName, 'strawberry')) $iconClass = 'fas fa-heart text-red-500';
                                                    elseif (str_contains($productName, 'mangga')) $iconClass = 'fas fa-leaf text-green-500';
                                                @endphp
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="{{ $iconClass }} text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900">{{ $order->product->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                                    {{ $order->product->category->name ?? 'No Category' }}
                                                </span>
                                            </p>
                                            <p class="text-lg font-semibold text-gray-900 mt-2 flex items-center">
                                                <i class="fas fa-cubes mr-2 text-green-500"></i>
                                                Quantity: {{ $order->quantity }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600 mb-1">Unit Price</p>
                                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($order->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>                        <!-- Order Summary -->
                        <div class="border-t border-green-100 pt-8 mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-calculator mr-3 text-green-500"></i>
                                Order Summary
                            </h3>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 shadow-lg">
                                <div class="space-y-4">
                                    <div class="flex justify-between text-base">
                                        <span class="text-gray-700 flex items-center">
                                            <i class="fas fa-shopping-basket mr-2 text-green-500"></i>
                                            Subtotal ({{ $order->quantity }} items)
                                        </span>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($order->product->price * $order->quantity, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-base">
                                        <span class="text-gray-700 flex items-center">
                                            <i class="fas fa-truck mr-2 text-green-500"></i>
                                            Shipping
                                        </span>
                                        <span class="font-semibold text-green-600">Free</span>
                                    </div>
                                    <div class="border-t border-green-200 pt-4">
                                        <div class="flex justify-between text-xl font-bold">
                                            <span class="text-gray-900 flex items-center">
                                                <i class="fas fa-receipt mr-2 text-green-500"></i>
                                                Total
                                            </span>
                                            <span class="text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        <!-- Payment Information -->
                        @if($order->payment_status !== 'pending')
                        <div class="border-t border-green-100 pt-8 mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <i class="fas fa-credit-card mr-3 text-green-500"></i>
                                Payment Information
                            </h3>
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 shadow-lg">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 flex items-center">
                                            <i class="fas fa-money-check-alt mr-2 text-blue-500"></i>
                                            Payment Method:
                                        </span>
                                        <span class="font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg">{{ $order->payment_method_name }}</span>
                                    </div>
                                    @if($order->payment_date)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 flex items-center">
                                            <i class="fas fa-calendar-check mr-2 text-blue-500"></i>
                                            Payment Date:
                                        </span>
                                        <span class="font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg">{{ $order->payment_date->format('d F Y, H:i') }}</span>
                                    </div>
                                    @endif
                                    @if($order->payment_notes)
                                    <div class="bg-white rounded-xl p-4">
                                        <span class="text-gray-700 font-medium flex items-center mb-2">
                                            <i class="fas fa-sticky-note mr-2 text-blue-500"></i>
                                            Payment Notes:
                                        </span>
                                        <p class="text-gray-900">{{ $order->payment_notes }}</p>
                                    </div>
                                    @endif
                                    @if($order->payment_proof)
                                    <div class="bg-white rounded-xl p-4">
                                        <span class="text-gray-700 font-medium flex items-center mb-3">
                                            <i class="fas fa-file-image mr-2 text-blue-500"></i>
                                            Payment Proof:
                                        </span>
                                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-external-link-alt mr-2"></i>
                                            View Payment Proof
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Actions -->
                        <div class="border-t border-green-100 pt-8 mt-8">
                            <div class="flex space-x-4">
                                @if($order->payment_status === 'pending')
                                    <a href="{{ route('customer.payment.show', $order) }}" 
                                       class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-4 px-6 rounded-xl text-center font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-3">
                                        <i class="fas fa-credit-card"></i>
                                        <span>Bayar Sekarang</span>
                                    </a>
                                    <a href="{{ route('customer.orders') }}" 
                                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 py-4 px-6 rounded-xl text-center font-semibold transition-all duration-200 flex items-center justify-center space-x-3">
                                        <i class="fas fa-arrow-left"></i>
                                        <span>Back to Orders</span>
                                    </a>
                                @else
                                    <a href="{{ route('customer.orders') }}" 
                                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 py-4 px-6 rounded-xl text-center font-semibold transition-all duration-200 flex items-center justify-center space-x-3">
                                        <i class="fas fa-list"></i>
                                        <span>Back to Orders</span>
                                    </a>
                                    <a href="{{ route('customer.products') }}" 
                                       class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-4 px-6 rounded-xl text-center font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center space-x-3">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Continue Shopping</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>                <!-- Additional Information -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-info text-white"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">Order Information</h3>
                            <div class="text-blue-800 space-y-2">
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                                    Thank you for your order! Your fresh fruits are being carefully prepared.
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-headset mr-2 text-blue-500"></i>
                                    For questions about this order, please contact our customer service.
                                </p>
                                <div class="mt-4 flex space-x-4">
                                    <a href="tel:+62123456789" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200">
                                        <i class="fas fa-phone mr-2"></i>
                                        Call Us
                                    </a>
                                    <a href="mailto:support@freshmart.com" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200">
                                        <i class="fas fa-envelope mr-2"></i>
                                        Email Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
