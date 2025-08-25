<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfFlower extends Model
{
    use HasFactory;
    protected $fillable=['id','name','price','description','imagePath'];

    public function TypeOfFlower_Bouquet(){
        return $this->hasMany(TypeOfFlower_Bouquet::class);
    }

    public function dtof(){
        return $this->hasMany(design_typeOfFlower::class);
    }
}
