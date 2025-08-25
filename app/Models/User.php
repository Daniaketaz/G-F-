<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userName',
        'email',
        'phone_number',
        'password',
        'imagePath',
        'city_id' ,
        'Bank_Name',
        'Bank_Account_Number',


    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function City()
    {
        return $this->belongsTo(City::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function designs()
    {
        return $this->hasMany(design::class);
    }

    public function FavouriteBouquet()
    {
        return $this->hasMany(FavouriteBouquet::class, 'FavouriteBouquet_id');
    }

    public function FavouriteGolds()
    {
        return $this->hasMany(FavouriteGold::class, 'FavouriteGold_id');
    }

    public function FavouriteSilvers()
    {
        return $this->hasMany(FavouriteSilver::class, 'FavouriteSilver_id');
    }

    public function Wallet(){
        return $this->hasOne(Wallet::class);
    }
}
