<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TransactionController extends Controller
{
    public function index()
    { 
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status','0')->get();
        $products = Product::all();
        return view('kasir.transaction.index', compact('productTransactions','products'));
    }
    public function indexs()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status','0')->with('product')->get() ?? [];
        return response()->json([
            'message' => 'success',
            'data' => $productTransactions
        ]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => auth()->user()->id,
                'transaction_code' => $request->transaction_code,
                'pay' => $request->pay,
            ]);
            for($i = 0; $i < count($request->product); $i++){
                ProductTransaction::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i]
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success','Berhasil menambah transaksi');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('alert','Gagal melakukan transaksi');
        }
       
    }
    public function delete(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->delete();
        return redirect()->back()->with('success','Berhasil menghapus data transaksi');
    }
    public function update(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $transaction->update($request->all());
        return redirect()->back()->with('success','Berhasil mengubah data transaksi');
    }
    
    public function show($id)
    {
        $transaction = Transaction::find($id);
        $product_transaction = ProductTransaction::where('transaction_id', $transaction->id)->get();
        return view('kasir.transaction.show', compact('transaction','product_transaction'));
    }
    public function getProductCode(Request $request)
    {
        $product = Product::where('product_code', $request->search)->first(['id', 'name', 'price', 'price3', 'price6']) ?? '';
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
    }
    public function addToCart(Request $request)
    {
        $product = Product::where('product_code', $request->product_code)->first();
        DB::beginTransaction();
        try {
            $productTransaction = new ProductTransaction();
            $productTransaction->user_id = auth()->user()->id;
            $productTransaction->product_id = $product->id;
            $productTransaction->quantity = $request->quantity;
            $productTransaction->disc_rp = $request->disc_rp;
            $productTransaction->disc_prc = $request->disc_prc;
            $productTransaction->status = '0';
            $productTransaction->save();
            $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

            //quantity barang berkurang di table product saat addToCart 
            $lessProduct = Product::where('id', $product->id)->first();
            $quantity = Product::where('id', $product->id)->first()->quantity;
            $lessProduct->quantity = $quantity - $request->quantity;
            $lessProduct->save();

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $productTransaction
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
    }
    public function deleteCart(Request $request)
    {
        $cart = ProductTransaction::find($request->id);
        //kembalikan quantity ke product saat delete cart
        $getProduct = ProductTransaction::where('id', $request->id)->first()->product_id;
        $getQuantity = ProductTransaction::where('id', $request->id)->first()->quantity;
        $product = Product::where('id', $getProduct)->first();
        $productQty = Product::where('id', $getProduct)->first()->quantity;
        $product->quantity = $productQty + $getQuantity;
        $product->save();

        $cart->delete();
        return response()->json([
            'message' => 'success',
            'data' => $cart
        ], 200);
    }
    public function totalBuy()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->get() ?? [];
        $total = [];

        foreach ($productTransactions as $product) {
            //sesuaikan harga 1 3 6
            if ($product->quantity >= 1 && $product->quantity < 3) {
                $price = $product->product->price;
            } else if ($product->quantity >= 3 && $product->quantity <= 5) {
                $price = $product->product->price3;
            } else if ($product->quantity >= 6) {
                $price = $product->product->price6;
            }
            $total[] = $price * $product->quantity - ($product->disc_rp + ($product->disc_prc / 100) * ($price * $product->quantity));
        }
        $totalBuy = array_sum($total);
        return response()->json([
            'message' => 'success',
            'data' => $totalBuy
        ]);
    }
    public function pay(Request $request)
    {
        DB::beginTransaction();
        try {
            $productTransaction = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0');
            if (count($productTransaction->get())) {
                $purchaseOrder = [];
                foreach ($productTransaction->get() as $product) {
                    //sesuaikan harga 1 3 6
                    if ($product->quantity >= 1 && $product->quantity < 3) {
                        $price = $product->product->price;
                    } else if ($product->quantity >= 3 && $product->quantity <= 5) {
                        $price = $product->product->price3;
                    } else if ($product->quantity >= 6) {
                        $price = $product->product->price6;
                    }

                    $purchaseOrder[] = $price * $product->quantity - ($product->disc_rp + ($product->disc_prc / 100) * ($price * $product->quantity));
                }
                $totalPurchase = array_sum($purchaseOrder);
                $totalDiscPercent = ($request->get_total_disc_prc / 100) * $totalPurchase;
                $totalPurchaseFinal = $totalPurchase - $request->get_total_disc_rp - $totalDiscPercent ;

                $transaction = new Transaction;
                //utk membuat kode unik penjualan
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersNumber = strlen($characters);
                $codeLength = 6;
            
                $code = '';
            
                while (strlen($code) < 6) {
                    $position = rand(0, $charactersNumber - 1);
                    $character = $characters[$position];
                    $code = $code.$character;
                }
            
                if (Transaction::where('transaction_code', $code)->exists()) {
                    $this->generateUniqueCode();
                }
                
                $transaction->user_id = auth()->user()->id;
                $transaction->transaction_code = $code;
                $transaction->pay = $request->payment;
                $transaction->return = $request->return;
                $transaction->totalSementara = $totalPurchase;
                $transaction->purchase_order = $totalPurchaseFinal;
                $transaction->customer_name = $request->customer_name ?? null;
                $transaction->account_number = $request->account_number;
                $transaction->disc_total_rp = $request->get_total_disc_rp;
                $transaction->disc_total_prc = $request->get_total_disc_prc;
                $transaction->method = $request->method;
                $transaction->save();

                $productTransaction->update([
                    'transaction_id' => $transaction->id,
                    'status' => '1',
                ]);
                DB::commit();
            }
            toast('Pembayaran berhasil')->autoClose(2000)->hideCloseButton();
            return redirect()->route('kasir.report.show', $transaction->id);
        } catch (\Exception $e) {
            $var = response()->json([
                'message' => 'failed oii',
                'data' => $e
            ], 500);
        }
        return $var;
    }
}
