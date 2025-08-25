<?php

namespace Database\Seeders;

use App\Models\cover;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class coverSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        cover::create([
            'id'=>1,
            'price'=>'20',
            'color'=>'red'
        ]);

    }
}
