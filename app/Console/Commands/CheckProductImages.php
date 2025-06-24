<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class CheckProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:product-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check product images status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::all();
        
        $this->info('Product Images Status:');
        $this->info('=====================');
        
        foreach ($products as $product) {
            $status = '';
            if ($product->image) {
                if (Storage::disk('public')->exists($product->image)) {
                    $status = '✅ Image exists: ' . $product->image;
                } else {
                    $status = '❌ Image missing: ' . $product->image;
                }
                
                // Also check if public symlink is working
                $publicPath = public_path('storage/' . $product->image);
                if (file_exists($publicPath)) {
                    $status .= ' (Public link: ✅)';
                } else {
                    $status .= ' (Public link: ❌)';
                }
            } else {
                $status = '⚠️  No image assigned';
            }
            
            $this->line($product->name . ' => ' . $status);
        }
        
        $this->info('');
        $this->info('Summary:');
        $this->info('Total products: ' . $products->count());
        $this->info('Products with images: ' . $products->whereNotNull('image')->count());
        $this->info('Products without images: ' . $products->whereNull('image')->count());
        
        // Check storage link
        $this->info('');
        $this->info('Storage Link Status:');
        $storageLinkExists = is_link(public_path('storage')) || is_dir(public_path('storage'));
        $this->info('Storage symlink exists: ' . ($storageLinkExists ? '✅' : '❌'));
        
        return 0;
    }
}
