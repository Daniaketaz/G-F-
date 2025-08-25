<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\City;
use App\Models\cover;
use App\Models\design;
use App\Models\design_typeOfFlower;
use App\Models\occasion;
use App\Models\TypeOfFlower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BouquetsController extends Controller
{
    public function index(){
        $bouquets=Bouquet::all();
        return response()->json(
            $bouquets
        );

    }

    public function cities(){
        $cities=City::all();
        return response()->json([
            'status'=>1,
            'data'=>$cities]);
    }


    public function popular(){
        $bouquets=Bouquet::query()->orderBy('numberOfSales', 'desc')
            ->get();
        return response()->json($bouquets);

    }

    public function price_desc(){
        $bouquets=Bouquet::query()->orderBy('price','desc')->get();
        return response()->json(
            $bouquets);
    }

    public function price_asc(){
        $bouquets=Bouquet::query()->orderBy('price','asc')->get();
        return response()->json($bouquets);
    }

    public function searchByName($name)
    {
        if (TypeOfFlower::query()->where('name', $name)->exists()) {
            $flower_id = DB::table('type_of_flowers')->where('name', $name)->first()->id;
            $bouquet_id = DB::table('type_of_flower__bouquets')->where('TypeOfFlower_id', $flower_id)
                ->pluck('bouquet_id');
            $data = Bouquet::query()->find($bouquet_id);
        return response()->json($data);
    }
    else{
        return response()->json(
            'no such name');
    }

    }


     public function searchById($id){
        $Bouquet=Bouquet::query()->find($id);
        if(!$Bouquet==null){
        return response()->json(
            $Bouquet);}
        else{
            return response()->json(
                'not found');
        }
     }

    public function searchByIdFlower($id){
        $flower=TypeOfFlower::query()->find($id);
        if(!$flower==null){
            return response()->json(
                $flower);}
        else{
            return response()->json(
                'not found');
        }
    }
     public function occasions($id){
        if(occasion::query()->where('id',$id)->exists()){
            if(occasion::query()->find($id)->bouquet_occasion()->exists()){
            $bouquet_ids=occasion::query()->find($id)->bouquet_occasion()->pluck('bouquet_id');
            $bouquets=Bouquet::query()->find($bouquet_ids);
                return response()->json(
                    $bouquets);}
             else{
                return response()->json('no bouquets available');}
                                            }

        else{
                return response()->json(
                    'not found'
                        );
         }
    }

    public function OccasionsGet(){
        $all=occasion::all();
        return response()->json($all);
    }

    public function design(Request $request)
    {
        Validator::make($request->all(), [
            'TypeOfFlower_ids' => ['array', 'present'],
            'numberOfFlowerss' => ['array'],
            'cover_id' => 'required'
        ]);
        if (!cover::find($request->cover_id)) {
            return response()->json([
                'message' => 'please choose a cover'
            ]);
        } else {
            if ($request->TypeOfFlower_ids) {
                $productId = DB::table('products')->insertGetId([
                    'product-type-id' => 4,
                ]);
                $design = design::query()->create([
                    'product_id'=>$productId,
                    'user_id' => auth()->user()->id,
                    'cover_id' => $request->cover_id,
                    'price' => cover::query()->find($request->cover_id)->price
                ]);


                for ($i = 0; $i < count($request->TypeOfFlower_ids); $i++) {
                    $TypeOfFlower_id[$i] = design_typeOfFlower::query()->create([
                        'design_id' => $design->id,
                        'Type_Of_Flower_id' => $request->TypeOfFlower_ids[$i],
                        'numberOfFlowers' => $request->numberOfFlowerss[$i],
                        'price' => (TypeOfFlower::query()->find($request->TypeOfFlower_ids[$i])->price)
                            * $request->numberOfFlowerss[$i],
                    ]);
                    $design->price = $design->price + $TypeOfFlower_id[$i]->price;
                }
                $design->update();

                return response()->json([
                    'message' => 'your design has been sent successfully  '
                ]);
            } else {
                return response()->json([
                    'message' => 'please choose a flower too'
                ]);
            }

        }
    }

    public function showCovers(){
        $covers=cover::all();
        return response()->json($covers);
    }

    public function showFlowers(){
        $flowers=TypeOfFlower::all();
        return response()->json($flowers);
    }





}
