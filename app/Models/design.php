<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class design extends Model
{
    use HasFactory;
    protected $fillable=['product_id','id','cover_id','user_id','price'];
    public function dtof(){
        return $this->hasMany(design_typeOfFlower::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
