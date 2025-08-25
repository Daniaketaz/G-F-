<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jewelry extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'jewelry_categories',
        'jewelry-types-id',
        'description',
        'weight',
        'accessories price',
        'formulation price',
        'final price',
        'views'
    ];
}
