@extends('layouts.template')
@section('content')


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; Transaksi Penjualan Hari Ini : 
            </div>
            <div class="card-body ">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $purchaseOrder = [];
                        @endphp
                        @foreach($transactionGet as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_code }}  <a href="{{ route('kasir.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a></td>
                            <td>{{ format_uang($transaction->purchase_order)  }}</td>
                        </tr>
                        @php
                            $purchaseOrder[] = $transaction->purchase_order;
                        @endphp
                        @endforeach
                        <tr>
                            @php
                                $totalPurchase = array_sum($purchaseOrder);
                            @endphp
                            <p>Total Keseluruhan: {{ format_uang($totalPurchase)  }}</p>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
