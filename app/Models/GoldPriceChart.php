<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPriceChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'gold_price'
    ];
}
