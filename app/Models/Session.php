<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'active',
        'order_status',
        'invoice_time',
        'invoice_date'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class, 'session_id', 'id');
    }
}
