<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionNewController extends Controller
{
    public function index()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->orderBy('id', 'DESC')->get();
        return view('admin.transaction-new.index', compact('productTransactions'));
    }
    public function indexs()
    {
        $productTransactions = ProductTransaction::where('user_id', auth()->user()->id)->where('status', '0')->with('product')->orderBy('id', 'DESC')->get() ?? [];
        return response()->json([
            'message' => 'success',
            'data' => $productTransactions
        ]);
    }
    public function update(Request $request)
    {
        $productTransaction = ProductTransaction::find($request->id);

        $productTransaction->quantity = $request->quantity;
        $productTransaction->disc_rp = $request->disc_rp;
        $productTransaction->disc_prc = $request->disc_prc;
        $productTransaction->update();

        return response()->json([
            'message' => 'success',
            'data' => $productTransaction
        ], 200);
    }

    public function show(Request $request)
    {
        $productTransaction = ProductTransaction::with('product')->find($request->id);
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $productTransaction
        ]); 
    }

    public function showLastProduct(Request $request)
    {
        $productTransaction = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->with('product')->latest()->first();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $productTransaction
        ]); 
    }

    
    public function getProductCode(Request $request)
    {
        // $product = Product::where('product_code', $request->search)->first() ?? '';
        $product = Product::where('product_code', $request->search)->first(['id', 'name', 'price']) ?? '';
        return response()->json([
            'message' => 'success',
            'data' => $product
        ]);
    }
    public function addToCart(Request $request)
    {
        $product = Product::where('product_code', $request->product_code)->first();
        //cek apakah ada barcode ini di tabel produk?
        if($product) {
            //cek apakah yg ada isi di cart pada user ini
            $checkCart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first();
            if($checkCart){
                //cek apakah barcode ini sama dgn produk terakhir di cart
                $idLastProduct = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first()->product_id;
                $lastProduct = Product::where('id', $idLastProduct)->first()->product_code;

                if ($lastProduct == $request->product_code) {
                    $idLastCart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first()->id;
                    $productTransaction = ProductTransaction::find($idLastCart);
                    $productTransaction->quantity = $productTransaction->quantity + 1;
                    $productTransaction->save();
                    $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

                    return response()->json([
                        'message' => 'success',
                        'data' => $productTransaction
                    ]);
                }else {
                    DB::beginTransaction();
                    try {
                        $productTransaction = new ProductTransaction();
                        $productTransaction->user_id = auth()->user()->id;
                        $productTransaction->product_id = $product->id;
                        $productTransaction->quantity = 1;
                        $productTransaction->disc_rp = $request->disc_rp;
                        $productTransaction->disc_prc = $request->disc_prc;
                        $productTransaction->status = '0';
                        $productTransaction->save();
                        $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

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
            } else {
                DB::beginTransaction();
                try {
                    $productTransaction = new ProductTransaction();
                    $productTransaction->user_id = auth()->user()->id;
                    $productTransaction->product_id = $product->id;
                    $productTransaction->quantity = 1;
                    $productTransaction->disc_rp = $request->disc_rp;
                    $productTransaction->disc_prc = $request->disc_prc;
                    $productTransaction->status = '0';
                    $productTransaction->save();
                    $productTransaction = ProductTransaction::where('id', $productTransaction->id)->with('product')->first();

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
        } else {
            //klaau gk ada barcode
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
    }

    public function deleteLastProduct(Request $request)
    {
        $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id)->latest()->first();
        $cart->delete();

        return response()->json([
            'message' => 'berhasil dihapus yg terahir',
            'data' => $cart
        ], 200);
    }

    public function deleteCart(Request $request)
    {
        $cart = ProductTransaction::find($request->id);
        $cart->delete();

        return response()->json([
            'message' => 'success',
            'data' => $cart
        ], 200);
    }

    public function deleteAllCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $cart = ProductTransaction::where('status', '0')->where('user_id', auth()->user()->id);
            $cart->delete();

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
            ], 500);
        }
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

        if (Transaction::where('transaction_code', $code)->exists()) {
            $this->generateUniqueCode();
        }
        return $code;
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
                $transaction->user_id = auth()->user()->id;
                $transaction->transaction_code = $this->generateUniqueCode();
                $transaction->pay = $request->payment;
                $transaction->return = $request->return;
                $transaction->totalSementara = $totalPurchase;
                $transaction->purchase_order = $totalPurchaseFinal;
                $transaction->payment_method = $request->payment_method ?? null;
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
            // return redirect()->route('admin.report.show', $transaction->id);
            $transactionId = $transaction->id;
            $transactionn = Transaction::find($transactionId);
            $productTransactions = ProductTransaction::where('transaction_id', $transactionId)->get();
            return view('admin.report.test2', compact('transactionn','productTransactions'));
        } catch (\Exception $e) {
            $var = response()->json([
                'message' => 'Gagal',
                'data' => $e
            ], 500);
        }
        return $var;
    }
}
