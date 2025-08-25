<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteSilver extends Model
{
    use HasFactory;
    protected $fillable=['user_id','SilverProduct_id','imagePath'];

    public function user(){
        return  $this->belongsTo(User::class,'user_id');
    }
    public function silverproduct(){
        return  $this->belongsTo(SilverProduct::class,'SilverProduct_id');
    }
}
