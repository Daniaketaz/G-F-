<?php

namespace Database\Seeders;

use App\Models\JewelryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JewelryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jewelry_categories')->insert([
            ['jewelry_category' => 'ring'],
            ['jewelry_category' => 'bracelet'],
            ['jewelry_category' => 'earrings'],
            ['jewelry_category' => 'necklace'],

        ]);
    }
}
