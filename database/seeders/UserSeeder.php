<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password')
        ]);
        // create kasir
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@mail.com',
            'role' => 'cashier',
            'password' => bcrypt('password'),
        ]);
    }
}
