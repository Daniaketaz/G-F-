<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
            ['product_type' => 'gold'],
            ['product_type' => 'silver'],
            ['product_type' => 'flower bouquet'],
            ['product_type' => 'rose design']
        ]);
    }
}
