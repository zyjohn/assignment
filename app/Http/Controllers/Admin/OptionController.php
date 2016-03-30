<?php

namespace App\Http\Controllers\Admin;

use App\Entity;
use App\Models\M3Result;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionController extends Controller {
    /*     * ******************Service******************** */

    public function optionAdd(Request $request) {
        $product_id = $request->input('product_id', '');
        $color = $request->input('color', '');
        $size = $request->input('size', '');
        $m3_result = new M3Result;

        try {
            $option = new Entity\Option;
            $option->product_id = $product_id;
            $option->color = $color;
            $option->size = $size;
            $option->save();
            $m3_result->status = 0;
            $m3_result->message = 'Added.';
        } catch (\Exception $e) {
            $m3_result->message = $e->getMessage();
            $m3_result->status = 2;
            if (strstr($m3_result->message, '1062')) {
                $m3_result->message = 'Same option already exists for the product.';
            }
        }

        return $m3_result->toJson();
    }

    public function optionDel(Request $request) {
        $id = $request->input('id', '');
        $option = Entity\Option::find($id);

        $option->delete();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = 'Deleted.';

        return $m3_result->toJson();
    }

}
