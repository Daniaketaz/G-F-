<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\GoldProduct;
use App\Models\Product;
use App\Models\Session;
use App\Models\SilverProduct;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function purchased()
    {
        $user_id = auth('api')->user()->id;
        $date = now()->timezone('Asia/Damascus')->format('Y-m-d');
        $time = now()->timezone('Asia/Damascus')->format('H:i:s');
        $active_session = $this->getActiveSession($user_id);
        $carts = $active_session->first()->carts;
        foreach ($carts as $cart) {
            $productId = $cart->product_id;
            $product = Product::query()->find($productId);
            $productType = $product['product-type-id'];
            if ($productType == 3) {
                $product->bouquets->increment('numberOfSales');
            }

        }
        $wallet = Wallet::query()->where('user_id', $user_id)->first();
        $totalPrice = $active_session->first()['total_price'];
        $admin = User::query()->where('email', '=', 'Ownerapp@gmail.com');
       $count=$admin->count();
        if ($count!=0) {
            $adminId = $admin->first()['id'];
            if ($wallet['total'] > $totalPrice) {
                $wallet->update(['total' => DB::raw('total-' . $totalPrice)]);
                Wallet::query()->where('user_id', $adminId)->update(['total' => DB::raw('total+' . $totalPrice)]);

            } else {
                return "sorry, you can't complete the purchase process because the funds in your account are insufficient.";
            }
        }
        $active_session->update(['active' => false, 'invoice_date' => $date, 'invoice_time' => $time]);

        return response()->json(['message' => 'The purchase has been confirmed']);
    }

    public function getActiveSession($user_id)
    {
        return Session::query()->where('user_id', '=', $user_id)->where('active', '=', true);
    }

    public function notPurchased()
    {
        $user_id = Auth::user()->id;
        $session = Session::query();
        $active_session_id = $session->where('user_id', '=', $user_id)->where('active', '=', true)->first()['id'];
        $session->find($active_session_id)->delete();
        Cart::query()->where('session_id', '=', $active_session_id)->delete();
        return response('The purchase hasn\'t been confirmed');
    }

    public function deleteItem(Request $request)
    {
        $product_id = $request->input('product_id');
        $size = $request->input('size');
        $user_id = Auth::user()->id;
        $active_session = $this->getActiveSession($user_id);
        $active_session_id = $active_session->first()['id'];
        $cart_item = Cart::query()->where('session_id', '=', $active_session_id)->where('product_id', '=', $product_id)->where('size', $size);
        $price = $cart_item->first()['total_price'];
        $cart_item->delete();
        $active_session->update(['total_price' => DB::raw('total_price-' . $price)]);
        $total_price = $active_session->first()['total_price'];
        if ($total_price == 0)
            Session::query()->where('id', '=', $active_session_id)->delete();
        return response()->json(['message' => 'product has been deleted successfully']);
    }

    public function invoice()
    {
        $user_id = Auth::user()->id;
        $active_session = $this->getActiveSession($user_id)->first();
        $carts = $active_session->carts;
        $session_id = $active_session['id'];
        $total = $active_session['total_price'];
        foreach ($carts as $item) {
            $product_id = $item['product_id'];
            $product = Product::query()->find($product_id);
            $product_type = $product['product-type-id'];
            $id = null;
            $name = null;
            $photo = null;
            $description = null;
            if ($product_type == 1) {
                $id = $product->gold->id;
                $name = $product->gold->name;
                $photo = $product->gold->photo;
                $description = $product->gold->description;
            } elseif ($product_type == 2) {
                $id = $product->silvers->id;
                $name = $product->silvers->name;
                $photo = $product->silvers->photo;
                $description = $product->silvers->description;
            } elseif ($product_type == 3) {
                $id = $product->bouquets->id;
                $photo = $product->bouquets->imagePath;
                $description = $product->bouquets->description;
            } elseif ($product_type == 4) {
                $id = $product->designs->id;
                $name = 'design';
                //add default photo
                // $photo = $product->designs->photo;
            }
            $items[] = ['product_type' => $product_type, 'item_id' => $id, 'name' => $name, 'photo' => $photo, 'description' => $description, 'price' => $item['price'], 'quantity' => $item['quantity'], 'total_price' => $item['total_price']];
        }
        $date = now()->timezone('Asia/Damascus')->format('d/m/Y');
        $time = now()->timezone('Asia/Damascus')->format('g:i:s  a');
        return response()->json(['invoice_no' => $session_id, 'invoice_date' => $date, 'invoice_time' => $time, 'items' => $items, 'total_price' => $total]);
    }

    public function displayCart()
    {
        $user_id = Auth::user()->id;
        $active_session = $this->getActiveSession($user_id)->first();
        if (is_null($active_session)) {
            return ' you haven\'t added any products to the cart yet. ';
        }
        return $this->displayCartItems($active_session);
    }

    public function displayCartItems($active_session)
    {
        $carts = $active_session->carts;
        $items = [];
        foreach ($carts as $item) {
            $product_id = $item['product_id'];
            $productSize = $item['size'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $total_price = $item['total_price'];
            $product = Product::query()->find($product_id);
            $product_type = $product['product-type-id'];
            $id = null;
            $name = null;
            $photo = null;
            $description = null;
            if ($product_type == 1) {
                $id = $product->gold->id;
                $name = $product->gold->name;
                $photo = $product->gold->photo;
                $description = $product->gold->description;
            } elseif ($product_type == 2) {
                $id = $product->silvers->id;
                $name = $product->silvers->name;
                $photo = $product->silvers->photo;
                $description = $product->silvers->description;
            } elseif ($product_type == 3) {
                $id = $product->bouquets->id;
                $photo = $product->bouquets->imagePath;
                $description = $product->bouquets->description;
            } elseif ($product_type == 4) {
                $id = $product->designs->id;
                $name = 'design';
                //add default photo
                // $photo = $product->designs->photo;
            }
            $items[] = ['product_type' => $product_type, 'item_id' => $id, 'name' => $name, 'size' => $productSize, 'photo' => $photo,
                'description' => $description, 'price' => $item['price'], 'quantity' => $quantity, 'total_price' =>
                    $total_price];
        }
        return $items;


    }

    public function addAllQuantity(Request $request)
    {
        $quantities = $request->input('quantities');
        $user_id = Auth::user()->id;
        $active_session = Session::query()->where('user_id', $user_id)->where('active', '=', true)->first();
        $active_session_id = $active_session->id;
        foreach ($quantities as $quantity) {
            $product_id = $quantity['product_id'];
            $quantity_value = $quantity['quantity'];
            $size = $quantity['size'];
            $cart = Cart::query()->where('session_id', $active_session_id)->where('product_id', $product_id)->where('size', $size)->first();
            $price = $cart['price'];
            $active_session->update(['total_price' => DB::raw('total_price+' . $quantity_value . '*' . $price . '-' . $price)]);
            $cart->update(['quantity' => $quantity_value, 'total_price' => DB::raw('price*' . $quantity_value)]);
        }
        return response()->json(['message' => 'quantities have been added successfully']);
    }

    public function orderHistory()
    {
        $user_id = Auth::user()->id;
        $sessions = Session::query()->where('user_id', '=', $user_id)->where('active', '=', false)->get();
        if ($sessions->isNotEmpty()) {
            foreach ($sessions as $session) {
                $count = $session->carts->count();
                $id = $session->id;
                $order_date = $session->invoice_date;
                $order_time = $session->invoice_time;
                if ($session->order_status != 'canceled' && $session->order_status != 'retrieved') {
                    $this->compareTime($order_date, $order_time, $session);
                }
                $items[] = ['order_date' => $order_date, 'order_time' => $order_time, 'order_number' => $id, 'order_items' => $count, 'order_status' => $session->order_status];
            }
            return response()->json(['items_number' => count($items), 'items' => $items]);
        } else {
            return ' you haven\'t confirmed any purchase before. ';
        }
    }

    public function compareTime($order_date, $order_time, $session)
    {
        $carbonSpecificDateTime = Carbon::parse($order_date . ' ' . $order_time);
        $timeAfterThreeHours = $carbonSpecificDateTime->addHours(3);
        $currentDateTime = Carbon::parse(now()->timezone('Asia/Damascus')->format('Y-m-d H:i:s'));
        if ($currentDateTime->isAfter($timeAfterThreeHours)) {
            $session->update(['order_status' => 'confirmed']);
        } elseif ($timeAfterThreeHours->isAfter($currentDateTime)) {
            $session->update(['order_status' => 'in progress']);
        } elseif ($currentDateTime->eq($timeAfterThreeHours)) {
            $session->update(['order_status' => 'confirmed']);
        }
    }

    public function cancelOrder(Request $request)
    {$user_id = Auth::user()->id;
        $orderNumber = $request->input('orderNumber');
        $sessionNumber = Session::query()->find($orderNumber);
        $orderDate = $sessionNumber->invoice_date;
        $orderTime = $sessionNumber->invoice_time;
        $this->compareTime($orderDate, $orderTime, $sessionNumber);
        if ($sessionNumber->order_status == 'confirmed') {
            return "Sorry, you can't cancel the order after three hours of confirmation.";
        } elseif ($sessionNumber->order_status == 'in progress') {
            $sessionNumber->update(['order_status' => 'canceled']);
            $totalPrice =  $sessionNumber->total_price;
            $admin = User::query()->where('email', '=', 'Ownerapp@gmail.com');
            $count=$admin->count();
            if ($count!=0) {
                $adminId = $admin->first()['id'];

                    Wallet::query()->where('user_id', $adminId)->update(['total' => DB::raw('total-' . $totalPrice)]);

                }
            return "your order  has been canceled";
        }
    }

    public function showOrderDetails(Request $request)
    {
        $orderNumber = $request->input('orderNumber');
        $session = Session::query()->find($orderNumber);
        $carts = $session->carts;

        return $this->displayCartItems($session);
    }

    public function retrieveOrder(Request $request)
    {
        $orderNumber = $request->input('orderNumber');
        $session = Session::query()->find($orderNumber);
        $sessionStatus = $session->order_status;
        if ($sessionStatus == 'canceled') {
            $carts = $session->carts;
            $request1 = new Request();
            foreach ($carts as $cart) {
                $productId = $cart->product_id;
                $quantity = $cart->quantity;
                $size = $cart->size;
                $request1->merge(['product_id' => $productId, 'size' => $size, 'quantity' => $quantity]);
                $this->addToCart($request1);
                $session->update(['order_status' => 'retrieved']);
            }
            return 'product is retrieved successfully';
        } else
            return "This product is already in the cart.";

    }

    public function addToCart(Request $request)
    {
      //  try {
            $product_id = $request->input('product_id');
            $size = $request->input('size');
            $quantity = $request->input('quantity');
            $user_id = auth('api')->user()->id;
            $product = Product::query()->find($product_id);
            $product_type = $product['product-type-id'];
            $price = 0;
            if ($product_type == 1) {
                $id = $product->gold['id'];
                $price = $this->getGoldPrice($id, $size);
            } elseif ($product_type == 2) {
                $id = $product->silvers['id'];
                $price = $this->getSilverPrice($id, $size);
            } elseif ($product_type == 3) {
                $id = $product->bouquets['id'];
                $price = $product->bouquets['price'];
            } elseif ($product_type == 4) {
                $id = $product->designs['id'];
                $price = $product->designs['price'];
            }
            $active_session = $this->getActiveSession($user_id)->first();
            $session_count = User::query()->find($user_id)->sessions->count();
            if (($session_count == 0) || (is_null($active_session))) {
                Session::query()->create(['user_id' => $user_id, 'total_price' => 0, 'active' => true]);
            }
            $active_session_id = $this->getActiveSession($user_id)->first()['id'];

            $cart_count = Cart::query()->where('session_id', '=', $active_session_id)->where('product_id', '=', $product_id)
                ->where('size', '=', $size)->count();
            if ($cart_count == 0) {
                $session = Session::query()->find($active_session_id);
                $session['total_price'] += $price * $quantity;
                $session->save();
                Cart::query()->create(['session_id' => $active_session_id, 'product_id' => $product_id, 'price' => $price, 'size' => $size, 'quantity' => $quantity, 'total_price' => $price * $quantity,]);
                return response()->json(['message' => 'product has been added successfully']);
            } else return response()->json(['message' => 'product has been added recently']);
//        } catch (Exception $e) {
//            return 'No internet connection available.';
//        }
    }

    public function getGoldPrice($id, $size)
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $gold_price = $item[0]->xauPrice / 31.1034768;
        $gold = GoldProduct::query()->find($id);
        $weight = ($gold['weight'] + $gold['weight_difference'] * (2 * $size - 6));
        $finalPrice = $weight * $gold_price + $gold['formulation_price'] + $gold['accessories_price'];
        return round($finalPrice, 5);
    }

    public function getSilverPrice($id, $size)
    {
        $json = file_get_contents('https://data-asg.goldprice.org/dbXRates/USD');
        $decoded = json_decode($json);
        $item = $decoded->items;
        $silver_price = $item[0]->xagPrice / 31.1034768;
        $silver = SilverProduct::query()->find($id);
        $weight = ($silver['weight'] + $silver['weight_difference'] * (2 * $size - 6));
        $finalPrice = $weight * $silver_price + $silver['formulation_price'] + $silver['accessories_price'];
        return round($finalPrice, 5);

    }


}

