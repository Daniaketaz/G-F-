<?php

namespace Database\Seeders;

use App\Models\SilverProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SilverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SilverProduct::factory(10)->create();
    }
}
