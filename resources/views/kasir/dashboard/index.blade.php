@extends('layouts.template')
@section('content')


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; Transaksi Penjualan Hari Ini : 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <th>Kode Transaksi</th>
                            <th>Waktu</th>
                            <th>Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $purchaseOrder = [];
                        @endphp
                        @foreach($transactionGet as $key => $transaction)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->transaction_code }}  <a href="{{ route('kasir.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a></td>
                            <td>{{ date('d M Y H:i:s', strtotime($transaction->created_at)) }}</td>
                            <td>@currency($transaction->purchase_order)</td>
                        </tr>
                        @php
                            $purchaseOrder[] = $transaction->purchase_order;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
                @php
                $totalPurchase = array_sum($purchaseOrder);
                 @endphp
            <b>Total Penjualan Hari ini: @currency($totalPurchase)</b>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
