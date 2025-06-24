<!DOCTYPE html>
<html lang="en">
<head>    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FreshMart') }} - FreshMart Online Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">    <style>
        .bg-gradient-green {
            background: linear-gradient(135deg, #10B981 0%, #059669 50%, #047857 100%);
        }
        
        .hero-modern-bg {
            background: linear-gradient(135deg, 
                rgba(16, 185, 129, 0.95) 0%, 
                rgba(5, 150, 105, 0.9) 35%,
                rgba(4, 120, 87, 0.95) 70%,
                rgba(6, 95, 70, 1) 100%
            );
            position: relative;
            overflow: hidden;
        }
        
        .hero-modern-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(251, 191, 36, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(139, 69, 19, 0.1) 0%, transparent 50%),
                url("data:image/svg+xml,%3csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3e%3cg fill='none' fill-rule='evenodd'%3e%3cg fill='%23ffffff' fill-opacity='0.04'%3e%3ccircle cx='30' cy='30' r='1.5'/%3e%3c/g%3e%3c/g%3e%3c/svg%3e");
            pointer-events: none;
        }
        
        .floating-element {
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-element:nth-child(2) {
            animation-delay: -2s;
            animation-duration: 10s;
        }
        
        .floating-element:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 12s;
        }
        
        .floating-element:nth-child(4) {
            animation-delay: -6s;
            animation-duration: 9s;
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg) scale(1); 
                opacity: 0.6;
            }
            25% { 
                transform: translateY(-30px) rotate(3deg) scale(1.1); 
                opacity: 0.8;
            }
            50% { 
                transform: translateY(-20px) rotate(-2deg) scale(0.9); 
                opacity: 1;
            }
            75% { 
                transform: translateY(-40px) rotate(1deg) scale(1.05); 
                opacity: 0.7;
            }
        }
        
        .bounce-in {
            animation: bounceIn 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes bounceIn {
            0% { 
                opacity: 0; 
                transform: scale(0.3) rotate(-10deg); 
            }
            50% { 
                opacity: 1; 
                transform: scale(1.1) rotate(5deg); 
            }
            70% { 
                transform: scale(0.9) rotate(-2deg); 
            }
            85% { 
                transform: scale(1.05) rotate(1deg); 
            }
            100% { 
                opacity: 1; 
                transform: scale(1) rotate(0deg); 
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        @keyframes fadeInUp {
            0% { 
                opacity: 0; 
                transform: translateY(40px) scale(0.95); 
            }
            100% { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        .pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            0% { 
                box-shadow: 
                    0 0 20px rgba(16, 185, 129, 0.4),
                    0 0 40px rgba(16, 185, 129, 0.2),
                    inset 0 0 20px rgba(255, 255, 255, 0.1);
            }
            100% { 
                box-shadow: 
                    0 0 30px rgba(16, 185, 129, 0.8), 
                    0 0 60px rgba(16, 185, 129, 0.4),
                    0 0 80px rgba(251, 191, 36, 0.3),
                    inset 0 0 20px rgba(255, 255, 255, 0.2);
            }
        }
        
        .hero-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .hero-card:hover {
            transform: translateY(-8px) scale(1.05) rotate(2deg);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .gradient-text {
            background: linear-gradient(45deg, #FBBF24, #F59E0B, #EAB308, #FCD34D);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradientShift 4s ease-in-out infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .hero-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: badgePulse 2s ease-in-out infinite;
        }
        
        @keyframes badgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .hero-cta-primary {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.1),
                0 4px 10px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .hero-cta-primary:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 8px 15px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 1);
        }
        
        .hero-cta-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .hero-cta-secondary:hover {
            background: rgba(255, 255, 255, 0.95);
            color: #059669;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .floating-icons {
            animation: floatRotate 15s linear infinite;
        }
        
        @keyframes floatRotate {
            0% { transform: rotate(0deg) translateX(40px) rotate(0deg); }
            100% { transform: rotate(360deg) translateX(40px) rotate(-360deg); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Header -->
    <div class="bg-green-600 text-white text-sm">
        <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <span><i class="fas fa-phone mr-1"></i> +62 821 1234 5678</span>
                <span><i class="fas fa-envelope mr-1"></i> info@freshmart.com</span>
            </div>
            <div class="flex items-center space-x-4">
                <span>Gratis Ongkir untuk pembelian > Rp 50.000</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-apple-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">FreshMart</h1>
                            <p class="text-xs text-gray-500">Buah Segar Berkualitas</p>
                        </div>
                    </div>
                </div>                <!-- Search Bar -->
                <div class="hidden md:flex items-center flex-1 max-w-2xl mx-8">
                    <form action="{{ route('customer.products') }}" method="GET" class="relative w-full group">
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari buah segar, sayuran, atau produk organik..." 
                               class="w-full px-4 py-3 pl-12 pr-20 text-gray-700 bg-white border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm group-hover:shadow-md"
                               autocomplete="off">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-green-500 transition-colors duration-200"></i>
                        <div class="absolute right-2 top-1/2 transform -translate-y-1/2 flex items-center space-x-2">
                            <span class="hidden lg:block text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded border">Ctrl+K</span>
                            <button type="submit" class="bg-green-500 text-white px-4 py-1.5 rounded-lg hover:bg-green-600 transition duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <i class="fas fa-search mr-1"></i>
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- User Actions -->
                <div class="flex items-center space-x-6">
                    @auth
                        <!-- User Profile -->
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-xs text-gray-500">Halo,</p>
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                            </div>
                        </div>
                        
                        <!-- Orders -->
                        <a href="{{ route('customer.orders') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition duration-200">
                            <i class="fas fa-receipt text-lg"></i>
                            <span class="text-xs mt-1">Pesanan</span>
                        </a>
                          <!-- Cart -->
                        <div class="relative">
                            <a href="{{ route('cart.index') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition duration-200">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span class="text-xs mt-1">Keranjang</span>
                                @if(session('cart'))
                                    <span class="cart-count-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                    </span>
                                @else
                                    <span class="cart-count-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">
                                        0
                                    </span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="flex flex-col items-center text-gray-600 hover:text-red-600 transition duration-200">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                                <span class="text-xs mt-1">Keluar</span>
                            </button>
                        </form>
                    @else
                        <!-- Login -->
                        <a href="{{ route('login') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition duration-200">
                            <i class="fas fa-user text-lg"></i>
                            <span class="text-xs mt-1">Masuk</span>
                        </a>
                          <!-- Cart -->
                        <div class="relative">
                            <a href="{{ route('cart.index') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition duration-200">
                                <i class="fas fa-shopping-cart text-lg"></i>
                                <span class="text-xs mt-1">Keranjang</span>
                                <span class="cart-count-badge absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">
                                    0
                                </span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Category Navigation -->
        <div class="border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-8 py-4">
                    <div class="flex items-center space-x-2 text-green-600 font-medium">
                        <i class="fas fa-bars"></i>
                        <span>Semua Kategori</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>                    <div class="hidden md:flex items-center space-x-8 text-sm">
                        <a href="{{ route('customer.products') }}" class="text-gray-700 hover:text-green-600 transition duration-200">Semua Produk</a>
                        <a href="{{ route('customer.products', ['search' => 'buah segar']) }}" class="text-gray-700 hover:text-green-600 transition duration-200">Buah Segar</a>
                        <a href="{{ route('customer.products', ['search' => 'organik']) }}" class="text-gray-700 hover:text-green-600 transition duration-200">Organik</a>
                        <a href="{{ route('customer.products', ['search' => 'tropis']) }}" class="text-gray-700 hover:text-green-600 transition duration-200">Buah Tropis</a>
                        <a href="{{ route('customer.products', ['search' => 'musiman']) }}" class="text-gray-700 hover:text-green-600 transition duration-200">Buah Musiman</a>
                        <a href="{{ route('customer.products') }}" class="text-red-600 hover:text-red-700 transition duration-200 font-medium">
                            <i class="fas fa-fire mr-1"></i>Promo Hari Ini
                        </a>
                    </div>
                </div>
            </div>        </div>
    </nav>    <!-- Mobile Search Bar -->
    <div class="md:hidden bg-white border-b border-gray-200 px-4 py-3">
        <form action="{{ route('customer.products') }}" method="GET" class="relative">
            <input type="text" 
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari produk..." 
                   class="w-full px-4 py-3 pl-12 pr-16 text-gray-700 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                   autocomplete="off">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-500 text-white px-3 py-1.5 rounded-lg hover:bg-green-600 transition duration-200 shadow-lg">
                <i class="fas fa-search"></i>            </button>
        </form>
    </div>

    <!-- Quick Search Section -->
    <div class="bg-gray-50 border-b border-gray-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600 font-medium">Pencarian Cepat:</span>
                    <div class="quick-search-container flex items-center space-x-2">
                        <!-- Quick search buttons will be generated by JavaScript -->
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-xs text-gray-500">
                    <i class="fas fa-keyboard mr-1"></i>
                    <span>Tekan <kbd class="px-2 py-1 bg-white border border-gray-300 rounded">Ctrl</kbd> + <kbd class="px-2 py-1 bg-white border border-gray-300 rounded">K</kbd> untuk pencarian cepat</span>
                </div>
            </div>
        </div>
    </div><!-- Hero Section - Modern & Interactive -->
    <section class="relative hero-modern-bg min-h-screen flex items-center overflow-hidden">
        <!-- Dynamic Background Elements -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Floating geometric shapes -->
            <div class="floating-element absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-white/20 to-yellow-300/30 rounded-full blur-sm"></div>
            <div class="floating-element absolute top-40 right-20 w-24 h-24 bg-gradient-to-br from-yellow-400/40 to-orange-400/30 rounded-3xl rotate-45"></div>
            <div class="floating-element absolute bottom-32 left-20 w-40 h-40 bg-gradient-to-br from-white/10 to-green-300/20 rounded-full blur-md"></div>
            <div class="floating-element absolute bottom-20 right-16 w-20 h-20 bg-gradient-to-br from-emerald-300/30 to-green-600/20 rounded-2xl rotate-12"></div>
            
            <!-- Floating icons with rotation -->
            <div class="absolute top-1/4 left-1/4">
                <div class="floating-icons">
                    <i class="fas fa-apple-alt text-white/20 text-3xl"></i>
                </div>
            </div>
            <div class="absolute top-3/4 right-1/4">
                <div class="floating-icons" style="animation-delay: -5s;">
                    <i class="fas fa-leaf text-white/20 text-2xl"></i>
                </div>
            </div>
            <div class="absolute top-1/2 left-3/4">
                <div class="floating-icons" style="animation-delay: -10s;">
                    <i class="fas fa-heart text-white/20 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Content - Enhanced -->
                <div class="text-white space-y-10">
                    <!-- Promo Badge -->
                    <div class="fade-in-up">
                        <div class="inline-flex items-center hero-badge rounded-full px-6 py-3 mb-8">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></div>
                            <span class="text-sm font-semibold">🔥 MEGA SALE - Diskon hingga 50% + Gratis Ongkir!</span>
                            <div class="ml-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-bounce">HOT</div>
                        </div>
                        
                        <!-- Main Headline -->
                        <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black leading-none tracking-tight">
                            <span class="block text-white drop-shadow-lg">Buah Segar</span>
                            <span class="block gradient-text drop-shadow-lg">Premium Quality</span>
                            <span class="block text-green-100 text-4xl sm:text-5xl lg:text-6xl mt-2">Delivered Fresh to You</span>
                        </h1>
                    </div>
                    
                    <!-- Description -->
                    <div class="fade-in-up" style="animation-delay: 0.3s;">
                        <p class="text-xl lg:text-2xl text-green-50 leading-relaxed max-w-2xl">
                            Rasakan kesegaran buah pilihan terbaik langsung dari kebun ke meja Anda. 
                            <span class="font-bold text-yellow-300">Kualitas premium</span>, 
                            <span class="font-bold text-yellow-300">harga terjangkau</span>, 
                            dengan layanan pengiriman super cepat!
                        </p>
                        
                        <!-- Key Points -->
                        <div class="flex flex-wrap gap-4 mt-6">
                            <div class="flex items-center bg-white/10 backdrop-blur rounded-full px-4 py-2">
                                <i class="fas fa-certificate text-yellow-400 mr-2"></i>
                                <span class="text-sm font-medium">100% Organik</span>
                            </div>
                            <div class="flex items-center bg-white/10 backdrop-blur rounded-full px-4 py-2">
                                <i class="fas fa-shipping-fast text-blue-400 mr-2"></i>
                                <span class="text-sm font-medium">Same Day Delivery</span>
                            </div>
                            <div class="flex items-center bg-white/10 backdrop-blur rounded-full px-4 py-2">
                                <i class="fas fa-shield-alt text-green-400 mr-2"></i>
                                <span class="text-sm font-medium">Garansi Kesegaran</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="fade-in-up" style="animation-delay: 0.6s;">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <a href="{{ route('customer.products') }}" class="group hero-cta-primary text-green-600 px-10 py-5 rounded-2xl font-bold text-xl text-center pulse-glow relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <i class="fas fa-shopping-bag mr-3 group-hover:animate-bounce"></i>
                                    <span>Belanja Sekarang</span>
                                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform duration-300"></i>
                                </div>
                            </a>                            <a href="{{ route('customer.products') }}" class="group hero-cta-secondary text-white px-10 py-5 rounded-2xl font-bold text-xl text-center">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-play-circle mr-3 group-hover:text-green-500 transition-colors duration-300"></i>
                                    <span>Lihat Semua Produk</span>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Trust indicators -->
                        <div class="flex items-center gap-8 mt-8 pt-8 border-t border-white/20">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">50K+</div>
                                <div class="text-sm text-green-100">Happy Customers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">4.9★</div>
                                <div class="text-sm text-green-100">Rating</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-yellow-300">24/7</div>
                                <div class="text-sm text-green-100">Fresh Supply</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Enhanced Product Showcase -->
                <div class="hidden lg:block relative">
                    <div class="relative">
                        <!-- Main Product Showcase Grid -->
                        <div class="grid grid-cols-2 gap-8 transform rotate-3 perspective-1000">
                            <!-- Featured Product 1 -->
                            <div class="hero-card rounded-3xl p-8 text-center bounce-in" style="animation-delay: 1s;">
                                <div class="relative">
                                    <div class="w-20 h-20 bg-gradient-to-br from-red-400 via-red-500 to-red-600 rounded-3xl mx-auto mb-6 flex items-center justify-center shadow-2xl">
                                        <i class="fas fa-apple-alt text-white text-3xl"></i>
                                    </div>
                                    <div class="absolute -top-2 -right-2 bg-yellow-400 text-red-600 text-xs font-bold px-2 py-1 rounded-full animate-pulse">NEW</div>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Apel Fuji Premium</h3>
                                <p class="text-green-600 font-bold text-xl mb-2">Rp 35.000</p>
                                <div class="flex justify-center text-yellow-400 text-sm mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-white bg-red-500 px-3 py-1 rounded-full">Best Seller</span>
                            </div>
                            
                            <!-- Featured Product 2 -->
                            <div class="hero-card rounded-3xl p-8 text-center bounce-in" style="animation-delay: 1.3s;">
                                <div class="relative">
                                    <div class="w-20 h-20 bg-gradient-to-br from-orange-400 via-yellow-500 to-orange-600 rounded-3xl mx-auto mb-6 flex items-center justify-center shadow-2xl">
                                        <i class="fas fa-lemon text-white text-3xl"></i>
                                    </div>
                                    <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">50%</div>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Jeruk Valencia</h3>
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <p class="text-gray-400 line-through text-sm">Rp 36.000</p>
                                    <p class="text-green-600 font-bold text-xl">Rp 18.000</p>
                                </div>
                                <div class="flex justify-center text-yellow-400 text-sm mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-white bg-gradient-to-r from-red-500 to-pink-500 px-3 py-1 rounded-full">Flash Sale</span>
                            </div>
                            
                            <!-- Featured Product 3 -->
                            <div class="hero-card rounded-3xl p-8 text-center bounce-in" style="animation-delay: 1.6s;">
                                <div class="relative">
                                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 via-emerald-500 to-green-600 rounded-3xl mx-auto mb-6 flex items-center justify-center shadow-2xl">
                                        <i class="fas fa-seedling text-white text-3xl"></i>
                                    </div>
                                    <div class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">✓</div>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Pisang Cavendish</h3>
                                <p class="text-green-600 font-bold text-xl mb-2">Rp 25.000</p>
                                <div class="flex justify-center text-yellow-400 text-sm mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-white bg-green-500 px-3 py-1 rounded-full">Organic</span>
                            </div>
                            
                            <!-- Featured Product 4 -->
                            <div class="hero-card rounded-3xl p-8 text-center bounce-in" style="animation-delay: 1.9s;">
                                <div class="relative">
                                    <div class="w-20 h-20 bg-gradient-to-br from-pink-400 via-red-500 to-pink-600 rounded-3xl mx-auto mb-6 flex items-center justify-center shadow-2xl">
                                        <i class="fas fa-heart text-white text-3xl"></i>
                                    </div>
                                    <div class="absolute -top-2 -right-2 bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">💎</div>
                                </div>
                                <h3 class="font-bold text-gray-800 mb-2 text-lg">Strawberry Premium</h3>
                                <p class="text-green-600 font-bold text-xl mb-2">Rp 45.000</p>
                                <div class="flex justify-center text-yellow-400 text-sm mb-3">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                </div>
                                <span class="text-xs text-white bg-gradient-to-r from-purple-500 to-pink-500 px-3 py-1 rounded-full">Luxury</span>
                            </div>
                        </div>
                        
                        <!-- Floating Statistics -->
                        <div class="absolute -top-8 -left-8 bg-white rounded-3xl p-6 shadow-2xl bounce-in transform rotate-3" style="animation-delay: 2.2s;">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-users text-white text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-black text-gray-800 text-2xl">50K+</p>
                                    <p class="text-sm text-gray-600 font-medium">Happy Customers</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Discount Badge -->
                        <div class="absolute -bottom-6 -right-6 bg-gradient-to-r from-red-500 via-pink-500 to-red-600 text-white rounded-3xl p-6 shadow-2xl bounce-in transform -rotate-6" style="animation-delay: 2.5s;">
                            <div class="text-center">
                                <p class="font-black text-4xl leading-none">50%</p>
                                <p class="text-sm font-bold">OFF</p>
                                <p class="text-xs opacity-90">Today Only!</p>
                            </div>
                        </div>
                        
                        <!-- Floating Delivery Icon -->
                        <div class="absolute top-1/2 -right-12 transform -translate-y-1/2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full p-4 shadow-2xl bounce-in" style="animation-delay: 2.8s;">
                            <i class="fas fa-shipping-fast text-2xl"></i>
                        </div>
                        
                        <!-- Floating Quality Badge -->
                        <div class="absolute top-8 right-8 bg-gradient-to-br from-yellow-400 to-yellow-500 text-gray-800 rounded-2xl p-3 shadow-xl bounce-in" style="animation-delay: 3s;">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-certificate text-lg"></i>
                                <span class="text-sm font-bold">Quality</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Bottom Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-20 text-white fill-current">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
            </svg>
        </div>    </section>

    <!-- Flash Messages -->
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Featured Products Section - Moved here after hero -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-green-100 text-green-600 px-6 py-3 rounded-full font-semibold mb-6">
                    <i class="fas fa-star mr-2"></i>
                    Produk Pilihan Hari Ini
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Buah Segar Premium</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Nikmati koleksi buah segar pilihan terbaik dengan kualitas premium, dipetik langsung dari kebun organik terpercaya
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse(($products ?? \App\Models\Product::with('category')->take(8)->get()) as $product)
                    <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="relative p-6 bg-gradient-to-br from-gray-50 to-gray-100">                            <!-- Product Image -->
                            <div class="product-image-container w-full h-56 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl overflow-hidden mb-6 group-hover:scale-105 transition-transform duration-500">
                                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover rounded-2xl hover:scale-110 transition-transform duration-500"
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <!-- Fallback placeholder (hidden by default) -->
                                    <div class="product-placeholder w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 rounded-2xl relative overflow-hidden" style="display: none;">
                                        <!-- Background pattern -->
                                        <div class="absolute inset-0 opacity-10">
                                            <div class="absolute top-4 left-4 w-8 h-8 bg-white rounded-full animate-pulse"></div>
                                            <div class="absolute top-8 right-6 w-4 h-4 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                                            <div class="absolute bottom-6 left-8 w-6 h-6 bg-yellow-300 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                                            <div class="absolute bottom-4 right-4 w-3 h-3 bg-red-300 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
                                        </div>
                                        @php
                                            $productName = strtolower($product->name ?? '');
                                            $iconClass = 'fas fa-apple-alt text-green-500';
                                            if (str_contains($productName, 'apel')) $iconClass = 'fas fa-apple-alt text-red-500';
                                            elseif (str_contains($productName, 'jeruk')) $iconClass = 'fas fa-lemon text-orange-500';
                                            elseif (str_contains($productName, 'pisang')) $iconClass = 'fas fa-seedling text-yellow-500';
                                            elseif (str_contains($productName, 'anggur')) $iconClass = 'fas fa-circle text-purple-500';
                                            elseif (str_contains($productName, 'strawberry')) $iconClass = 'fas fa-heart text-red-500';
                                            elseif (str_contains($productName, 'mangga')) $iconClass = 'fas fa-leaf text-green-500';
                                        @endphp
                                        <div class="text-center relative z-10">
                                            <i class="{{ $iconClass }} text-6xl opacity-60 mb-4"></i>
                                            <p class="text-sm text-gray-600 font-semibold">{{ $product->name }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="product-placeholder w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 rounded-2xl relative overflow-hidden">
                                        <!-- Background pattern -->
                                        <div class="absolute inset-0 opacity-10">
                                            <div class="absolute top-4 left-4 w-8 h-8 bg-white rounded-full animate-pulse"></div>
                                            <div class="absolute top-8 right-6 w-4 h-4 bg-green-300 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                                            <div class="absolute bottom-6 left-8 w-6 h-6 bg-yellow-300 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                                            <div class="absolute bottom-4 right-4 w-3 h-3 bg-red-300 rounded-full animate-pulse" style="animation-delay: 1.5s;"></div>
                                        </div>
                                        @php
                                            $productName = strtolower($product->name ?? '');
                                            $iconClass = 'fas fa-apple-alt text-green-500';
                                            if (str_contains($productName, 'apel')) $iconClass = 'fas fa-apple-alt text-red-500';
                                            elseif (str_contains($productName, 'jeruk')) $iconClass = 'fas fa-lemon text-orange-500';
                                            elseif (str_contains($productName, 'pisang')) $iconClass = 'fas fa-seedling text-yellow-500';
                                            elseif (str_contains($productName, 'anggur')) $iconClass = 'fas fa-circle text-purple-500';
                                            elseif (str_contains($productName, 'strawberry')) $iconClass = 'fas fa-heart text-red-500';
                                            elseif (str_contains($productName, 'mangga')) $iconClass = 'fas fa-leaf text-green-500';
                                        @endphp
                                        <div class="text-center relative z-10">
                                            <i class="{{ $iconClass }} text-6xl opacity-60 mb-4"></i>
                                            <p class="text-sm text-gray-600 font-semibold">{{ $product->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Favorite Button -->
                            <button class="absolute top-4 right-4 w-12 h-12 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-all duration-300 hover:scale-110 group-hover:shadow-xl">
                                <i class="fas fa-heart text-gray-400 hover:text-red-500 transition-colors duration-300"></i>
                            </button>
                            
                            <!-- Product Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                @if($product->stock <= 5)
                                    <span class="product-badge bg-red-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg animate-pulse">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Stok Terbatas
                                    </span>
                                @endif
                                
                                @if(isset($product->is_featured) && $product->is_featured)
                                    <span class="product-badge bg-yellow-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                @endif
                                
                                @if(isset($product->discount) && $product->discount > 0)
                                    <span class="product-badge bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg">
                                        <i class="fas fa-fire mr-1"></i>{{ $product->discount }}% OFF
                                    </span>
                                @endif
                                
                                @if(isset($product->is_organic) && $product->is_organic)
                                    <span class="product-badge bg-green-500 text-white text-xs px-3 py-1.5 rounded-full font-semibold shadow-lg">
                                        <i class="fas fa-leaf mr-1"></i>Organic
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Quick View Button -->
                            <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                                <a href="{{ route('customer.product.show', $product) }}" class="bg-white text-gray-800 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition-colors duration-300 transform scale-90 group-hover:scale-100 shadow-lg">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="mb-3">
                                <span class="text-xs text-green-600 bg-green-50 px-3 py-1.5 rounded-full font-semibold">
                                    {{ $product->category->name ?? 'Buah Segar' }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition duration-300">
                                {{ $product->name }}
                            </h3>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-500">per kg</span>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center text-yellow-400 text-sm mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <span class="text-gray-500 ml-1">(4.9)</span>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ rand(10, 100) }} reviews</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-box mr-2 text-green-500"></i>
                                    Stok: {{ $product->stock }}
                                </span>
                                @if($product->stock > 0)
                                    <span class="text-sm text-green-600 font-semibold flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="text-sm text-red-600 font-semibold flex items-center">
                                        <i class="fas fa-times-circle mr-1"></i>Habis
                                    </span>
                                @endif
                            </div>
                              @if($product->stock > 0)
                                <form class="add-to-cart-form space-y-3" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center gap-3">
                                        <select name="quantity" class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                            @for($i = 1; $i <= min(5, $product->stock); $i++)
                                                <option value="{{ $i }}">{{ $i }} kg</option>
                                            @endfor
                                        </select>
                                        <button type="submit" class="add-to-cart-btn bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-xl font-semibold cursor-not-allowed">
                                    <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-apple-alt text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Produk</h3>
                        <p class="text-gray-500">Produk akan segera tersedia, silakan kembali lagi nanti.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- View All Products Button -->
            <div class="text-center mt-16">
                <a href="{{ route('customer.products') }}" class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <i class="fas fa-shopping-basket mr-3"></i>
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section><!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Mengapa Pilih FreshMart?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Kami berkomitmen memberikan pengalaman berbelanja buah terbaik dengan jaminan kualitas dan layanan terpercaya untuk kepuasan pelanggan.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Card 1: 100% Organik -->
                <div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-green-200 hover:-translate-y-2">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-leaf text-white text-3xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors duration-300">100% Organik</h3>
                    <p class="text-gray-600 leading-relaxed">Semua produk kami bebas pestisida dan bahan kimia berbahaya, dipetik langsung dari kebun organik terpercaya.</p>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-green-600 font-semibold text-sm">
                            <i class="fas fa-check-circle mr-2"></i>
                            Sertifikat Organik
                        </span>
                    </div>
                </div>

                <!-- Card 2: Pengiriman Cepat -->
                <div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200 hover:-translate-y-2">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-shipping-fast text-white text-3xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors duration-300">Pengiriman Cepat</h3>
                    <p class="text-gray-600 leading-relaxed">Pengiriman same day di area Jabodetabek dengan kemasan khusus agar buah tetap segar sampai tujuan.</p>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-blue-600 font-semibold text-sm">
                            <i class="fas fa-truck mr-2"></i>
                            Gratis Ongkir >50K
                        </span>
                    </div>
                </div>

                <!-- Card 3: Kualitas Premium -->
                <div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-yellow-200 hover:-translate-y-2">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-medal text-white text-3xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-yellow-600 transition-colors duration-300">Kualitas Premium</h3>
                    <p class="text-gray-600 leading-relaxed">Buah pilihan terbaik dari petani terpercaya dengan standar kualitas tinggi dan proses seleksi ketat.</p>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-yellow-600 font-semibold text-sm">
                            <i class="fas fa-star mr-2"></i>
                            Grade A Quality
                        </span>
                    </div>
                </div>

                <!-- Card 4: Harga Terjangkau -->
                <div class="group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-red-200 hover:-translate-y-2">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-heart text-white text-3xl"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-red-600 transition-colors duration-300">Harga Terjangkau</h3>
                    <p class="text-gray-600 leading-relaxed">Harga langsung dari petani tanpa markup berlebihan, memberikan nilai terbaik untuk kualitas premium.</p>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <span class="inline-flex items-center text-red-600 font-semibold text-sm">
                            <i class="fas fa-tags mr-2"></i>
                            Best Value Price
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Statistics Row -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">10K+</div>
                    <div class="text-gray-600 font-medium">Pelanggan Puas</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">500+</div>
                    <div class="text-gray-600 font-medium">Produk Fresh</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">50+</div>
                    <div class="text-gray-600 font-medium">Kota Terjangkau</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 mb-2">99%</div>
                    <div class="text-gray-600 font-medium">Tingkat Kepuasan</div>
                </div>            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-16 bg-gradient-to-r from-yellow-400 to-orange-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <h2 class="text-4xl font-bold mb-4">
                    <i class="fas fa-fire mr-3"></i>
                    Promo Spesial Hari Ini!
                </h2>
                <p class="text-xl mb-8">Dapatkan diskon hingga 30% untuk pembelian minimal Rp 100.000</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <div class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-clock mr-2"></i>
                        Berakhir dalam: 
                        <span class="font-bold" id="countdown">23:59:45</span>
                    </div>
                    <a href="{{ route('customer.products') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-200">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Belanja Sekarang
                    </a>
                </div>            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="w-10 h-10 bg-gradient-green rounded-lg flex items-center justify-center">
                            <i class="fas fa-apple-alt text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">FreshMart</h3>
                            <p class="text-gray-400 text-sm">Buah Segar Berkualitas</p>
                        </div>
                    </div>                    <p class="text-gray-400 mb-4">
                        FreshMart - toko buah online terpercaya dengan kualitas terbaik dan pengiriman cepat ke seluruh Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kategori Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-200">Buah Segar</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Buah Tropis</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Buah Import</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Buah Organik</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Paket Buah</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan Pelanggan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition duration-200">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Cara Belanja</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Pengiriman</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Pengembalian</a></li>
                        <li><a href="#" class="hover:text-white transition duration-200">Hubungi Kami</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak Kami</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-green-500"></i>
                            Bandar Lampung, Indonesia
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 text-green-500"></i>
                            +62 821 1234 5678
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-green-500"></i>
                            info@freshmart.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 text-green-500"></i>
                            Senin - Minggu: 08:00 - 20:00
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 FreshMart. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        function increaseQuantity(button) {
            const input = button.parentElement.querySelector('input[name="quantity"]');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity(button) {
            const input = button.parentElement.querySelector('input[name="quantity"]');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Countdown timer
        function updateCountdown() {
            const now = new Date();
            const endOfDay = new Date();
            endOfDay.setHours(23, 59, 59, 999);
            
            const diff = endOfDay - now;
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.getElementById('countdown').textContent = 
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }        setInterval(updateCountdown, 1000);
        updateCountdown();        // Search functionality with suggestions
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('input[name="search"]');
            const searchSuggestions = [
                'Apel Fuji', 'Apel Hijau', 'Jeruk Manis', 'Jeruk Bali', 'Pisang Cavendish', 
                'Pisang Raja', 'Mangga Harum Manis', 'Mangga Gedong', 'Strawberry Fresh',
                'Anggur Hijau', 'Anggur Merah', 'Semangka', 'Melon', 'Nanas',
                'Buah Naga', 'Kiwi', 'Alpukat', 'Jambu Biji', 'Salak'
            ];

            // Keyboard shortcut Ctrl+K to focus search
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'k') {
                    e.preventDefault();
                    const desktopSearch = document.querySelector('.hidden.md\\:flex input[name="search"]');
                    if (desktopSearch) {
                        desktopSearch.focus();
                        desktopSearch.select();
                    }
                }
                
                // Escape to close suggestions
                if (e.key === 'Escape') {
                    document.querySelectorAll('.search-suggestions').forEach(div => {
                        div.classList.add('hidden');
                    });
                }
            });

            searchInputs.forEach(input => {
                // Create suggestion dropdown
                const suggestionsDiv = document.createElement('div');
                suggestionsDiv.className = 'search-suggestions absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-xl z-50 hidden max-h-60 overflow-y-auto mt-2';
                input.parentElement.appendChild(suggestionsDiv);

                // Show suggestions on focus
                input.addEventListener('focus', function() {
                    if (this.value.length > 0) {
                        showSuggestions(this, suggestionsDiv, searchSuggestions);
                    }
                });

                // Filter suggestions on input
                input.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    if (query.length > 0) {
                        showSuggestions(this, suggestionsDiv, searchSuggestions);
                    } else {
                        suggestionsDiv.classList.add('hidden');
                    }
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!input.parentElement.contains(e.target)) {
                        suggestionsDiv.classList.add('hidden');
                    }
                });

                // Handle keyboard navigation
                input.addEventListener('keydown', function(e) {
                    const suggestions = suggestionsDiv.querySelectorAll('.suggestion-item');
                    let currentIndex = Array.from(suggestions).findIndex(item => item.classList.contains('active'));

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (currentIndex < suggestions.length - 1) {
                            if (currentIndex >= 0) suggestions[currentIndex].classList.remove('active');
                            suggestions[currentIndex + 1].classList.add('active');
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (currentIndex > 0) {
                            suggestions[currentIndex].classList.remove('active');
                            suggestions[currentIndex - 1].classList.add('active');
                        }
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (currentIndex >= 0) {
                            const activeItem = suggestions[currentIndex];
                            const text = activeItem.querySelector('span').textContent;
                            this.value = text;
                            suggestionsDiv.classList.add('hidden');
                        }
                        this.closest('form').submit();
                    } else if (e.key === 'Escape') {
                        suggestionsDiv.classList.add('hidden');
                        this.blur();
                    }
                });
            });

            function showSuggestions(input, suggestionsDiv, suggestions) {
                const query = input.value.toLowerCase();
                const filtered = suggestions.filter(item => 
                    item.toLowerCase().includes(query)
                ).slice(0, 6);

                if (filtered.length > 0) {
                    suggestionsDiv.innerHTML = filtered.map((item, index) => 
                        `<div class="suggestion-item px-4 py-3 hover:bg-green-50 cursor-pointer border-b border-gray-100 last:border-b-0 flex items-center transition-colors duration-200 ${index === 0 ? 'active bg-green-50' : ''}">
                            <i class="fas fa-search text-gray-400 mr-3"></i>
                            <span class="text-gray-700">${item}</span>
                            <i class="fas fa-arrow-up-right text-gray-300 ml-auto text-xs"></i>
                        </div>`
                    ).join('');

                    // Add recent searches or popular searches header
                    const headerHtml = `<div class="px-4 py-2 bg-gray-50 border-b border-gray-200 text-xs text-gray-500 font-medium">
                        <i class="fas fa-fire mr-2"></i>Pencarian Populer
                    </div>`;
                    suggestionsDiv.innerHTML = headerHtml + suggestionsDiv.innerHTML;

                    // Add click event to suggestions
                    suggestionsDiv.querySelectorAll('.suggestion-item').forEach(div => {
                        div.addEventListener('click', function() {
                            const text = this.querySelector('span').textContent;
                            input.value = text;
                            suggestionsDiv.classList.add('hidden');
                            input.closest('form').submit();
                        });

                        div.addEventListener('mouseenter', function() {
                            suggestionsDiv.querySelectorAll('.suggestion-item').forEach(item => {
                                item.classList.remove('active');
                            });
                            this.classList.add('active');
                        });
                    });

                    suggestionsDiv.classList.remove('hidden');
                } else {
                    // Show "no results" message
                    suggestionsDiv.innerHTML = `
                        <div class="px-4 py-6 text-center text-gray-500">
                            <i class="fas fa-search text-2xl mb-2 block"></i>
                            <p class="text-sm">Tidak ada hasil untuk "<strong>${input.value}</strong>"</p>
                            <p class="text-xs mt-1">Coba kata kunci lain atau lihat semua produk</p>
                        </div>`;
                    suggestionsDiv.classList.remove('hidden');
                }
            }

            // Quick search buttons
            const quickSearchTerms = ['Apel', 'Jeruk', 'Pisang', 'Mangga', 'Strawberry'];
            const quickSearchContainer = document.querySelector('.quick-search-container');
            
            if (quickSearchContainer) {
                quickSearchContainer.innerHTML = quickSearchTerms.map(term => 
                    `<button type="button" 
                             onclick="quickSearch('${term}')"
                             class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition-colors duration-200">
                        ${term}
                    </button>`
                ).join('');
            }
        });        // Quick search function
        function quickSearch(term) {
            const form = document.querySelector('form[action*="products"]');
            const input = form.querySelector('input[name="search"]');
            input.value = term;
            form.submit();
        }        // Add to Cart AJAX functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cart count on page load by reading from existing badge
            const existingBadge = document.querySelector('.cart-count-badge');
            let currentCartCount = 0;
            if (existingBadge && existingBadge.style.display !== 'none') {
                currentCartCount = parseInt(existingBadge.textContent) || 0;
            }
            updateCartCount(currentCartCount);            // Create notification container
            const notificationContainer = document.createElement('div');
            notificationContainer.id = 'notification-container';
            notificationContainer.className = 'fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none';
            notificationContainer.style.zIndex = '9999';
            document.body.appendChild(notificationContainer);

            // Handle add to cart forms
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const productName = this.dataset.productName;
                    const quantity = formData.get('quantity');
                    const submitBtn = this.querySelector('.add-to-cart-btn');
                    const originalBtnContent = submitBtn.innerHTML;
                    
                    // Show loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                      // Send AJAX request
                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())                    .then(data => {
                        if (data.success) {
                            // Show success notification
                            showNotification('success', `${productName} (${quantity} kg) berhasil ditambahkan ke keranjang!`);
                            
                            // Update cart count
                            updateCartCount(data.cartCount);
                            
                            // Reset quantity selector back to 1
                            this.querySelector('select[name="quantity"]').value = '1';
                            
                            // Add visual feedback to button
                            submitBtn.classList.add('bg-green-600');
                            setTimeout(() => {
                                submitBtn.classList.remove('bg-green-600');
                            }, 2000);
                        } else {
                            showNotification('error', data.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('error', 'Terjadi kesalahan jaringan. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.disabled = false;
                    });
                });
            });            // Show notification function
            function showNotification(type, message) {
                const notification = document.createElement('div');
                const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                const borderColor = type === 'success' ? 'border-green-300' : 'border-red-300';
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
                
                notification.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl transform translate-x-full transition-all duration-500 max-w-sm border-2 ${borderColor} backdrop-blur-sm pointer-events-auto`;
                notification.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas ${icon} text-2xl"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-bold text-sm mb-1">${type === 'success' ? '✅ Berhasil!' : '❌ Error!'}</p>
                            <p class="text-sm opacity-90 leading-relaxed">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-3 text-white hover:text-gray-200 transition-colors duration-200 p-1 rounded-full hover:bg-white/20">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                `;
                
                notificationContainer.appendChild(notification);
                
                // Animate in with bounce effect
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                    notification.classList.add('animate-pulse');
                }, 100);
                
                // Remove pulse after 1 second
                setTimeout(() => {
                    notification.classList.remove('animate-pulse');
                }, 1000);
                
                // Auto remove after 5 seconds with slide out animation
                setTimeout(() => {
                    notification.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 500);
                }, 5000);
            }

            // Update cart count function
            function updateCartCount(count) {
                const cartBadges = document.querySelectorAll('.cart-count-badge');
                cartBadges.forEach(badge => {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
