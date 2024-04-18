<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search_product = $request->get('search_product');

        if($search_product){
            $products = Product::where('product_code','like',"%".$search_product."%")->orWhere('name','like',"%".$search_product."%")->paginate(10);
        } else{
            $products = Product::orderBy('id', 'DESC')->paginate(10);
        }
        $categories = Category::all();
        return view('kasir.product.index', compact('products', 'categories'));
    }
}
