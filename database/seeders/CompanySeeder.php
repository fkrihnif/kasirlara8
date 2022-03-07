<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Toko Pak Agus',
            'address' => 'Jl. Kemang Sari Kab Majalengka'
        ]);
    }
}
