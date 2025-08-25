<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfFlower_Bouquet extends Model
{
    use HasFactory;
    protected $fillable=['id','Bouquet_id','TypeOfFlower_id','numOfFlower'];

    public function bouquet(){
        return $this->belongsTo(Bouquet::class,'Bouquet_id' );
    }
    public function TypeOfFlower(){
        return $this->belongsTo(TypeOfFlower::class, ' TypeOfFlower_id');
    }
}
