<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                                    </span>                                @else
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
            </div>
        </nav>        <!-- Content -->
        <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
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
                                <a href="{{ route('customer.products') }}" class="text-gray-500 hover:text-green-600 transition-colors duration-200 font-medium">
                                    Products
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 mx-2"></i>
                                <span class="text-green-600 font-semibold">{{ $product->name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-r-xl mb-6 shadow-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-xl mb-6 shadow-lg">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-3 text-lg"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif<!-- Product Detail -->
                <div class="bg-white/90 backdrop-blur-sm shadow-xl overflow-hidden rounded-2xl border border-green-100">
                    <div class="px-6 py-8 sm:p-8">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
                            <!-- Product Image -->
                            <div class="aspect-w-1 aspect-h-1 rounded-2xl bg-gradient-to-br from-green-50 to-green-100 overflow-hidden shadow-lg">
                                @if($product->image && file_exists(public_path('storage/' . $product->image)))
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-96 object-cover rounded-2xl hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-96 flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 rounded-2xl">
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
                                        <div class="text-center">
                                            <i class="{{ $iconClass }} text-8xl opacity-60 mb-4"></i>
                                            <p class="text-lg text-gray-600 font-semibold">{{ $product->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>                            <!-- Product info -->
                            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                                <h1 class="text-4xl font-bold tracking-tight bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent">{{ $product->name }}</h1>
                                
                                <div class="mt-6">
                                    <h2 class="sr-only">Product information</h2>
                                    <p class="text-4xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="mt-8 space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-tag text-green-500"></i>
                                        <span class="text-gray-700">Category:</span>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            {{ $product->category->name ?? 'No Category' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-box text-green-500"></i>
                                        <span class="text-gray-700">Stock:</span>
                                        @if($product->stock > 0)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i>{{ $product->stock }} available
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                <i class="fas fa-times-circle mr-1"></i>Out of stock
                                            </span>
                                        @endif
                                    </div>
                                </div>                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-10">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="flex items-center space-x-6">
                                            <div class="flex items-center space-x-3">
                                                <label for="quantity" class="text-gray-700 font-medium">Quantity:</label>
                                                <select name="quantity" id="quantity" class="bg-white border-2 border-green-200 rounded-xl px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-lg">
                                                    @for($i = 1; $i <= min(10, $product->stock); $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-8 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-3 transform hover:scale-105">
                                                <i class="fas fa-cart-plus"></i>
                                                <span>Add to Cart</span>
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="mt-10">
                                        <button disabled class="w-full bg-gray-400 text-white font-bold py-4 px-8 rounded-xl cursor-not-allowed shadow-lg flex items-center justify-center space-x-3">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Out of Stock</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>                <!-- Related Products -->
                @if($relatedProducts->count() > 0)
                    <div class="mt-20">
                        <h2 class="text-3xl font-bold tracking-tight bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-8">Related Products</h2>
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach($relatedProducts as $relatedProduct)
                                <div class="group relative bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-green-100 transform hover:scale-105">
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-2xl bg-gradient-to-br from-green-50 to-green-100">
                                        @if($relatedProduct->image && file_exists(public_path('storage/' . $relatedProduct->image)))
                                            <img src="{{ asset('storage/' . $relatedProduct->image) }}" 
                                                 alt="{{ $relatedProduct->name }}" 
                                                 class="h-48 w-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="h-48 w-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200">
                                                @php
                                                    $relatedName = strtolower($relatedProduct->name ?? '');
                                                    $relatedIcon = 'fas fa-apple-alt text-green-500';
                                                    if (str_contains($relatedName, 'apel')) $relatedIcon = 'fas fa-apple-alt text-red-500';
                                                    elseif (str_contains($relatedName, 'jeruk')) $relatedIcon = 'fas fa-lemon text-orange-500';
                                                    elseif (str_contains($relatedName, 'pisang')) $relatedIcon = 'fas fa-seedling text-yellow-500';
                                                    elseif (str_contains($relatedName, 'anggur')) $relatedIcon = 'fas fa-circle text-purple-500';
                                                    elseif (str_contains($relatedName, 'strawberry')) $relatedIcon = 'fas fa-heart text-red-500';
                                                    elseif (str_contains($relatedName, 'mangga')) $relatedIcon = 'fas fa-leaf text-green-500';
                                                @endphp
                                                <i class="{{ $relatedIcon }} text-4xl opacity-60"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition-colors duration-200">
                                            <a href="{{ route('customer.product.show', $relatedProduct) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $relatedProduct->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-2 text-sm text-gray-600">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                                {{ $relatedProduct->category->name ?? 'No Category' }}
                                            </span>
                                        </p>
                                        <p class="mt-3 text-xl font-bold text-gray-900">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                                        
                                        @if($relatedProduct->stock > 0)
                                            <div class="mt-3 text-sm text-green-600 font-medium flex items-center">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                In Stock
                                            </div>
                                        @else
                                            <div class="mt-3 text-sm text-red-600 font-medium flex items-center">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Out of Stock
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
