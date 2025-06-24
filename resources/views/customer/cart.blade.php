<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #059669, #10b981, #34d399);
        }
        .cart-item-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        .cart-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #d1fae5;
        }
        .quantity-input {
            transition: all 0.2s ease;
        }        .quantity-input:focus {
            --tw-ring-color: #10b981;
            border-color: #10b981;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 gradient-green rounded-lg flex items-center justify-center">
                                <i class="fas fa-apple-alt text-white text-lg"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-gray-900">FreshMart</h1>
                                <p class="text-xs text-gray-500">Buah Segar Berkualitas</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('customer.products') }}" class="text-gray-700 hover:text-green-600 transition duration-200 flex items-center space-x-1">
                            <i class="fas fa-store text-sm"></i>
                            <span>Produk</span>
                        </a>
                        @auth
                            <a href="{{ route('customer.orders') }}" class="text-gray-700 hover:text-green-600 transition duration-200 flex items-center space-x-1">
                                <i class="fas fa-receipt text-sm"></i>
                                <span>Pesanan Saya</span>
                            </a>
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700 text-sm">{{ auth()->user()->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center space-x-1">
                                    <i class="fas fa-sign-out-alt text-sm"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        @else
                            <a href="/admin/login" class="gradient-green text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 flex items-center space-x-1">
                                <i class="fas fa-sign-in-alt text-sm"></i>
                                <span>Masuk</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>        <!-- Content -->
        <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                        Keranjang Belanja
                    </h1>
                    <p class="text-gray-600 text-lg">Tinjauan produk yang akan Anda beli</p>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if(empty($cart))
                    <div class="text-center py-20">
                        <div class="bg-white rounded-3xl shadow-lg p-12 max-w-md mx-auto">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Keranjang Kosong</h3>
                            <p class="text-gray-600 mb-8">Mulai berbelanja untuk menambahkan produk ke keranjang Anda</p>
                            <a href="{{ route('customer.products') }}" class="inline-flex items-center px-8 py-4 gradient-green text-white font-semibold rounded-xl shadow-lg hover:opacity-90 transition duration-200">
                                <i class="fas fa-store mr-3"></i>
                                Mulai Belanja
                            </a>
                        </div>
                    </div>
                @else                    <div class="bg-white shadow-xl rounded-3xl overflow-hidden">
                        <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-emerald-600">
                            <h2 class="text-2xl font-bold text-white flex items-center">
                                <i class="fas fa-list-ul mr-3"></i>
                                Detail Pesanan
                            </h2>
                        </div>
                        
                        <div class="p-8">
                            <div class="space-y-6">                                @foreach($cart as $productId => $item)
                                    <div class="cart-item-card bg-gradient-to-r from-white to-gray-50 rounded-2xl p-6 hover:from-green-50 hover:to-emerald-50 border border-gray-200 hover:border-green-200 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6"><!-- Product Image -->
                                            <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                @if(isset($item['image']) && $item['image'] && file_exists(public_path('storage/' . $item['image'])))
                                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                                         alt="{{ $item['name'] }}" 
                                                         class="w-full h-full object-cover rounded-xl">
                                                @else
                                                    @php
                                                        $productName = strtolower($item['name'] ?? '');
                                                        $iconClass = 'fas fa-apple-alt text-green-600';
                                                        if (str_contains($productName, 'apel')) $iconClass = 'fas fa-apple-alt text-red-500';
                                                        elseif (str_contains($productName, 'jeruk')) $iconClass = 'fas fa-lemon text-orange-500';
                                                        elseif (str_contains($productName, 'pisang')) $iconClass = 'fas fa-seedling text-yellow-500';
                                                        elseif (str_contains($productName, 'anggur')) $iconClass = 'fas fa-circle text-purple-500';
                                                        elseif (str_contains($productName, 'strawberry')) $iconClass = 'fas fa-heart text-red-500';
                                                        elseif (str_contains($productName, 'mangga')) $iconClass = 'fas fa-leaf text-green-500';
                                                        elseif (str_contains($productName, 'durian')) $iconClass = 'fas fa-spa text-yellow-600';
                                                        elseif (str_contains($productName, 'rambutan')) $iconClass = 'fas fa-globe text-red-400';
                                                    @endphp
                                                    <i class="{{ $iconClass }} text-3xl"></i>
                                                @endif
                                            </div>                                            
                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-col md:flex-row md:items-start md:justify-between space-y-3 md:space-y-0">
                                                    <div class="flex-1">
                                                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">{{ $item['name'] }}</h3>
                                                        <p class="text-green-600 font-semibold text-lg mb-3">Rp {{ number_format($item['price'], 0, ',', '.') }} <span class="text-sm text-gray-500">/ item</span></p>
                                                    </div>
                                                    
                                                    <!-- Item Total - Mobile -->
                                                    <div class="text-center md:hidden bg-green-50 p-3 rounded-xl">
                                                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                                        <p class="text-sm text-gray-500">{{ $item['quantity'] }} item{{ $item['quantity'] > 1 ? 's' : '' }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 mt-4">
                                                    <!-- Quantity Control -->
                                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center space-x-3">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                                        <label for="quantity_{{ $productId }}" class="text-sm font-medium text-gray-600">Jumlah:</label>
                                                        <div class="flex items-center space-x-2">                                                            <button type="button" onclick="decreaseQuantity('{{ $productId }}')" 
                                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition duration-200">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                            <input type="number" name="quantity" id="quantity_{{ $productId }}" 
                                                                   min="1" value="{{ $item['quantity'] }}"
                                                                   class="w-16 px-3 py-2 border border-gray-300 rounded-lg text-center quantity-input focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                                   onchange="this.form.submit()">
                                                            <button type="button" onclick="increaseQuantity('{{ $productId }}')" 
                                                                    class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition duration-200">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    
                                                    <!-- Remove Button -->
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-700 font-medium bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg transition duration-200 flex items-center space-x-2"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                            <i class="fas fa-trash text-sm"></i>
                                                            <span>Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>                                            </div>
                                            
                                            <!-- Item Total - Desktop -->
                                            <div class="hidden md:block text-right">
                                                <div class="bg-green-50 p-4 rounded-xl">
                                                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                                    <p class="text-sm text-gray-500">{{ $item['quantity'] }} item{{ $item['quantity'] > 1 ? 's' : '' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Cart Summary -->
                        <div class="border-t border-gray-200 bg-gray-50 px-8 py-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xl font-semibold text-gray-900">Total Belanja</span>
                                <span class="text-3xl font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-6 text-center">Ongkos kirim dan pajak akan dihitung saat checkout</p>
                            
                            <div class="space-y-4">
                                @auth
                                    <form action="{{ route('checkout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full gradient-green text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:opacity-90 transition duration-200 flex items-center justify-center space-x-3">
                                            <i class="fas fa-credit-card"></i>
                                            <span>Lanjut ke Pembayaran</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="/admin/login" class="w-full gradient-green text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:opacity-90 transition duration-200 flex items-center justify-center space-x-3">
                                        <i class="fas fa-sign-in-alt"></i>
                                        <span>Masuk untuk Checkout</span>
                                    </a>
                                @endauth
                                
                                <div class="text-center">
                                    <a href="{{ route('customer.products') }}" class="text-green-600 font-semibold hover:text-green-700 transition duration-200 flex items-center justify-center space-x-2">
                                        <i class="fas fa-arrow-left"></i>
                                        <span>Lanjut Belanja</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif            </div>
        </div>
    </div>

    <script>
        function increaseQuantity(productId) {
            const input = document.getElementById('quantity_' + productId);
            input.value = parseInt(input.value) + 1;
            input.form.submit();
        }

        function decreaseQuantity(productId) {
            const input = document.getElementById('quantity_' + productId);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                input.form.submit();
            }
        }
    </script>
</body>
</html>
