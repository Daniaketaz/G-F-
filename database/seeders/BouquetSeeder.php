<?php

namespace Database\Seeders;

use App\Models\Bouquet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BouquetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouquet::factory(10)->create();
    }
}
