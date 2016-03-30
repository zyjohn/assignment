<?php

namespace App\Http\Controllers\Admin;

use App\Entity;
use App\Models\M3Result;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function toProduct() {
        $products = Entity\Product::all();

        return view('admin.product')->with('products', $products);
    }

    public function toProductAdd() {
        return view('admin.product_add');
    }

    public function toProductEdit(Request $request) {
        $id = $request->input('id', '');
        $product = Entity\Product::find($id);
        $options = Entity\Option::where('product_id', $id)->get();

        return view('admin.product_edit')->with('product', $product)->with('options', $options);
    }

    /*     * ******************Service******************** */

    public function productAdd(Request $request) {
        $name = $request->input('name', '');
        $summary = $request->input('summary', '');
        $price = $request->input('price', '');
        $preview = $request->input('preview', '');
        $content = $request->input('content', '');
        $product = new Entity\Product;

        $product->summary = $summary;
        $product->price = $price;
        $product->preview = $preview;
        $product->name = $name;
        $product->content = $content;
        $product->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = 'Added.';

        return $m3_result->toJson();
    }

    public function productReplace(Request $request) {
        $id = $request->input('id', '');
        $name = $request->input('name', '');
        $summary = $request->input('summary', '');
        $price = $request->input('price', '');
        $preview = $request->input('preview', '');
        $content = $request->input('content', '');
        $product = Entity\Product::find($id);

        $product->summary = $summary;
        $product->price = $price;
        $product->preview = $preview;
        $product->name = $name;
        $product->content = $content;
        $product->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = 'Edited.';

        return $m3_result->toJson();
    }

    public function productDel(Request $request) {
        $id = $request->input('id', '');
        $product = Entity\Product::find($id);
        $product->delete();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = 'Deleted.';

        return $m3_result->toJson();
    }

}
