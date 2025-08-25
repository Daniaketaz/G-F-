<?php

namespace App\Http\Controllers;

use App\Models\GoldProduct;
use App\Models\JewelryCategory;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoldController extends Controller
{
    public function goldViewsCounter($id): JsonResponse
    {
        GoldProduct::query()->find($id)->update(['views' => DB::raw('views+1')]);
        return response()->json(['Message' => "view value is updated successfully"]);
    }

    public function displayNewGold()
    {
        $displayNew = GoldProduct::query()->where('views', '<', 50)->get();
        return response()->json($displayNew);

    }

    public function seeAllGold()
    {
        $gold = GoldProduct::all();
        if (empty($gold))
            return response()->json(['message' => " We haven't added any products yet "]);
        return response()->json($gold);
    }

    public function seeGoldenRings()
    {
        $goldCategory = JewelryCategory::query()->find(1)->gold->toArray();
        if (empty($goldCategory))
            return response()->json(['message' => " We haven't added rings yet "]);
        return response()->json($goldCategory);
    }

    public function seeGoldenBracelet()
    {
        $goldCategory = JewelryCategory::query()->find(2)->gold->toArray();
        if (empty($goldCategory))
            return response()->json(['message' => " We haven't added bracelets yet "]);
        return response()->json($goldCategory);
    }

    public function seeGoldenEarrings()
    {
        $goldCategory = JewelryCategory::query()->find(3)->gold->toArray();
        if (empty($goldCategory))
            return response()->json(['message' => " We haven't added earrings yet "]);
        return response()->json($goldCategory);
    }

    public function seeGoldenNecklace()
    {
        $goldCategory = JewelryCategory::query()->find(4)->gold->toArray();
        if (empty($goldCategory))
            return response()->json(['message' => " We haven't added necklace yet "]);
        return response()->json($goldCategory);
    }

    public function displayGoldItem($id)
    {
        $gold = GoldProduct::query()->find($id);
        $goldRate = (new RateController)->showGoldRate($id);
        return ['gold' => $gold, 'rate' => $goldRate];

    }

    public function goldCheaperThan(Request $request)
    {
        $this->updateFinalPrice();
        $price = $request->input('price');
        $category = $request->input('category');
        $gold_product = GoldProduct::query();
        $gold = $gold_product->where('jewelry-categories-id', '=', $category);
        $gold_cheaper_than = $gold->where('final_price', '<', $price)->get()->toArray();
        if (count($gold_cheaper_than) == 0)
            return response()->json(['message' => 'we don\'t have any product cheaper than: ' . $price]);
        return response()->json($gold_cheaper_than);
    }

    public function updateFinalPrice()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price = $item[0]->xauPrice / 31.1034768;
        $roundedNumber = round($gold_price, 3);
        GoldProduct::query()->update(['final_price' => DB::raw('weight*' . $roundedNumber . '+formulation_price + accessories_price')]);

    }

    public function goldGreaterThan(Request $requset)
    {
        $this->updateFinalPrice();
        $price = $requset->input('price');
        $category = $requset->input('category');
        $gold_product = GoldProduct::query();
        $gold = $gold_product->where('jewelry-categories-id', '=', $category);
        $gold_greater_than = $gold->where('final_price', '>=', $price)->get()->toArray();
        if (count($gold_greater_than) == 0)
            return response()->json(['message' => 'we don\'t have any product more expensive than : ' . $price]);
        return response()->json($gold_greater_than);
    }

    public function goldBetween(Request $request)
    {
        $this->updateFinalPrice();
        $price1 = $request->input('price1');
        $price2 = $request->input('price2');
        $category = $request->input('category');
        $gold_product = GoldProduct::query();
        $gold = $gold_product->where('jewelry-categories-id', '=', $category);
        $goldBetween = $gold->whereBetween('final_price', [$price1, $price2])->get()->toArray();
        if (empty($goldBetween)) {
            return response()->json(['message' => 'we don\'t have any product in this price range']);
        } else
            return response()->json($goldBetween);
    }

    public function sortGoldByAsc($category)
    {
        $this->updateFinalPrice();
        $gold_product = GoldProduct::query();
        $gold = $gold_product->where('jewelry-categories-id', '=', $category);
        $order = $gold->orderBy('final_price')->get()->toArray();
        if (empty($order))
            return response()->json(['message' => ' We haven\'t added this category yet ']);
        return response()->json($order);
    }

    public function sortGoldByDes($category)
    {
        $this->updateFinalPrice();
        $gold_product = GoldProduct::query();
        $gold = $gold_product->where('jewelry-categories-id', '=', $category);
        $order = $gold->orderByDesc('final_price')->get()->toArray();
        if (empty($order))
            return response()->json(['message' => ' We haven\'t added this category yet ']);
        return response()->json($order);
    }

    /**
     * @throws \Exception
     */
    public function goldPrice()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price = $item[0]->xauPrice / 31.1034768;
        $roundedNumber = round($gold_price, 5);
        return response()->json(['gold_price' => $roundedNumber]);
    }

    public function goldPriceChart()
    {
        try {
            $time = '12:00:00';
            $now = Carbon::now();
            $now->setTimeFromTimeString($time);
            for ($i = 0; $i < 5; $i++) {
                $date = $now->subDay();
                $gold_chart[] =
                    [
                        'date' => $date->format('Y-m-d'),
                        'gold_price' => $this->goldPriceTime($date->format('Y-m-d\TH:i:s.u\Z'))
                    ];
            }
            $gold_chart = array_reverse($gold_chart);
            return $gold_chart;
        } catch (ErrorException $e) {
            echo 'No internet connection';
        }

    }

    public function goldPriceTime($time)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.goldapi.io/api/XAU/USD/' . $time,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-access-token: goldapi-96bfrliiu0nn8-io',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        return $data->price_gram_24k;
    }

    public function goldPriceDetails()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price_gram = round($item[0]->xauPrice / 31.1034768, 5);
        $chgXau_gram = $item[0]->chgXau / 31.1034768;
        $gold_price_oz = round($item[0]->xauPrice, 5);
        $chgXau_oz = $item[0]->chgXau;
        $gold_price_ounce = round($item[0]->xauPrice * 1.097, 5);
        $chgXau_ounce = $item[0]->chgXau * 1.097;
        $pcXau = $item[0]->pcXau;
        return response()->json(['gold_price_gram' => $gold_price_gram, 'chgXau_gram' => $chgXau_gram, 'gold_price_oz' => $gold_price_oz,
            'chgXau_oz' => $chgXau_oz, 'gold_price_ounce' => $gold_price_ounce, 'chgXau_ounce' => $chgXau_ounce, 'pcXau' => $pcXau]);
    }


}
