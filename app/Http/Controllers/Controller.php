<?php

namespace App\Http\Controllers;


use App\Models\Bouquet;
use App\Models\FavouriteBouquet;
use App\Models\FavouriteGold;
use App\Models\FavouriteSilver;
use App\Models\GoldProduct;
use App\Models\SilverProduct;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @throws \Exception
     */
    public function register()
    {
        $user = new User($this->validationUser());
        $user->password = Hash::make(request('password'));

        if (request('city_name')) {
            $name = request('city_name');

            if (!DB::table('cities')->where('city_name', $name)->exists()) {
                return response()->json([
                    'message' => 'invalid name city'
                ]);
            } else {

                $user->city_id = DB::table('cities')->where('city_name', $name)->first()->id;
            }

        }

        $user->save();

        if (request('image')) {
            $image_path = $user->id . '.' . request('image')->extension();
            request('image')->move(public_path('images', $image_path));
            $user->imagePath = $image_path;
        }

        $user->update();
        $token = $user->createToken('auth_token')->accessToken;
        $userId=$user->id;
        Wallet::query()->create(['total'=> mt_rand(1,1000000000),'user_id'=>$userId]);
        return response()->json([
            'status' => 1,
            'data' => $user,
            'message' => 'Registered successfully',
            'token' => $token
        ]);



    }

    public function login()
    {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Credentials'
            ]);
        }
        $token = auth()->user()->createToken('auth_token')->accessToken;
        return response()->json([
            'status' => 1,
            'message' => 'User Logged In Successfully',
            'access_token' => $token
        ]);

    }

    public function logout()
    {
        $user = request()->user();
        $token = $user->token();
        $token->revoke();

        return response()->json([
            'status' => 1,
            'message' => 'User Logged Out Successfully']);

    }

    public function update(Request $request)
    {
        $user = auth()->user();
        if (request('userName')) {
            $request->validate([
                'userName'=>['required', 'string', 'max:30'],
            ]);
            $user->userName = request('userName');
        }
        if (request('phone_number')) {
            $request->validate([
                'phone_number' => ['required', 'string', 'max:13', 'unique:users'],
            ]);
            $user->phone_number = request('phone_number');
        }

        if (request('new_password')) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return response()->json(['message' => 'Old Password Doesnt match']);
            }
            $user->password = Hash::make($request->new_password);
                        }

                $user->update();
                return response()->json(['message'=>'updated successfully']);
    }


    public function delete()
    {
        $user=auth()->user()->delete();
        return response()->json([
            'status'=>1,
            'message'=>' account has been deleted successfully'
        ]);
    }

    public function FavoriteBouquets($id)
    {

        if (Bouquet::query()->where('id', $id)->exists()) {
            if (
            !FavouriteBouquet::query()->where('user_id', auth()->user()->id)
                ->where('Bouquet_id', $id)->exists()
            ) {
                FavouriteBouquet::query()->create([
                    'user_id' => auth()->user()->id,
                    'Bouquet_id' => $id
                ]);
                return response()->json([
                    'message' => 'added successfully',
                ]);
            } else {
                return response()->json(['message' => ' added already']);
            }
        } else {
            return response()->json([
                'message' => 'not exist , please choose another one'
            ]);
        }
    }

    public function ShowFavoriteBouquets()
    {
        $bouquets = FavouriteBouquet::all();
        return response()->json($bouquets
        );
    }

    public function FavoriteGold($id)
    {
        if (GoldProduct::query()->where('id', $id)->exists()) {
            if (
            !FavouriteGold::query()->where('user_id', auth()->user()->id)
                ->where('GoldProduct_id', $id)->exists()
            ) {
                FavouriteGold::query()->create([
                    'user_id' => auth()->user()->id,
                    'GoldProduct_id' => $id
                ]);
                return response()->json([
                    'message' => 'added successfully',
                ]);
            } else {
                return response()->json(['message' => ' added already']);
            }
        } else {
            return response()->json([
                'message' => 'not exist , please choose another one'
            ]);
        }
    }

    public function ShowFavoriteGold()
    {
        $Gold = FavouriteGold::all();
        return response()->json($Gold
        );
    }

    public function FavoriteSilver($id)
    {
        if (SilverProduct::query()->where('id', $id)->exists()) {
            if (
            !FavouriteSilver::query()->where('user_id', auth()->user()->id)
                ->where('SilverProduct_id', $id)->exists()
            ) {
                FavouriteSilver::query()->create([
                    'user_id' => auth()->user()->id,
                    'SilverProduct_id' => $id
                ]);
                return response()->json([
                    'message' => 'added successfully',
                ]);
            } else {
                return response()->json(['message' => ' added already']);
            }
        } else {
            return response()->json([
                'message' => 'not exist , please choose another one'
            ]);
        }
    }

    public function ShowFavoriteSilver()
    {
        $silver = FavouriteSilver::all();
        return response()->json($silver);
    }

    public function validationUser()
    {
        return request()->validate([
            'userName' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'city_name' => ['string']
        ]);

    }
    public function helloName()
    {
        $name = auth('api')->user()->userName;
        $photo = auth('api')->user()->imagePath;
        return [$name, $photo];

    }
}

