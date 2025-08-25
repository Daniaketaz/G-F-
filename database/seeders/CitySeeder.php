<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     City::create([
         'id'=>1,
         'city_name'=>'Damascus'
     ]);
        City::create([
            'id'=>2,

            'city_name'=>'Aleppo'
        ]);
        City::create([
            'id'=>3,
            'city_name'=>'Latakia'
        ]);
        City::create([
            'id'=>4,
            'city_name'=>'Idlib'
        ]);
        City::create([
            'id'=>5,
            'city_name'=>'Raqqa'
        ]);
        City::create([
            'id'=>6,
            'city_name'=>'Hama'
        ]);
        //3
        City::create([
            'id'=>7,
            'city_name'=>'Homs'
        ]);
        City::create([
            'id'=>8,
            'city_name'=>'Tartus'
        ]);
        //4
        City::create([
            'id'=>9,
            'city_name'=>'Quneitra'
        ]);
        City::create([
            'id'=>10,
            'city_name'=>'Daraa'
        ]);
        City::create([
            'id'=>11,
            'city_name'=>'Al_Suwayda'
        ]);
        City::create([
            'id'=>12,
            'city_name'=>'Al_hasakah'
        ]);
        City::create([
            'id'=>13,
            'city_name'=>'Deir_ez_zor'
        ]);
        City::create([
            'id'=>14,
            'city_name'=>'Rif_Dimashq'
        ]);

        //14

    }
}
