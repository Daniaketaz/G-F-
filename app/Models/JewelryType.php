<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewelryType extends Model
{
    use HasFactory;
    protected $fillable = [
        'jewelry type'
    ];
}
