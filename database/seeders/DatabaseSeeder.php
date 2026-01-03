<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call(CategorySeeder::class);

        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@marketplace.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'role' => 'admin',
            ]
        );

        // Create Seller User with Shop
        $seller = User::updateOrCreate(
            ['email' => 'seller@marketplace.com'],
            [
                'name' => 'Seller User',
                'password' => bcrypt('password'),
                'phone' => '081234567891',
                'role' => 'seller',
            ]
        );

        Shop::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'name' => 'Demo Shop',
                'slug' => Str::slug('Demo Shop'),
                'description' => 'This is a demo shop for testing purposes.',
                'address' => 'Jl. Demo No. 123, Jakarta',
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_holder' => 'Seller User',
            ]
        );

        // Create Buyer User
        User::updateOrCreate(
            ['email' => 'buyer@marketplace.com'],
            [
                'name' => 'Buyer User',
                'password' => bcrypt('password'),
                'phone' => '081234567892',
                'role' => 'buyer',
            ]
        );
    }
}
