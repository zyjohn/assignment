<?php

namespace App\Http\Controllers\View;

use App\Entity\Product;
use App\Entity\Cart;
use App\Entity\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller {

    //product list
    public function toProduct() {
        $products = Product::all();
        return view('products')->with('products', $products);
    }

    //product content
    public function toPdtContent(Request $request, $product_id) {

        $product = Product::find($product_id);
        $count = 0;


        $cart_items = Cart::where('user_id', 1)->get();
        foreach ($cart_items as $cart_item) {
            $count += $cart_item->quantity;
        }

        $options = Option::where('product_id', $product_id)->get();
        return view('pdt_content')
                        ->with('product', $product)
                        ->with('count', $count)
                        ->with('options', $options);
    }

}
