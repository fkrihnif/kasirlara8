<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'category_id' => '1',
            'product_code' => '1000000',
            'name' => 'Tahu Bulat',
            'quantity' => '100',
            'price' => '2000',
            'price3' => '1900',
            'price6' => '1800',
        ]);
        Product::create([
            'category_id' => '2',
            'product_code' => '1000001',
            'name' => 'Teh Hangat',
            'quantity' => '50',
            'price' => '3000',
            'price3' => '1900',
            'price6' => '1800',
        ]);
    }
}
