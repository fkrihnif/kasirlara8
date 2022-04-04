<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $transactionGet = Transaction::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->orderBy('id', 'DESC')->get();

        return view('kasir.dashboard.index', compact('transactionGet'));
    }
}
