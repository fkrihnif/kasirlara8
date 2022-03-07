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
            'product_code' => '001',
            'name' => 'Tahu Bulat',
            'quantity' => '100',
            'price' => '2000',
        ]);
        Product::create([
            'category_id' => '2',
            'product_code' => '002',
            'name' => 'Teh Hangat',
            'quantity' => '50',
            'price' => '3000',
        ]);
    }
}
