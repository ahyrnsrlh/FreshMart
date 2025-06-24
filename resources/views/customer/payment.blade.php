<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - FreshMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gradient-green {
            background: linear-gradient(135deg, #059669, #10b981, #34d399);
        }
        .payment-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .payment-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .payment-method-card {
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .payment-method-card:hover {
            background-color: #f0fdf4;
            border-color: #10b981;
        }
        .payment-method-card.selected {
            background-color: #dcfce7;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-failed { background-color: #fee2e2; color: #991b1b; }
        .status-cancelled { background-color: #f3f4f6; color: #374151; }
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
                        <a href="{{ route('cart.index') }}" class="gradient-green text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 flex items-center space-x-1">
                            <i class="fas fa-shopping-cart text-sm"></i>
                            <span>Keranjang</span>
                            @if(session('cart'))
                                <span class="bg-white text-green-600 text-xs rounded-full px-2 py-1 ml-1">
                                    {{ array_sum(array_column(session('cart'), 'quantity')) }}
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
                    </div>
                </div>
            </div>
        </nav>        <!-- Content -->
        <div class="max-w-6xl mx-auto py-8 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-credit-card text-green-600 mr-3"></i>
                        Pembayaran Pesanan
                    </h1>
                    <p class="text-gray-600 text-lg">Selesaikan pembayaran untuk pesanan Anda</p>
                </div>

                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <ol class="flex items-center space-x-4 text-sm">
                            <li>
                                <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700 flex items-center">
                                    <i class="fas fa-home mr-2"></i>
                                    Beranda
                                </a>
                            </li>
                            <li class="text-gray-400">/</li>
                            <li>
                                <a href="{{ route('customer.orders') }}" class="text-green-600 hover:text-green-700">Pesanan Saya</a>
                            </li>
                            <li class="text-gray-400">/</li>
                            <li class="text-gray-900 font-medium">Pembayaran Order #{{ $transaction->id }}</li>
                        </ol>
                    </div>
                </nav>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold mb-2">Terdapat kesalahan:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">                    <!-- Order Summary -->
                    <div class="lg:col-span-2">
                        <div class="bg-white payment-card rounded-3xl shadow-xl overflow-hidden">
                            <div class="px-8 py-6 bg-gradient-to-r from-green-500 to-emerald-600">
                                <h2 class="text-2xl font-bold text-white flex items-center">
                                    <i class="fas fa-receipt mr-3"></i>
                                    Ringkasan Pesanan
                                </h2>
                            </div>
                            
                            <div class="p-8">
                                <!-- Product Card -->
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 mb-6 border-2 border-green-100">
                                    <div class="flex items-center space-x-6">                                        <div class="w-24 h-24 bg-gradient-to-br from-green-200 to-green-300 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                            @if($transaction->product->image && file_exists(public_path('storage/' . $transaction->product->image)))
                                                <img src="{{ asset('storage/' . $transaction->product->image) }}" 
                                                     alt="{{ $transaction->product->name }}" 
                                                     class="w-full h-full object-cover rounded-xl">
                                            @else
                                                @php
                                                    $productName = strtolower($transaction->product->name ?? '');
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
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $transaction->product->name }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    {{ $transaction->product->category->name ?? 'No Category' }}
                                                </span>
                                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                                    <i class="fas fa-cube mr-1"></i>
                                                    {{ $transaction->quantity }} item
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                                            <p class="text-sm text-gray-500">Total Harga</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Summary -->
                                <div class="border-t border-gray-200 pt-6">
                                    <div class="space-y-4">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Subtotal ({{ $transaction->quantity }} item)</span>
                                            <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-gray-600">
                                            <span>Ongkos Kirim</span>
                                            <span class="text-green-600 font-medium">GRATIS</span>
                                        </div>
                                        <div class="border-t pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-xl font-bold text-gray-900">Total Pembayaran</span>
                                                <span class="text-3xl font-bold text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Info -->
                                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-info text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-blue-900 mb-1">Informasi Pesanan</h4>
                                            <div class="text-sm text-blue-800 space-y-1">
                                                <p><strong>Order ID:</strong> #{{ $transaction->id }}</p>
                                                <p><strong>Tanggal Pesanan:</strong> {{ $transaction->created_at->format('d F Y, H:i') }}</p>
                                                <p><strong>Status:</strong> 
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium status-{{ $transaction->payment_status }}">
                                                        {{ ucfirst($transaction->payment_status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    <!-- Payment Form -->
                    <div class="lg:col-span-3">
                        <div class="bg-white payment-card rounded-3xl shadow-xl overflow-hidden">
                            <div class="px-8 py-6 bg-gradient-to-r from-blue-500 to-blue-600">
                                <h2 class="text-2xl font-bold text-white flex items-center">
                                    <i class="fas fa-credit-card mr-3"></i>
                                    Metode Pembayaran
                                </h2>
                            </div>
                            
                            <div class="p-8">
                                @if($transaction->payment_status === 'pending')
                                    <form action="{{ route('customer.payment.process', $transaction) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                                        @csrf
                                        
                                        <!-- Payment Method Selection -->
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                                            <p class="text-gray-600 mb-6">Pilih salah satu metode pembayaran yang tersedia</p>
                                            
                                            <div class="space-y-4">
                                                <!-- Transfer Bank -->
                                                <label class="payment-method-card block p-6 border-2 border-gray-200 rounded-xl cursor-pointer">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="radio" name="payment_method" value="transfer_bank" 
                                                               class="w-5 h-5 text-green-600 focus:ring-green-500" required>
                                                        <div class="flex-1 flex items-center space-x-4">
                                                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                                                <i class="fas fa-university text-blue-600 text-xl"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-900">Transfer Bank</h4>
                                                                <p class="text-sm text-gray-600">BCA, Mandiri, BRI, BNI</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-green-600 font-semibold">Populer</div>
                                                    </div>
                                                </label>

                                                <!-- E-Wallet -->
                                                <label class="payment-method-card block p-6 border-2 border-gray-200 rounded-xl cursor-pointer">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="radio" name="payment_method" value="e_wallet" 
                                                               class="w-5 h-5 text-green-600 focus:ring-green-500">
                                                        <div class="flex-1 flex items-center space-x-4">
                                                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                                                <i class="fas fa-mobile-alt text-purple-600 text-xl"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-900">E-Wallet</h4>
                                                                <p class="text-sm text-gray-600">OVO, GoPay, Dana, ShopeePay</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-orange-600 font-semibold">Instan</div>
                                                    </div>
                                                </label>

                                                <!-- Cash on Delivery -->
                                                <label class="payment-method-card block p-6 border-2 border-gray-200 rounded-xl cursor-pointer">
                                                    <div class="flex items-center space-x-4">
                                                        <input type="radio" name="payment_method" value="cash" 
                                                               class="w-5 h-5 text-green-600 focus:ring-green-500">
                                                        <div class="flex-1 flex items-center space-x-4">
                                                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                                                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                                                            </div>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-900">Cash on Delivery (COD)</h4>
                                                                <p class="text-sm text-gray-600">Bayar tunai saat barang diterima</p>
                                                            </div>
                                                        </div>
                                                        <div class="text-green-600 font-semibold">Aman</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Payment Instructions -->
                                        <div id="payment-instructions" class="hidden">
                                            <div class="bg-gray-50 rounded-xl p-6">
                                                <div id="transfer-instructions" class="hidden">
                                                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                                        <i class="fas fa-university text-blue-600 mr-2"></i>
                                                        Instruksi Transfer Bank
                                                    </h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-blue-600 mb-2">Bank BCA</div>
                                                            <div class="text-gray-700">1234567890</div>
                                                            <div class="text-gray-600 text-xs">a.n. FreshMart Indonesia</div>
                                                        </div>
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-red-600 mb-2">Bank Mandiri</div>
                                                            <div class="text-gray-700">0987654321</div>
                                                            <div class="text-gray-600 text-xs">a.n. FreshMart Indonesia</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                                        <p class="text-yellow-800 font-medium">
                                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                                            Transfer sejumlah <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div id="cash-instructions" class="hidden">
                                                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                                        <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                                        Cash on Delivery (COD)
                                                    </h4>
                                                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                                        <div class="text-green-800">
                                                            <p class="font-medium mb-2">Pembayaran akan dilakukan saat produk diterima.</p>
                                                            <p>Siapkan uang pas sejumlah <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong></p>
                                                            <p class="text-sm mt-2">Kurir akan menghubungi Anda sebelum pengiriman.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div id="ewallet-instructions" class="hidden">
                                                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                                                        <i class="fas fa-mobile-alt text-purple-600 mr-2"></i>
                                                        E-Wallet
                                                    </h4>
                                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-green-600 mb-2">OVO</div>
                                                            <div class="text-gray-700">0812-3456-7890</div>
                                                        </div>
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-blue-600 mb-2">GoPay</div>
                                                            <div class="text-gray-700">0812-3456-7890</div>
                                                        </div>
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-blue-500 mb-2">Dana</div>
                                                            <div class="text-gray-700">0812-3456-7890</div>
                                                        </div>
                                                        <div class="bg-white p-4 rounded-lg border">
                                                            <div class="font-semibold text-orange-600 mb-2">ShopeePay</div>
                                                            <div class="text-gray-700">0812-3456-7890</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 p-4 bg-purple-50 rounded-lg border border-purple-200">
                                                        <p class="text-purple-800 font-medium">
                                                            <i class="fas fa-mobile-alt mr-2"></i>
                                                            Transfer sejumlah <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Proof Upload -->
                                        <div>
                                            <label for="payment_proof" class="block text-lg font-semibold text-gray-900 mb-2">
                                                <i class="fas fa-camera mr-2 text-green-600"></i>
                                                Bukti Pembayaran (Opsional)
                                            </label>
                                            <p class="text-gray-600 mb-4">Upload foto bukti transfer untuk mempercepat verifikasi</p>
                                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-400 transition duration-200">
                                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" 
                                                       class="hidden" onchange="updateFileName(this)">
                                                <label for="payment_proof" class="cursor-pointer">
                                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <i class="fas fa-cloud-upload-alt text-green-600 text-2xl"></i>
                                                    </div>
                                                    <div class="text-gray-600">
                                                        <span class="text-green-600 font-semibold">Klik untuk upload</span> atau drag & drop
                                                    </div>
                                                    <div class="text-sm text-gray-500 mt-1">JPG, PNG, maksimal 2MB</div>
                                                </label>
                                                <div id="file-name" class="mt-2 text-sm text-green-600 font-medium hidden"></div>
                                            </div>
                                        </div>

                                        <!-- Payment Notes -->
                                        <div>
                                            <label for="payment_notes" class="block text-lg font-semibold text-gray-900 mb-2">
                                                <i class="fas fa-sticky-note mr-2 text-blue-600"></i>
                                                Catatan Pembayaran (Opsional)
                                            </label>
                                            <textarea name="payment_notes" id="payment_notes" rows="4" 
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                                                      placeholder="Contoh: Transfer dari rekening BCA atas nama John Doe pada tanggal 24 Juni 2025"></textarea>
                                        </div>

                                        <!-- Submit Buttons -->
                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <button type="submit" 
                                                    class="flex-1 gradient-green text-white py-4 px-6 rounded-xl font-bold text-lg hover:opacity-90 transition duration-200 flex items-center justify-center space-x-3">
                                                <i class="fas fa-check-circle"></i>
                                                <span>Konfirmasi Pembayaran</span>
                                            </button>
                                            <a href="{{ route('customer.order.show', $transaction) }}" 
                                               class="flex-1 bg-gray-200 text-gray-800 py-4 px-6 rounded-xl text-center font-bold text-lg hover:bg-gray-300 transition duration-200 flex items-center justify-center space-x-3">
                                                <i class="fas fa-arrow-left"></i>
                                                <span>Kembali</span>
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <div class="text-center py-12">
                                        <div class="w-24 h-24 mx-auto mb-6 flex items-center justify-center rounded-full
                                                    {{ $transaction->payment_status === 'paid' ? 'bg-green-100' : ($transaction->payment_status === 'failed' ? 'bg-red-100' : 'bg-gray-100') }}">
                                            <i class="fas {{ $transaction->payment_status === 'paid' ? 'fa-check-circle text-green-600' : ($transaction->payment_status === 'failed' ? 'fa-times-circle text-red-600' : 'fa-clock text-gray-600') }} text-4xl"></i>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-4">
                                            @if($transaction->payment_status === 'paid')
                                                Pembayaran Berhasil!
                                            @elseif($transaction->payment_status === 'failed')
                                                Pembayaran Gagal
                                            @else
                                                Status Pembayaran
                                            @endif
                                        </h3>
                                        <div class="mb-6">
                                            <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold status-{{ $transaction->payment_status }}">
                                                {{ ucfirst($transaction->payment_status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mb-8">Pembayaran untuk pesanan ini sudah {{ $transaction->payment_status }}.</p>
                                        <a href="{{ route('customer.order.show', $transaction) }}" 
                                           class="gradient-green text-white py-3 px-8 rounded-xl font-semibold hover:opacity-90 transition duration-200 inline-flex items-center space-x-2">
                                            <i class="fas fa-eye"></i>
                                            <span>Lihat Detail Pesanan</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>            </div>
        </div>
    </div>

    <script>
        // Payment method selection functionality
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const instructionsDiv = document.getElementById('payment-instructions');
        const transferInst = document.getElementById('transfer-instructions');
        const cashInst = document.getElementById('cash-instructions');
        const ewalletInst = document.getElementById('ewallet-instructions');

        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.classList.remove('selected');
                });
                
                // Add selected class to clicked card
                this.closest('.payment-method-card').classList.add('selected');
                
                // Show instructions
                instructionsDiv.classList.remove('hidden');
                transferInst.classList.add('hidden');
                cashInst.classList.add('hidden');
                ewalletInst.classList.add('hidden');

                if (this.value === 'transfer_bank') {
                    transferInst.classList.remove('hidden');
                } else if (this.value === 'cash') {
                    cashInst.classList.remove('hidden');
                } else if (this.value === 'e_wallet') {
                    ewalletInst.classList.remove('hidden');
                }
            });
        });

        // File upload name display
        function updateFileName(input) {
            const fileNameDiv = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDiv.textContent = '📎 ' + input.files[0].name;
                fileNameDiv.classList.remove('hidden');
            } else {
                fileNameDiv.classList.add('hidden');
            }
        }

        // Enhanced hover effects for payment method cards
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                }
            });
        });
    </script>
</body>
</html>
