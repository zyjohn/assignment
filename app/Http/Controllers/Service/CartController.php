<?php

namespace App\Http\Controllers\Service;

use App\Entity\Cart;
use App\Entity\Option;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Events\CartPurchasedEvent;
use Event;
use Illuminate\Http\Request;

class CartController extends Controller {

    public function addCart(Request $request, $option_id) {
        //assume user login as user_id 1
        $user_id = 1;
        $cart_items = Cart::where('user_id', $user_id)->get();

        $exist = false;
        foreach ($cart_items as $cart_item) {
            if ($cart_item->option_id == $option_id) {
                $cart_item->quantity++;
                $cart_item->save();
                $exist = true;
                break;
            }
        }

        if ($exist == false) {
            $cart_item = new Cart;
            $option = Option::find($option_id);
            $cart_item->option_id = $option_id;
            $cart_item->product_id = $option->product_id;
            $cart_item->quantity = 1;
            $cart_item->user_id = $user_id;
            $cart_item->save();
        }

        $m3_result = new M3Result();
        $m3_result->status = 0;
        $m3_result->message = 'Added to cart';

        return $m3_result->toJson();
    }

    public function lessCart(Request $request, $id) {
        //assume user login as user_id 1
        $user_id = 1;
        $m3_result = new M3Result();
        $cart_item = Cart::find($id);

        if ($cart_item == false || $cart_item->quantity <= 0) {
            $m3_result->status = 1;
            $m3_result->message = 'Already removed from cart.';
        }

        $cart_item->quantity--;
        $cart_item->save();

        $m3_result->status = 0;
        $m3_result->message = 'Subtracted from cart.';

        return $m3_result->toJson();
    }

    public function payCart(Request $request) {
        //assume user login as user_id 1
        $user_id = 1;
        $m3_result = new M3Result();
        $cart_items = Cart::where('user_id', $user_id)->get();

        if (count($cart_items) == 0) {
            $m3_result->status = 1;
            $m3_result->message = 'Cart is empty.';
            return $m3_result->toJson();
        }

        $title = "user: $user_id purchases";
        $message = json_encode($cart_items);

        Event::fire(new CartPurchasedEvent($title, $message));

        foreach ($cart_items as $item) {
            $item->delete();
        }

        $m3_result->status = 0;
        $m3_result->message = 'Subtracted from cart.';

        return $m3_result->toJson();
    }

}
