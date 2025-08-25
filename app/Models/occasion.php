<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class occasion extends Model
{
    use HasFactory;
    protected $fillable=['id','name'];
    public function bouquet_occasion(){
        return $this->hasMany(bouquet_occasion::class);
    }
}
