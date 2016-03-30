<?php

namespace App\Http\Controllers\View;

use App\Entity\Cart;
use App\Entity\Option;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller {

    public function toCart(Request $request) {
        //assuming user with id 1 logged in
        $user_id = 1;
        $cart_items = Cart::where('user_id', $user_id)->get();

        foreach ($cart_items as $index => $cart_item) {
            //remove the empty cart item
            if ($cart_item->quantity <= 0) {
                $cart_item->delete();
                unset($cart_items[$index]);
            } else {
                $product = Product::find($cart_item->product_id);
                $option = Option::find($cart_item->option_id);
                $cart_items[$index]->product = $product;
                $cart_items[$index]->option = $option;
            }
        }

        return view('cart')->with('cart_items', $cart_items);
    }

}
