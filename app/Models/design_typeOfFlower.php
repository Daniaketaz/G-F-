<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class design_typeOfFlower extends Model
{
    use HasFactory;
    protected $fillable=['id','Type_Of_Flower_id','design_id','numberOfFlowers','price'];

    public function design(){
        return $this->belongsTo(design::class,'design_id');
    }
    public function TypOfFlowe(){
        return $this->belongsTo(TypeOfFlower::class,'TypeOfFlower_id');
    }
}
