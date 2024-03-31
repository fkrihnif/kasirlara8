<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        if ($fromDate) {
            $transactions = Transaction::where('user_id', auth()->user()->id)->whereRaw(
                "(created_at >= ? AND created_at <= ?)", 
                [
                   $fromDate ." 00:00:00", 
                   $toDate ." 23:59:59"
                ]
              )->get();
        } else {
            $transactions = Transaction::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        }
        
        return view('kasir.report.index', compact('transactions'));
    }
    public function show($id)
    {
        $transaction = Transaction::find($id);
        $productTransactions = ProductTransaction::where('transaction_id', $transaction->id)->get();
        return view('kasir.report.show', compact('transaction','productTransactions'));
    }
    public function print($id)
    {
        $transactionn = Transaction::find($id);
        $productTransactions = ProductTransaction::where('transaction_id', $transactionn->id)->get();
        return view('kasir.report.test2', compact('transactionn','productTransactions'));
    }
}
