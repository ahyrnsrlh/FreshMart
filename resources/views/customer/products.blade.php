@php
    use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Produk - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #059669, #10b981, #34d399);
        }
        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: #d1fae5;
        }
        .product-image {
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 transition duration-200 flex items-center space-x-1">
                            <i class="fas fa-home text-sm"></i>
                            <span>Beranda</span>
                        </a>                        @auth
                            <a href="{{ route('cart.index') }}" class="relative gradient-green text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 flex items-center space-x-1">
                                <i class="fas fa-shopping-cart text-sm"></i>
                                <span>Keranjang</span>
                                @if(session('cart'))
                                    <span class="cart-count-badge bg-white text-green-600 text-xs rounded-full px-2 py-1 ml-1">
                                        {{ array_sum(array_column(session('cart'), 'quantity')) }}
                                    </span>
                                @else
                                    <span class="cart-count-badge bg-white text-green-600 text-xs rounded-full px-2 py-1 ml-1" style="display: none;">
                                        0
                                    </span>
                                @endif
                            </a>
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
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">                <!-- Page Header -->
                <div class="text-center mb-16 px-4">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-store text-green-600 mr-3"></i>
                        Produk Segar Kami
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Jelajahi koleksi lengkap buah-buahan segar berkualitas premium yang dipetik langsung dari kebun terpercaya
                    </p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto mt-8">
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                            <div class="text-2xl font-bold text-green-600">{{ $products->total() ?? 0 }}+</div>
                            <div class="text-sm text-gray-600">Produk</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                            <div class="text-2xl font-bold text-blue-600">{{ $categories->count() ?? 0 }}+</div>
                            <div class="text-sm text-gray-600">Kategori</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                            <div class="text-2xl font-bold text-yellow-600">100%</div>
                            <div class="text-sm text-gray-600">Organik</div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                            <div class="text-2xl font-bold text-red-600">4.9★</div>
                            <div class="text-sm text-gray-600">Rating</div>
                        </div>
                    </div>
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
                @endif                <!-- Filters -->
                <div class="mb-8">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-filter text-green-600 mr-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Filter & Pencarian</h3>
                        </div>
                        
                        <form method="GET" action="{{ route('customer.products') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search Input -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" name="search" placeholder="Cari buah segar, sayuran, atau produk organik..." 
                                           value="{{ request('search') }}"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                </div>
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <div class="relative">
                                    <i class="fas fa-tags absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <select name="category" class="w-full pl-12 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 appearance-none transition duration-200">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="md:col-span-3 flex flex-wrap gap-3 justify-center">
                                <button type="submit" class="gradient-green text-white font-semibold py-3 px-8 rounded-xl hover:opacity-90 transition duration-200 flex items-center space-x-2">
                                    <i class="fas fa-search"></i>
                                    <span>Cari Produk</span>
                                </button>
                                @if(request('search') || request('category'))
                                    <a href="{{ route('customer.products') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 flex items-center space-x-2">
                                        <i class="fas fa-times"></i>
                                        <span>Reset Filter</span>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                            @if(request('search') || request('category'))
                                <a href="{{ route('customer.products') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-times mr-2"></i>Clear
                                </a>
                            @endif
                        </form>
                    </div>
                </div>                <!-- Products Grid -->
                <div class="px-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                    @forelse($products as $product)
                        <div class="product-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl">
                            <!-- Product Image -->
                            <div class="relative h-64 overflow-hidden bg-gradient-to-br from-green-50 to-green-100">
                                @if($product->image && Storage::disk('public')->exists($product->image))
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image w-full h-full object-cover">
                                @else
                                    <!-- Fallback with product-specific icons -->
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200">
                                        @php
                                            $productName = strtolower($product->name ?? '');
                                            $iconClass = 'fas fa-apple-alt text-green-500';
                                            if (str_contains($productName, 'apel')) $iconClass = 'fas fa-apple-alt text-red-500';
                                            elseif (str_contains($productName, 'jeruk')) $iconClass = 'fas fa-lemon text-orange-500';
                                            elseif (str_contains($productName, 'pisang')) $iconClass = 'fas fa-seedling text-yellow-500';
                                            elseif (str_contains($productName, 'anggur')) $iconClass = 'fas fa-circle text-purple-500';
                                            elseif (str_contains($productName, 'strawberry')) $iconClass = 'fas fa-heart text-red-500';
                                            elseif (str_contains($productName, 'mangga')) $iconClass = 'fas fa-leaf text-green-500';
                                            elseif (str_contains($productName, 'nanas')) $iconClass = 'fas fa-crown text-yellow-600';
                                            elseif (str_contains($productName, 'semangka')) $iconClass = 'fas fa-circle text-green-600';
                                            elseif (str_contains($productName, 'melon')) $iconClass = 'fas fa-circle text-green-400';
                                            elseif (str_contains($productName, 'durian')) $iconClass = 'fas fa-leaf text-green-600';
                                            elseif (str_contains($productName, 'rambutan')) $iconClass = 'fas fa-circle text-red-400';
                                        @endphp
                                        <div class="text-center">
                                            <i class="{{ $iconClass }} text-6xl opacity-60 mb-2 floating-animation"></i>
                                            <p class="text-sm text-gray-600 font-medium">{{ $product->name }}</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Stock Status Badge -->
                                <div class="absolute top-3 left-3">
                                    @if($product->stock <= 5 && $product->stock > 0)
                                        <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Stok Terbatas
                                        </span>
                                    @elseif($product->stock == 0)
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fas fa-times-circle mr-1"></i>Habis
                                        </span>
                                    @else
                                        <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>Tersedia
                                        </span>
                                    @endif
                                </div>

                                <!-- Quick Actions -->
                                <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('customer.product.show', $product) }}" 
                                       class="bg-white/90 backdrop-blur-sm text-gray-700 hover:text-green-600 p-2 rounded-full shadow-lg transition-colors duration-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="bg-white/90 backdrop-blur-sm text-gray-400 hover:text-red-500 p-2 rounded-full shadow-lg transition-colors duration-300">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-6">
                                <!-- Category Badge -->
                                <div class="mb-3">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $product->category->name ?? 'Tidak Berkategori' }}
                                    </span>
                                </div>

                                <!-- Product Name -->
                                <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-green-600 transition-colors duration-300">
                                    {{ $product->name }}
                                </h3>

                                <!-- Price and Stock Info -->
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">Stok: {{ $product->stock }}</div>
                                        @if($product->stock > 0)
                                            <div class="text-xs text-green-600 font-medium">✓ Siap dikirim</div>
                                        @endif
                                    </div>
                                </div>
                                  <!-- Add to Cart Form -->
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form space-y-3" data-product-name="{{ $product->name }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <!-- Quantity Selector -->
                                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                                            <label for="quantity_{{ $product->id }}" class="text-sm font-medium text-gray-700">
                                                <i class="fas fa-sort-numeric-up mr-1 text-green-600"></i>Jumlah:
                                            </label>
                                            <div class="flex items-center space-x-2">
                                                <button type="button" onclick="decreaseQuantity(this)" 
                                                        class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition duration-200">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <input type="number" name="quantity" id="quantity_{{ $product->id }}" 
                                                       min="1" max="{{ $product->stock }}" value="1"
                                                       class="w-16 px-3 py-2 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200">
                                                <button type="button" onclick="increaseQuantity(this, {{ $product->stock }})" 
                                                        class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition duration-200">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Add to Cart Button -->
                                        <button type="submit" class="add-to-cart-btn w-full gradient-green text-white font-semibold py-3 px-4 rounded-xl hover:opacity-90 transition duration-200 flex items-center justify-center space-x-2">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Tambah ke Keranjang</span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full bg-gray-400 text-white font-semibold py-3 px-4 rounded-xl cursor-not-allowed opacity-50 flex items-center justify-center space-x-2">
                                        <i class="fas fa-times-circle"></i>
                                        <span>Stok Habis</span>
                                    </button>
                                @endif
                                  <!-- View Details Button -->
                                <a href="{{ route('customer.product.show', $product) }}" 
                                   class="w-full mt-3 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center space-x-2">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-search text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-600 mb-4">Produk Tidak Ditemukan</h3>
                                <p class="text-gray-500 mb-8">Maaf, kami tidak dapat menemukan produk yang sesuai dengan kriteria pencarian Anda.</p>
                                <a href="{{ route('customer.products') }}" 
                                   class="inline-flex items-center gradient-green text-white font-semibold py-3 px-6 rounded-xl hover:opacity-90 transition duration-200">
                                    <i class="fas fa-refresh mr-2"></i>Lihat Semua Produk
                                </a>
                            </div>                        </div>
                    @endforelse
                    </div>
                </div><!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12 flex justify-center">
                        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-4">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back to Top Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 opacity-0 invisible" 
                    id="backToTop">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>        <script>
            // Back to top button functionality
            window.addEventListener('scroll', function() {
                const backToTop = document.getElementById('backToTop');
                if (window.pageYOffset > 300) {
                    backToTop.classList.remove('opacity-0', 'invisible');
                    backToTop.classList.add('opacity-100', 'visible');
                } else {
                    backToTop.classList.add('opacity-0', 'invisible');
                    backToTop.classList.remove('opacity-100', 'visible');
                }
            });

            // Quantity control functions
            function decreaseQuantity(button) {
                const input = button.parentElement.querySelector('input[name="quantity"]');
                const current = parseInt(input.value);
                if (current > 1) {
                    input.value = current - 1;
                }
            }

            function increaseQuantity(button, maxStock) {
                const input = button.parentElement.querySelector('input[name="quantity"]');
                const current = parseInt(input.value);
                if (current < maxStock) {
                    input.value = current + 1;
                }
            }

            // AJAX Add to Cart functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize cart count on page load
                const currentCartCount = @json(session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0);
                updateCartCount(currentCartCount);

                // Create notification container
                const notificationContainer = document.createElement('div');
                notificationContainer.id = 'notification-container';
                notificationContainer.className = 'fixed top-20 right-4 z-50 space-y-3 pointer-events-none';
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
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menambahkan...';
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
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success notification
                                showNotification('success', `${productName} (${quantity} kg) berhasil ditambahkan ke keranjang!`);
                                
                                // Update cart count
                                updateCartCount(data.cartCount);
                                
                                // Reset form
                                this.reset();
                                this.querySelector('input[name="quantity"]').value = '1';
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
                });

                // Show notification function
                function showNotification(type, message) {
                    const notification = document.createElement('div');
                    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
                    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
                    
                    notification.className = `${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl transform translate-x-full transition-all duration-300 max-w-sm pointer-events-auto border border-white/20`;
                    notification.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas ${icon} text-lg mr-3 mt-0.5"></i>
                            <div class="flex-1">
                                <p class="font-semibold text-sm">${type === 'success' ? 'Berhasil!' : 'Error!'}</p>
                                <p class="text-sm opacity-90">${message}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white hover:text-gray-200 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    notificationContainer.appendChild(notification);
                    
                    // Animate in
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                        notification.classList.add('scale-105');
                    }, 100);
                    
                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        notification.classList.add('translate-x-full', 'opacity-0', 'scale-95');
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    }, 5000);
                }

                // Update cart count function
                function updateCartCount(count) {
                    const cartBadges = document.querySelectorAll('.cart-count-badge');
                    cartBadges.forEach(badge => {
                        if (count > 0) {
                            badge.textContent = count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    </div>
</body>
</html>
