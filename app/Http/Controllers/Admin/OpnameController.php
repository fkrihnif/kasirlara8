<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Opname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpnameController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $opnames = Opname::whereRaw(
                "(created_at >= ? AND created_at <= ?)", 
                [
                   $fromDate ." 00:00:00", 
                   $toDate ." 23:59:59"
                ]
              )->orderBy('id', 'DESC')->get();
        } else {
            $opnames = Opname::orderBy('id', 'DESC')->get();
        }
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.opname.index', compact('opnames', 'products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            for($i = 0; $i < count($request->product_code); $i++){
                $productId = Product::where('product_code', $request->product_code[$i])->first()->id;
                $produk = Product::find($productId);
                $oldQuantity = $produk->quantity;
                $result = $request->quantity[$i];
                $produk->update(['quantity' => $result]);

                Opname::create([
                    'product_id' => $productId,
                    'quantity' => $request->quantity[$i] - $oldQuantity,
                    
                ]);
            } 
            DB::commit();
            toast('Data Opname berhasil ditambahkan')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Gagal menambah data opname')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        }
       
    }

    public function delete(Request $request)
    {
        $opname = Opname::find($request->id);
        
        $getProductId = Product::where('id', $opname->product_id)->first()->id;
        $getQuantity = $opname->quantity;
        $produk = Product::find($getProductId);
        $quantity = $produk->quantity - $getQuantity;
        $produk->update(['quantity' => $quantity]);
        
        $opname->delete();
        toast('Data pasok berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back()->with('success','Berhasil menghapus data pembelian');
    }
}
