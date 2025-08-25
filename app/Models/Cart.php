<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'product_id',
        'price',
        'quantity',
        'total_price',
        'size'
    ];
    public function sessions()
    {
        return $this->hasOne(Session::class,'id','session_id');
    }
}
