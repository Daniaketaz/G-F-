<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bouquet extends Model
{
    use HasFactory;
    protected $fillable=['product_id','price','numberOfSales','description','imagePath'];

    public function TypeOfFlower_Bouquet(){
        return $this->hasMany(TypeOfFlower_Bouquet::class);
    }
    public function bouquet_occasion(){
        return $this->hasMany(bouquet_occasion::class);
    }
    public function FavouriteBouquets(){
        return  $this->hasMany(FavouriteBouquet::class,'FavouriteBouquet_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
