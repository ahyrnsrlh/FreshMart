<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        // Array of product names and their corresponding real image URLs
        $productImages = [
            'Apel Fuji' => 'https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Jeruk Valencia' => 'https://images.unsplash.com/photo-1547514701-42782101795e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Pisang Cavendish' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Strawberry' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Mangga Harum Manis' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Anggur Merah' => 'https://images.unsplash.com/photo-1537640538966-79f369143f8f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Nanas Madu' => 'https://images.unsplash.com/photo-1490885578174-acda8905c2c6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Semangka' => 'https://images.unsplash.com/photo-1589984662646-e7b2e4962907?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Melon' => 'https://images.unsplash.com/photo-1571068316344-75bc76f77890?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Kiwi' => 'https://images.unsplash.com/photo-1585059895524-72359e06133a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Alpukat' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Lemon' => 'https://images.unsplash.com/photo-1590502593747-42a4e2fe46e7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Papaya' => 'https://images.unsplash.com/photo-1617112848923-cc2234396a80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Pear' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
            'Coconut' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        ];

        $products = Product::all();

        foreach ($products as $product) {
            // Skip if product already has an image
            if ($product->image) {
                $this->command->info("Product {$product->name} already has an image. Skipping...");
                continue;
            }

            // Find a matching image URL based on product name
            $imageUrl = null;
            foreach ($productImages as $fruitName => $url) {
                if (stripos($product->name, explode(' ', $fruitName)[0]) !== false) {
                    $imageUrl = $url;
                    break;
                }
            }

            // If no specific match found, use a generic fruit image
            if (!$imageUrl) {
                $genericImages = array_values($productImages);
                $imageUrl = $genericImages[array_rand($genericImages)];
            }

            try {
                // Download the image
                $response = Http::timeout(30)->get($imageUrl);
                
                if ($response->successful()) {
                    // Generate a unique filename
                    $extension = 'jpg';
                    $filename = uniqid() . '.' . $extension;
                    
                    // Store the image
                    Storage::disk('public')->put('products/' . $filename, $response->body());
                    
                    // Update the product with the image path
                    $product->update(['image' => 'products/' . $filename]);
                    
                    $this->command->info("Downloaded and assigned image for: {$product->name}");
                } else {
                    $this->command->error("Failed to download image for: {$product->name}");
                }
            } catch (\Exception $e) {
                $this->command->error("Error downloading image for {$product->name}: " . $e->getMessage());
            }

            // Add a small delay to be respectful to the image source
            sleep(1);
        }

        $this->command->info('Product image seeding completed!');
    }
}
