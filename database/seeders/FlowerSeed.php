<?php

namespace Database\Seeders;

use App\Models\TypeOfFlower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlowerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeOfFlower::create([
            'id'=>1,
            'name'=>'lavander',
            'price'=>'1',
        ]);
        TypeOfFlower::create([
            'id'=>2,
            'name'=>'le',
            'price'=>'1',
        ]);
    }
}
