<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\BouquetProductRate;
use App\Models\BouquetRate;
use App\Models\GoldProductRate;
use App\Models\GoldRate;
use App\Models\SilverProductRate;
use App\Models\SilverRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function rateGold(Request $request)
    {
        $gold_id = $request->input('gold_id');
        $rate_value = $request->input('rate');
        $rate = new GoldProductRate();
        $rate->query()->create(['gold_product_id' => $gold_id, 'user_id' => Auth::user()->id, 'rate' => $rate_value]);
        $gold_rate = GoldRate::query()->where('gold_id', '=', $gold_id);
        if (empty($gold_rate->get()->toArray())) {
            GoldRate::query()->create(['gold_id' => $gold_id, 'number' => 1, 'rate' => $rate_value]);
            return response()->json(['message' => "Thank you, you are the first person to rate this product"]);
        }
        $item = $gold_rate->first();
        $number = $item['number'];
        $old_rate = $item['rate'];
        $gold_rate->update(['rate' => ($old_rate * $number + $rate_value) / ($number + 1), 'number' => $number + 1,]);
        return response()->json([
            'message' => 'the product is rated successfully',
        ]);
    }

    public function showGoldRate($gold_id)
    {
        $gold_rate = GoldRate::query()->where('gold_id', '=', $gold_id)->first();
        if (is_null($gold_rate)) {
            return  0;
        }
        return $gold_rate['rate'];
    }
    public function rateSilver(Request $request)
    {
        $silver_product_id  = $request->input('silver_id');
        $rate_value = $request->input('rate');
        $rate = new SilverProductRate();
        $rate->query()->create(['silver_product_id' => 2 , 'user_id' => Auth::user()->id, 'rate' => $rate_value]);
        $silver_rate = SilverRate::query()->where('silver_id', '=', $silver_product_id);
        if (empty($silver_rate->get()->toArray())) {
            SilverRate::query()->create(['silver_id' => $silver_product_id , 'number' => 1, 'rate' => $rate_value]);
            return response()->json(['message' => "Thank you, you are the first person to rate this product"]);
        }
        $item = $silver_rate->first();
        $number = $item['number'];
        $old_rate = $item['rate'];
        $silver_rate->update(['rate' => ($old_rate * $number + $rate_value) / ($number + 1), 'number' => $number + 1,]);
        return response()->json([
            'message' => 'the product is rated successfully',
        ]);
    }

    public function showSilverRate($silver_id)
    {
        $silver_rate = SilverRate::query()->where('silver_id', '=', $silver_id)->first();
        if (is_null($silver_rate)) {
            return 0;
        }
        return $silver_rate['rate'];
    }
public function rateBouquet(Request $request)
{
    $bouquet_id = $request->input('bouquet_id');
    $rate_value = $request->input('rate');
    $rate = new BouquetProductRate();
    $rate->query()->create(['bouquet_id' => $bouquet_id, 'user_id' => Auth::user()->id, 'rate' => $rate_value]);
    $bouquet_rate = BouquetRate::query()->where('bouquet_id', '=', $bouquet_id);
    if (empty($bouquet_rate->get()->toArray())) {
        BouquetRate::query()->create(['bouquet_id' => $bouquet_id, 'number' => 1, 'rate' => $rate_value]);
        return response()->json(['message' => "Thank you, you are the first person to rate this product"]);
    }
    $item = $bouquet_rate->first();
    $number = $item['number'];
    $old_rate = $item['rate'];
    $bouquet_rate->update(['rate' => ($old_rate * $number + $rate_value) / ($number + 1), 'number' => $number + 1,]);
    return response()->json([
        'message' => 'the product is rated successfully',
    ]);

}
    public function showBouquetRate($bouquet_id)
    { $bouquet_rate = BouquetRate::query()->where('bouquet_id', '=', $bouquet_id)->first();
        if (is_null($bouquet_rate)) {
            return 0;
        }
        return $bouquet_rate['rate'];}
}
