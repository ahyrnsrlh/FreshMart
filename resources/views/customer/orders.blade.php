<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .status-pending { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
        .status-paid { background: linear-gradient(135deg, #10b981, #059669); }
        .status-processing { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .status-completed { background: linear-gradient(135deg, #10b981, #059669); }
        .status-cancelled { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .status-failed { background: linear-gradient(135deg, #ef4444, #dc2626); }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-green-50">    <div class="min-h-screen">
        <!-- Modern Navigation -->
        <nav class="bg-white/95 backdrop-blur-md border-b border-green-100 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('customer.home') }}" class="flex items-center space-x-3 group">
                            <div class="w-10 h-10 gradient-green rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-apple-alt text-white text-lg"></i>
                            </div>
                            <div>
                                <span class="text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-300">FreshMart</span>
                                <p class="text-xs text-gray-500 leading-none">Buah Segar Berkualitas</p>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('customer.home') }}" class="text-gray-600 hover:text-green-600 font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                        <a href="{{ route('customer.products') }}" class="text-gray-600 hover:text-green-600 font-medium transition-colors duration-200 flex items-center">
                            <i class="fas fa-apple-alt mr-2"></i>Produk
                        </a>
                        <a href="{{ route('customer.orders') }}" class="text-green-600 font-semibold border-b-2 border-green-600 pb-1 flex items-center">
                            <i class="fas fa-receipt mr-2"></i>Pesanan Saya
                        </a>
                    </div>
                    
                    <!-- User Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative group">
                            <div class="bg-green-100 hover:bg-green-200 p-3 rounded-xl transition-all duration-200 group-hover:scale-105">
                                <i class="fas fa-shopping-cart text-green-600"></i>
                                @if(session('cart'))
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                    </span>
                                @endif
                            </div>
                        </a>
                        
                        <!-- User Profile -->
                        <div class="flex items-center space-x-3 bg-white rounded-xl px-4 py-2 shadow-sm">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-green-600 text-sm"></i>
                            </div>
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Premium Member</p>
                            </div>
                        </div>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-600 p-3 rounded-xl transition-all duration-200 hover:scale-105">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-600 via-green-500 to-emerald-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex justify-center mb-6">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full p-6">
                            <i class="fas fa-receipt text-white text-4xl"></i>
                        </div>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Pesanan Saya</h1>
                    <p class="text-xl text-green-100 max-w-3xl mx-auto">
                        Lacak dan kelola semua pesanan buah segar Anda dengan mudah
                    </p>
                    
                    <!-- Stats -->
                    <div class="flex justify-center mt-8 space-x-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $orders->count() }}</div>
                            <div class="text-sm text-green-100">Total Pesanan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $orders->where('payment_status', 'paid')->count() }}</div>
                            <div class="text-sm text-green-100">Telah Dibayar</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $orders->where('order_status', 'completed')->count() }}</div>
                            <div class="text-sm text-green-100">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($orders->count() > 0)
                    <!-- Filter Tabs -->
                    <div class="mb-8">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <a href="#" class="border-green-500 text-green-600 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Semua Pesanan
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Menunggu Pembayaran
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Diproses
                                </a>
                                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                    Selesai
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Orders Grid -->
                    <div class="space-y-6">                            @foreach($orders as $order)
                                <div class="bg-white rounded-xl border border-gray-200 card-hover overflow-hidden">
                                    <div class="p-6">
                                        <!-- Order Header -->
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center space-x-4">
                                                <!-- Product Image Placeholder -->
                                                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
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
                                                        <i class="{{ $iconClass }} text-2xl"></i>
                                                    @endif
                                                </div>
                                                
                                                <div>
                                                    <div class="flex items-center space-x-2 mb-1">
                                                        <h3 class="font-semibold text-gray-900">{{ $order->product->name }}</h3>
                                                        <span class="text-gray-500">×{{ $order->quantity }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-500 mb-2">Order #{{ $order->id }}</p>
                                                    <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                                <p class="text-sm text-gray-500">Total Pembayaran</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Status Badges -->
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="flex space-x-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white status-{{ $order->payment_status }}">
                                                    <i class="fas fa-credit-card mr-1"></i>
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
                                                
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white status-{{ $order->order_status }}">
                                                    <i class="fas fa-truck mr-1"></i>
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
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex space-x-3">
                                                @if($order->payment_status === 'pending')
                                                    <a href="{{ route('customer.payment.show', $order) }}" 
                                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                                        <i class="fas fa-credit-card mr-2"></i>
                                                        Bayar Sekarang
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('customer.order.show', $order) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    Lihat Detail
                                                </a>
                                            </div>
                                            
                                            <!-- Order Progress -->
                                            <div class="flex items-center space-x-2 text-xs text-gray-500">
                                                @if($order->order_status === 'completed')
                                                    <i class="fas fa-check-circle text-green-500"></i>
                                                    <span>Pesanan Selesai</span>
                                                @elseif($order->order_status === 'shipped')
                                                    <i class="fas fa-truck text-blue-500"></i>
                                                    <span>Dalam Pengiriman</span>
                                                @elseif($order->order_status === 'processing')
                                                    <i class="fas fa-cog fa-spin text-yellow-500"></i>
                                                    <span>Sedang Diproses</span>
                                                @else
                                                    <i class="fas fa-clock text-gray-400"></i>
                                                    <span>Menunggu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach                        </ul>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-receipt text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-3">Belum Ada Pesanan</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Anda belum memiliki pesanan apapun. Mulai berbelanja buah segar berkualitas sekarang juga!
                        </p>
                        <div class="space-y-4">
                            <a href="{{ route('customer.products') }}" 
                               class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Mulai Berbelanja
                            </a>
                            <div class="flex justify-center space-x-6 mt-6">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-apple-alt text-green-600"></i>
                                    </div>
                                    <p class="text-sm text-gray-600">Buah Fresh</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-shipping-fast text-blue-600"></i>
                                    </div>
                                    <p class="text-sm text-gray-600">Pengiriman Cepat</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i class="fas fa-star text-yellow-600"></i>
                                    </div>
                                    <p class="text-sm text-gray-600">Kualitas Terbaik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
