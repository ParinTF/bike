<?php

namespace App\Http\Controllers\Api;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductControllerApi extends Controller
{
    public function product_list()
    {
        $products = Product::all();
        return response()->json(array(
            'ok' => true,
            'products' => $products,
        ));
    }
}
