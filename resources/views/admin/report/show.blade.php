@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="container-fluid">
            <div class="row justify-content-between d-flex d-inline">
              <h4 class="card-title"> Detail Transaksi</h4><hr>
              <a href="{{ route('admin.report.print', $transaction->id) }}" target="_blank" class="btn btn-primary">Cetak Nota</a>
            </div>
            <div class="row justify-content-between d-flex d-inline">
              <a href="{{ route('admin.report.index') }}"><i class="fas fa-arrow-left"> Kembali</i></a>
            </div>
          </div>
        <hr>
          <div class="row justify-content-between d-inline d-flex">
              <div class="col-6">
                <table>
                  <tr>
                    <td>Kode Transaksi</td>
                    <td> : </td>
                    <td> {{ $transaction->transaction_code }}</td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td> : </td>
                    <td> {{ date('d M Y H:i:s', strtotime($transaction->created_at)) }}</td>
                  </tr>
                  <tr>
                    <td>Kasir</td>
                    <td> : </td>
                    <td> {{ $transaction->user->name }}</td>
                  </tr>
                </table>
              </div>
              <div class="col-6-offset-0">
                <div class="container-fluid">
                  <table>
                    <tr>
                      <td> {{ $transaction->method}}</td>
                    </tr>
                    <tr>
                      <td>Pembayaran</td>
                      <td> : </td>
                      <td>@if ($transaction->customer_name != null or $transaction->account_number != null)
                          {{ $transaction->payment_method }}
                          @else
                          Tunai
                        @endif
                      </td>
                    </tr>
                    <tr>
                      @if ($transaction->customer_name != null or $transaction->account_number != null)
                        <td>Bank/Nama - No Rek</td>
                        <td> : </td>
                        <td>{{ $transaction->customer_name ?? '' }} 
                         - {{ $transaction->account_number ?? '' }}
                        </td>
                      @endif
                    </tr>
                  </table>
                </div>
              </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <th>
                No
              </th>
              <th>
                Nama Produk - Kode
              </th>
              <th>
                Jumlah
              </th>
              <th>
                Harga
              </th>
              <th>
                Discount
              </th>
              <th>
                Total
              </th>
            </thead>
            <tbody>
                @foreach($productTransactions as $key => $product)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $product->product->name }} - {{ $product->product->product_code }}</td>
                  <td>{{ $product->quantity }}</td>
                  @php
                      if ($product->quantity >= 1 && $product->quantity<=2) {
                        $price = $product->product->price;
                      } elseif ($product->quantity >= 3 && $product->quantity<=5) {
                        $price = $product->product->price3;
                      } elseif ($product->quantity >= 6) {
                        $price = $product->product->price6;
                      }
                  @endphp
                  <td>@currency($price)</td>
                  @php
                      $discountItem = $product->disc_rp + (($product->disc_prc/100) * ($price * $product->quantity));
                  @endphp
                  <td>@currency($discountItem)</td>
                  <td>@currency(($price * $product->quantity)- $discountItem)</td>
              </tr>
                @endforeach
                <tr>
                  <td colspan="5" align="right"><b>Total</b></td>
                  <td>@currency($transaction->totalSementara)</td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><b>Discount</b></td>
                  @php
                      $discPercent = ($transaction->disc_total_prc / 100) * $transaction->totalSementara;
                      $discount = $discPercent + $transaction->disc_total_rp;
                  @endphp
                  <td>@currency($discount)</td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><b>Total Pembelian akhir</b></td>
                  <td>@currency($transaction->purchase_order)</td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><b>Bayar</b></td>
                  <td>@currency($transaction->pay)</td>
                </tr>
                <tr>
                  <td colspan="5" align="right"><b>Kembalian</b></td>
                  <td>@currency($transaction->return)</td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
