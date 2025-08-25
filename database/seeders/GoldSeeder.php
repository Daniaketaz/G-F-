<?php

namespace Database\Seeders;

use App\Models\GoldProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoldProduct::factory(10)->create();
    }
}
