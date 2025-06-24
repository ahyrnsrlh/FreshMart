<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user admin
        $admin = User::factory()->create([
            'name' => 'Admin FreshMart',
            'email' => 'admin@freshmart.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat user customer
        $customer = User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@freshmart.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Buat kategori buah
        $categories = [
            ['name' => 'Buah Tropis'],
            ['name' => 'Buah Impor'],
            ['name' => 'Buah Lokal'],
            ['name' => 'Buah Organik'],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Buat produk buah
        $products = [
            [
                'name' => 'Apel Fuji',
                'price' => 25000,
                'stock' => 100,
                'category_id' => 2, // Buah Impor
            ],
            [
                'name' => 'Mangga Harum Manis',
                'price' => 15000,
                'stock' => 50,
                'category_id' => 3, // Buah Lokal
            ],
            [
                'name' => 'Pisang Ambon',
                'price' => 8000,
                'stock' => 200,
                'category_id' => 1, // Buah Tropis
            ],
            [
                'name' => 'Jeruk Bali',
                'price' => 12000,
                'stock' => 75,
                'category_id' => 3, // Buah Lokal
            ],
            [
                'name' => 'Anggur Hijau',
                'price' => 35000,
                'stock' => 30,
                'category_id' => 2, // Buah Impor
            ],
            [
                'name' => 'Durian Monthong',
                'price' => 45000,
                'stock' => 20,
                'category_id' => 1, // Buah Tropis
            ],
            [
                'name' => 'Strawberry Organik',
                'price' => 28000,
                'stock' => 40,
                'category_id' => 4, // Buah Organik
            ],
            [
                'name' => 'Rambutan',
                'price' => 10000,
                'stock' => 80,
                'category_id' => 1, // Buah Tropis
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Buat beberapa transaksi contoh
        $transactions = [
            [
                'product_id' => 1, // Apel Fuji
                'quantity' => 2,
                'total_price' => 50000,
            ],
            [
                'product_id' => 3, // Pisang Ambon
                'quantity' => 5,
                'total_price' => 40000,
            ],
            [
                'product_id' => 7, // Strawberry Organik
                'quantity' => 1,
                'total_price' => 28000,
            ],
        ];

        foreach ($transactions as $transactionData) {
            Transaction::create($transactionData);
        }

        // Tambahkan gambar untuk produk
        $this->call(ProductImageSeeder::class);
    }
}
