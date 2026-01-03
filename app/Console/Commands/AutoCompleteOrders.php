<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:autocomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically complete orders that have been shipped for more than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for orders to auto-complete...');

        // Find orders that are shipped and updated_at is older than 7 days
        $sevenDaysAgo = now()->subDays(7);
        
        $orders = Order::where('status', 'shipped')
            ->where('updated_at', '<=', $sevenDaysAgo)
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
            $count++;

            $this->line("Order {$order->invoice_number} auto-completed");
        }

        $message = "Auto-completed {$count} order(s)";
        $this->info($message);
        Log::info($message);

        return Command::SUCCESS;
    }
}
