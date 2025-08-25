<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JewelryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'jewelry category'];

    public function gold()
    {
        return $this->hasMany(GoldProduct::class, 'jewelry-categories-id', 'id');
    }

    public function silver()
    {
        return $this->hasMany(SilverProduct::class, 'jewelry-categories-id', 'id');
    }
}
