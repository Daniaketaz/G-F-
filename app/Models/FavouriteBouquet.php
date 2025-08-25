<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteBouquet extends Model
{
    use HasFactory;
    protected $fillable=['user_id','Bouquet_id','imagePath'];
    public function bouquet(){
      return  $this->belongsTo(Bouquet::class,'bouquet_id');
    }
    public function user(){
        return  $this->belongsTo(User::class,'user_id');
    }
}
