<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
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
