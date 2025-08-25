<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\occasion;

class OccasionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        occasion::create(['id'=>1,'name'=>'graduation']);
        occasion::create(['id'=>2,'name'=>'wedding']);
        occasion::create(['id'=>3,'name'=>'illness']);
        occasion::create(['id'=>4,'name'=>'travel']);
        occasion::create(['id'=>5,'name'=>'apology']);
        occasion::create(['id'=>6,'name'=>'engagement']);
    }
}
