<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        $categories = Category::all();
        return view('admin.product.index', compact('products', 'categories'));
    }
    public function store(Request $request)
    {
        // $product = Product::count();
        // $validatedData = $request->validate([
        //     'product_code' => 'required|unique:product'
        // ]);
        // Product::create($request->all());
        // toast('Data produk berhasil ditambah')->autoClose(2000)->hideCloseButton();
        // return redirect()->back();

        $validatedData = $request->validate([
            'product_code' => 'required|unique:product'
        ]);

        $product = new Product();

        $product->product_code = $request->get('product_code');
        $product->name = $request->get('name');
        $product->quantity = $request->get('quantity');
        $product->price = $request->get('price');
        $product->price3 = $request->get('price3');
        $product->price6 = $request->get('price6');
        $product->category_id = $request->get('category_id');

        $product->save();
        toast('Data produk berhasil ditambah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }
    public function update(Request $request)
    {
        // $validatedData = $request->validate([
        //     'product_code' => 'required|unique:product,product_code,' . $request->id,
        // ]);
        // $product = Product::find($request->id);
        // $product->update($request->all());
        // toast('Data produk berhasil diubah')->autoClose(2000)->hideCloseButton();
        // return redirect()->back();

        $product = Product::find($request->id);
        $validatedData = $request->validate([
            'product_code' => 'required|unique:product,product_code,' . $request->id,
        ]);

        $product->product_code = $request->get('product_code');
        $product->name = $request->get('name');
        $product->quantity = $request->get('quantity');
        $product->price = $request->get('price');
        $product->price3 = $request->get('price3');
        $product->price6 = $request->get('price6');
        $product->category_id = $request->get('category_id');
        $product->save();

        toast('Data produk berhasil diubah')->autoClose(2000)->hideCloseButton();
        return redirect()->back();
    }

    public function print(Request $request)
    {
        $barcode = Product::find($request->id);
        $banyak = $request->get('banyak');
        return view('admin.product.print', compact('barcode', 'banyak'));
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        toast('Data produk berhasil dihapus')->autoClose(2000)->hideCloseButton();
        $product->delete();
        return redirect()->back();
    }
}
