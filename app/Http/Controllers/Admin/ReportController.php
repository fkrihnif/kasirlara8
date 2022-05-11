<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use App\Models\Product;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $transactions = Transaction::whereRaw(
                "(created_at >= ? AND created_at <= ?)", 
                [
                   $fromDate ." 00:00:00", 
                   $toDate ." 23:59:59"
                ]
              )->get();
        } else {
            $transactions = Transaction::orderBy('id', 'DESC')->get();
        }
        
        return view('admin.report.index', compact('transactions'));
    }
    public function show($id)
    {
        $transaction = Transaction::find($id);
        $productTransactions = ProductTransaction::where('transaction_id', $transaction->id)->get();
        return view('admin.report.show', compact('transaction','productTransactions'));
    }
    public function print($id)
    {
        $transactionn = Transaction::find($id);
        $productTransactions = ProductTransaction::where('transaction_id', $transactionn->id)->get();
        return view('admin.report.test2', compact('transactionn','productTransactions'));
    }
    public function delete(Request $request)
    {
        $transaction = Transaction::find($request->id);
        $productTransactions = ProductTransaction::where('transaction_id', $request->id)->pluck('id');
        
        for($i = 0; $i < count($productTransactions); $i++){
            $getQuantity = ProductTransaction::where('id', $productTransactions[$i])->first()->quantity;
            $getProductId = ProductTransaction::where('id', $productTransactions[$i])->first()->product_id;
            $produk = Product::find($getProductId);
            $quantity = $produk->quantity + $getQuantity;
            $produk->update(['quantity' => $quantity]);
        }
        $transaction->delete();
        toast('Laporan transaksi berhasil dihapus')->autoClose(2000)->hideCloseButton();
        return redirect()->back();

    }
}
