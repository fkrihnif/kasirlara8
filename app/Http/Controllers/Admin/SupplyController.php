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
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.supply.index', compact('supplies','products'));
    }

    public function generateUniqueCode()
    {
        $characters = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 10;

        $code = '';

        while (strlen($code) < $codeLength) {
        $position = rand(0, $charactersNumber - 1);
        $character = $characters[$position];
        $code = $code.$character;
        }

        if (Supply::where('code', $code)->exists()) {
        $this->generateUniqueCode();
        }
        return $code;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        if ($request->supplier_name == null) {
            $supplier_name = '-';
        } else {
            $supplier_name = $request->supplier_name;
        }

        if ($request->supply_date == null) {
            $supply_date = date('Y-m-d');
        } else {
            $supply_date = $request->supply_date;
        }

        try {
            $supply = Supply::create([
                'user_id' => auth()->user()->id,
                'code' => $this->generateUniqueCode(),
                'supplier_name' => $supplier_name,
                'supply_date' => $supply_date,
                'total' => ''
                
            ]);
            $total = [];
            for($i = 0; $i < count($request->product_code); $i++){
                $productId = Product::where('product_code', $request->product_code[$i])->first()->id;
                $produk = Product::find($productId);
                $result = $produk->quantity + $request->quantity[$i];
                $produk->update(['quantity' => $result]);
                ProductSupply::create([
                    'supply_id' => $supply->id,
                    'product_id' => $productId,
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
            toast('Data Pembelian berhasil ditambahkan')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            toast('Gagal menambah data pembelian')->autoClose(2000)->hideCloseButton();
            return redirect()->back();
        }
       
    }
    public function delete(Request $request)
    {
        $supply = Supply::find($request->id);
        $productSupplies = ProductSupply::where('supply_id', $request->id)->pluck('id');
        
        for($i = 0; $i < count($productSupplies); $i++){
            $getQuantity = ProductSupply::where('id', $productSupplies[$i])->first()->quantity;
            $getProductId = ProductSupply::where('id', $productSupplies[$i])->first()->product_id;
            $produk = Product::find($getProductId);
            $quantity = $produk->quantity - $getQuantity;
            $produk->update(['quantity' => $quantity]);
        }
        $supply->delete();
        toast('Data pasok berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back()->with('success','Berhasil menghapus data pembelian');
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

    public function print(Request $request)
    {
        $supply = Supply::find($request->id);
        $product_supplies = ProductSupply::where('supply_id', $supply->id)->get();

        foreach($product_supplies as $key => $product) {
        $name[] = $product->product->name;
        $code[] = $product->product->product_code;
        $price[] = $product->product->price;
        $price3[] = $product->product->price3;
        $price6[] = $product->product->price6;
        $print[] = $product->quantity;
        }
        $result = [
            'name' => $name,
            'code' => $code,
            'price' => $price,
            'price3' => $price3,
            'price6' => $price6,
            'print' => $print
        ];

        $data = [];
        for ($i = 0; $i < count($name); $i++) {
        $data[] = [
            'name' => $name[$i],
            'code' => $code[$i],
            'price' => $price[$i],
            'price3' => $price3[$i],
            'price6' => $price6[$i],
            'code' => $code[$i],
            ];
        $quantity[] = [
            'qty' => (int)$print[$i],
        ];
        }
        
        for($i=0; $i<count($quantity);$i++) {
            // echo $quantity[$i]['qty'];
            for($j = 1; $j<= $quantity[$i]['qty']; $j++){
                $jumlah[] = [ 
                    'nama' => $data[$i]['name'],
                    'kode' => $data[$i]['code'],
                    'harga' => $data[$i]['price'],
                    'harga3' => $data[$i]['price3'],
                    'harga6' => $data[$i]['price6'],
                    'kuanKe' => $j,
                ];
            }
        };

        return view('admin.supply.print1', compact('supply', 'product_supplies', 'jumlah', 'quantity'));
    }
}
