<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->take(8)->get();
        $categories = Category::all();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        return view('customer.index', compact('products', 'categories', 'totalProducts', 'totalCategories'));
    }

    public function products(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('customer.products', compact('products', 'categories'));
    }

    public function showProduct(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('customer.product-detail', compact('product', 'relatedProducts'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
        if ($product->stock < $quantity) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi!'
                ], 400);
            }
            return back()->with('error', 'Stok tidak mencukupi!');
        }
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image ?? null
            ];
        }
        
        Session::put('cart', $cart);
        
        // Calculate total cart quantity
        $cartCount = array_sum(array_column($cart, 'quantity'));
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount,
                'product' => [
                    'name' => $product->name,
                    'quantity' => $quantity
                ]
            ]);
        }
        
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('customer.cart', compact('cart', 'total'));
    }

    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
        }
        
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }
        
        $total = 0;
        $lastTransaction = null;
        
        // Buat transaksi untuk setiap item di cart
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            if (!$product || $product->stock < $item['quantity']) {
                return back()->with('error', 'Stok produk ' . $item['name'] . ' tidak mencukupi!');
            }
            
            // Kurangi stok
            $product->decrement('stock', $item['quantity']);
            
            // Buat transaksi
            $lastTransaction = Transaction::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
                'payment_status' => 'pending',
                'order_status' => 'pending'
            ]);
            
            $total += $item['price'] * $item['quantity'];
        }
        
        // Kosongkan cart
        Session::forget('cart');
        
        // Redirect ke halaman pembayaran untuk transaksi terakhir
        if ($lastTransaction) {
            return redirect()->route('customer.payment.show', $lastTransaction)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        }
        
        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }
        
        $orders = Transaction::with('product')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        
        return view('customer.orders', compact('orders'));
    }

    public function showOrder(Transaction $transaction)
    {
        // Ensure user can only view their own orders
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }
        
        $order = $transaction;
        $order->load('product');
        
        return view('customer.order-detail', compact('order'));
    }

    public function showPayment(Transaction $transaction)
    {
        // Ensure user can only view their own payment
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment.');
        }

        return view('customer.payment', compact('transaction'));
    }

    public function processPayment(Request $request, Transaction $transaction)
    {
        // Ensure user can only process their own payment
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment.');
        }

        $request->validate([
            'payment_method' => 'required|in:transfer_bank,cash,e_wallet',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'payment_notes' => 'nullable|string|max:500'
        ]);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $transaction->update([
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'payment_notes' => $request->payment_notes,
            'payment_status' => 'paid',
            'payment_date' => now(),
            'order_status' => 'confirmed'
        ]);

        return redirect()->route('customer.order.show', $transaction)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda akan segera diproses.');
    }
}
