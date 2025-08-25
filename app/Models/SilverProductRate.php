<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SilverProductRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'silver_product_id',
        'user_id'
    ];
}
