<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bouquet_occasion extends Model
{
    use HasFactory;
    protected $fillable=['id','bouquet_id','occasion_id'];

    public function bouquet(){
        return $this->belongsTo(Bouquet::class,'bouquet_id');
    }
    public function occasion(){
        return $this->belongsTo(occasion::class,'occasion_id');
    }
}
