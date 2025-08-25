<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoldProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'jewelry_categories',
        'description',
        'weight',
        'accessories price',
        'formulation price',
        'final price',
        'views',
        'name'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function goldCategory()
    {
        return $this->hasMany(JewelryCategory::class, 'id', 'jewelry-categories-id');
    }

}
