<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Supply;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = Transaction::count();
        $transactions = Transaction::count();
        $categories = Category::count();
        $products = Product::count();
        $supplies = Supply::count();
        $getProducts = Product::all();

        if (auth()->user()->role == 'admin') {
            $transactionGet = Transaction::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        } else {
            $transactionGet = Transaction::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        }
      
        //data pembelian hari ini
        $supplierToday = Supply::whereDate('created_at', date('Y-m-d'))->get();

        //barang terlaris (semua) tapi chart dan tdk dipakai
        $totalProduct = [];
        $nameProduct = [];
        $codeProduct = [];
        $cek = Product::with('productTransactions')->get();
        foreach($cek as $c){
            $totalProduct [] = $c->productTransactions->sum('quantity');
            $nameProduct [] = $c->name;
            $codeProduct [] = $c->product_code;
        }
        $result = [
            'total' => $totalProduct,
            'product' => $nameProduct,
            'code' => $codeProduct
        ];
        if(auth()->user()->role == 'admin'){
            
            return view('admin.dashboard.index', compact('transactions','categories','products','supplies','transactionGet', 'supplierToday'));
        } else {
            return view('kasir.dashboard.index', compact('transactions','categories','products','supplies','transactionGet','result', 'supplierToday'));
        }
    }
}
