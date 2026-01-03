<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;

class FixImagePaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:image-paths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix image paths by removing /storage/ prefix from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing image paths...');

        // Fix product images
        $productsUpdated = 0;
        Product::whereNotNull('image_url')
            ->where('image_url', 'like', '/storage/%')
            ->chunk(100, function ($products) use (&$productsUpdated) {
                foreach ($products as $product) {
                    $product->image_url = str_replace('/storage/', '', $product->image_url);
                    $product->save();
                    $productsUpdated++;
                }
            });

        // Fix order payment proofs
        $ordersUpdated = 0;
        Order::whereNotNull('payment_proof')
            ->where('payment_proof', 'like', '/storage/%')
            ->chunk(100, function ($orders) use (&$ordersUpdated) {
                foreach ($orders as $order) {
                    $order->payment_proof = str_replace('/storage/', '', $order->payment_proof);
                    $order->save();
                    $ordersUpdated++;
                }
            });

        $this->info("Fixed {$productsUpdated} product images");
        $this->info("Fixed {$ordersUpdated} payment proofs");
        $this->info('Done!');

        return Command::SUCCESS;
    }
}
