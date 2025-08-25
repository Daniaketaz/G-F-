<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteGold extends Model
{
    use HasFactory;
    protected $fillable=['user_id','GoldProduct_id','imagePath'];
    public function user(){
        return  $this->belongsTo(User::class,'user_id');
    }
    public function goldproduct(){
        return  $this->belongsTo(GoldProduct::class,'GoldProduct_id');
    }
}
