<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bouquet;
use App\Models\Cart;
use App\Models\GoldProduct;
use App\Models\Product;
use App\Models\Session;
use App\Models\SilverProduct;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            ProductTypeSeeder::class,
            JewelryCategorySeeder::class,
            GoldSeeder::class,
            SilverSeeder::class,
            ProductSeeder::class,
            CitySeeder::class,
            SessionSeeder::class,
            CartSeeder::class,
            OccasionsSeeder::class,
            coverSeed::class,
            FlowerSeed::class,
            BouquetSeeder::class,

        ]);
    }
}
