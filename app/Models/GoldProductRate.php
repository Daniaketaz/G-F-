<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldProductRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'gold_product_id',
        'user_id',
        'rate'
    ];

}
