<?php

namespace App\Http\Controllers;

use App\Models\JewelryCategory;
use App\Models\SilverProduct;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SilverController extends Controller
{
    public function silverViewsCounter($id): JsonResponse
    {
        SilverProduct::query()->find($id)->update(['views' => DB::raw('views + 1')]);
        return response()->json(['Message' => "view value is updated successfully",]);
    }

    public function displayNewSilver()
    {
        $displayNew = SilverProduct::query()->where('views', '<', 20)->get();
        return response()->json($displayNew);

    }

    public function seeAllSilver()
    {
        $silver = SilverProduct::all();
        if (empty($silver))
            return response()->json(['message' => " We haven't added any products yet "]);
        return response()->json($silver);
    }

    public function seeSilverRings()
    {
        $silverCategory = JewelryCategory::query()->find(1)->silver->toArray();
        if (empty($silverCategory))
            return response()->json(['message' => " We haven't added rings yet "]);
        return response()->json($silverCategory);
    }

    public function seeSilverBracelet()
    {
        $silverCategory = JewelryCategory::query()->find(2)->silver->toArray();
        if (empty($silverCategory))
            return response()->json(['message' => " We haven't added bracelets yet "]);
        return response()->json($silverCategory);
    }

    public function seeSilverEarrings()
    {
        $silverCategory = JewelryCategory::query()->find(3)->silver->toArray();
        if (empty($silverCategory))
            return response()->json(['message' => " We haven't added earrings yet "]);
        return response()->json($silverCategory);
    }

    public function seeSilverNecklace()
    {
        $silverCategory = JewelryCategory::query()->find(4)->silver->toArray();
        if (empty($silverCategory))
            return response()->json(['message' => " We haven't added necklace yet "]);
        return response()->json($silverCategory);
    }

    public function displaySilverItem($id)
    {
        $silver = SilverProduct::query()->find($id);
        $silverRate = (new RateController)->showSilverRate($id);
        return ['silver' => $silver, 'rate' => $silverRate];

    }

    public function silverCheaperThan(Request $request)
    {
        $this->updateFinalPrice();
        $price = $request->input('price');
        $category = $request->input('category');
        $silver_product = SilverProduct::query();
        $silver = $silver_product->where('jewelry-categories-id', '=', $category);
        $silver_cheaper_than = $silver->where('final_price', '<', $price)->get()->toArray();
        if (count($silver_cheaper_than) == 0)
            return response()->json(['message' => 'we don\'t have any product cheaper than: ' . $price]);
        return response()->json($silver_cheaper_than);
    }

    public function updateFinalPrice()
    {
        $silver_product = SilverProduct::all();
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $silver_price = $item[0]->xagPrice / 31.1034768;
        $roundedNumber = round($silver_price, 3);
        SilverProduct::query()->update(['final_price' => DB::raw('weight*' . $roundedNumber . '+formulation_price + accessories_price')]);
    }

    public function silverGreaterThan(Request $requset)
    {
        $this->updateFinalPrice();
        $price = $requset->input('price');
        $category = $requset->input('category');
        $silver_product = SilverProduct::query();
        $silver = $silver_product->where('jewelry-categories-id', '=', $category);
        $silver_greater_than = $silver->where('final_price', '>=', $price)->get()->toArray();
        if (count($silver_greater_than) == 0)
            return response()->json(['message' => 'we don\'t have any product more expensive than : ' . $price]);
        return response()->json($silver_greater_than);
    }

    public function silverBetween(Request $request)
    {
        $this->updateFinalPrice();
        $price1 = $request->input('price1');
        $price2 = $request->input('price2');
        $category = $request->input('category');
        $silver_product = SilverProduct::query();
        $silver = $silver_product->where('jewelry-categories-id', '=', $category);
        $silverBetween = $silver->whereBetween('final_price', [$price1, $price2])->get()->toArray();
        if (empty($silverBetween)) {
            return response()->json(['message' => 'we don\'t have any product in this price range']);
        } else
            return response()->json($silverBetween);
    }

    public function sortSilverByAsc($category)
    {
        $this->updateFinalPrice();
        $silver_product = SilverProduct::query();
        $silver = $silver_product->where('jewelry-categories-id', '=', $category);
        $order = $silver->orderBy('final_price')->get()->toArray();
        if (empty($order))
            return response()->json(['message' => ' We haven\'t added this category yet ']);
        return response()->json($order);
    }

    public function sortSilverByDes($category)
    {
        $this->updateFinalPrice();
        $silver_product = SilverProduct::query();
        $silver = $silver_product->where('jewelry-categories-id', '=', $category);
        $order = $silver->orderByDesc('final_price')->get()->toArray();
        if (empty($order))
            return response()->json(['message' => ' We haven\'t added this category yet ']);
        return response()->json($order);
    }

    /**
     * @throws \Exception
     */
    public function silverPrice()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $silver_price = $item[0]->xagPrice / 31.1034768;
        $roundedNumber = round($silver_price, 5);
        return response()->json(['silver_price' => $roundedNumber]);
    }

//not tested
    public function silverPriceChart()
    {
        try {
            $time = '12:00:00';
            $now = Carbon::now();
            $now->setTimeFromTimeString($time);
            for ($i = 0; $i < 5; $i++) {
                $date = $now->subDay();
                $silver_chart[] =
                    [
                        'date' => $date->format('Y-m-d'),
                        'silver_price' => $this->silverPriceTime($date->format('Y-m-d\TH:i:s.u\Z'))
                    ];
            }
            $silver_chart = array_reverse($silver_chart);
            return $silver_chart;
        } catch (ErrorException $e) {
            echo 'No internet connection';
        }

    }

//not tested
    public function silverPriceTime($time)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.goldapi.io/api/XAG/USD/' . $time,
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
    public function silverPriceDetails()
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price_gram = round($item[0]->xagPrice / 31.1034768, 5);
        $chgXag_gram = $item[0]->chgXag / 31.1034768;
        $gold_price_oz = round($item[0]->xagPrice, 5);
        $chgXag_oz = $item[0]->chgXag;
        $gold_price_ounce = round($item[0]->xagPrice * 1.097, 5);
        $chgXag_ounce = $item[0]->chgXag * 1.097;
        $pcXag = $item[0]->pcXag;
        return response()->json(['gold_price_gram' => $gold_price_gram, 'chgXag_gram' => $chgXag_gram, 'gold_price_oz' => $gold_price_oz,
            'chgXag_oz' => $chgXag_oz, 'gold_price_ounce' => $gold_price_ounce, 'chgXag_ounce' => $chgXag_ounce, 'pcXag' => $pcXag]);
    }
}
