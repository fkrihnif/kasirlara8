<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSupply;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $supplies = Supply::whereRaw(
                "(supply_date >= ? AND supply_date <= ?)", 
                [
                   $fromDate, 
                   $toDate
                ]
              )->get();
        } else {
            $supplies = Supply::orderBy('id', 'DESC')->get();
        }
        // dd($t = Supply::all());
        $products = Product::all();
        return view('admin.supply.index', compact('supplies','products'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;
        $code = '';
        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }
        if (Supply::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        try {
            $supply = Supply::create([
                'user_id' => auth()->user()->id,
                'code' => $code,
                'supplier_name' => $request->supplier_name,
                'supply_date' => $request->supply_date,
                'total' => $code
                
            ]);
            $total = [];
            for($i = 0; $i < count($request->product_id); $i++){
                $produk = Product::find($request->product_id[$i]);
                $result = $produk->quantity + $request->quantity[$i];
                $produk->update(['quantity' => $result]);
                ProductSupply::create([
                    'supply_id' => $supply->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->price[$i]
                ]);
                $total[] = $request->quantity[$i] * $request->price[$i];
            } 
            //coba tambahkan total di Supply
            $totalFinal = array_sum($total);
            $s = Supply::find($supply->id);
            $s->total = $totalFinal;
            $s->save();
            DB::commit();
            toast('Data Pasok berhasil ditambahkan')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Gagal menambah data pasok')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        }
       
    }
    public function delete(Request $request)
    {
        $supply = Supply::find($request->id);
        $supply->delete();
        toast('Data pasok berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back()->with('success','Berhasil menghapus data pasok');
    }
    public function update(Request $request)
    {
        $supply = Supply::find($request->id);
        $supply->update($request->all());
        return redirect()->back()->with('success','Berhasil mengubah data pasok');
    }
    
    public function show(Request $request)
    {
        $supply = Supply::find($request->id);
        $product_supplies = ProductSupply::where('supply_id', $supply->id)->get();
        return view('admin.supply.show', compact('supply','product_supplies'));
    }
}
