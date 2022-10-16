<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('products')->insert([
            'name' => 'KTM 1090',
            'price' => '1000.00',
            'image' => 'https://motorbike.gr/wp-content/uploads/2018/04/KTM-1290-SUPER-ADVENTURE-R.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => 'KTM 1190',
            'price' => '1000.30',
            'image' => 'https://motorbike.gr/wp-content/uploads/2018/04/KTM-1290-SUPER-ADVENTURE-R.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => 'KTM 1290',
            'price' => '10004.20',
            'image' => 'https://motorbike.gr/wp-content/uploads/2018/04/KTM-1290-SUPER-ADVENTURE-R.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
