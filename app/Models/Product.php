<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product-type-id'];

    public function productType()
    {
        return $this->hasOne(productType::class, 'product-type-id', 'id');
    }

    public function gold()
    {
        return $this->hasOne(GoldProduct::class, 'product_id', 'id');
    }

    public function silvers()
    {
        return $this->hasOne(SilverProduct::class, 'product_id', 'id');
    }

    public function bouquets()
    {
        return $this->hasOne(Bouquet::class, 'product_id', 'id');
    }

    public function designs()
    {
        return $this->hasOne(design::class, 'product_id', 'id');
    }

}

