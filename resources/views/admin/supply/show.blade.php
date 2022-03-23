@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Detail Pasok</h4><hr>
          <div class="card-title">
            <a href="{{ route('admin.supply.print', $supply->id) }}" target="_blank"><i class="fas fa-print"></i></a>
            <table>
              <tr>
                <td>Kode Pasok</td>
                <td>:</td>
                <td> &nbsp; {{ $supply->code }}</td>
              </tr>
                <tr>
                    <td>Nama Pemasok</td>
                    <td>:</td>
                    <td> &nbsp; {{ $supply->supplier_name }}</td>
                </tr>
                <tr>
                    <td>Total Produk</td>
                    <td>:</td>
                    <td> &nbsp; {{ $supply->productSupply()->count() }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pasok</td>
                    <td>:</td>
                    @php
                    $date = \Carbon\Carbon::parse($supply->supply_date)->format('d-m-Y');
                    @endphp
                    <td> &nbsp; {{ $date }}</td>
                </tr>
                </table>
            </div>
        </div>
        <hr>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <th>
                  No
                </th>
                <th>
                  Nama Produk
                </th>
                <th>
                  Jumlah
                </th>
                <th>
                  Harga Satuan
                </th>
                <th>
                  Total
                </th>
              </thead>
              <tbody>
                @php
                    $total = [];
                @endphp
                  @foreach($product_supplies as $key => $product)
                  <tr>
                      <td>{{ $key+1 }}</th>
                      <td>{{ $product->product->name }}</td>
                      <td>{{ $product->quantity }}</td>
                      <td>{{ format_uang($product->price)  }}</td>
                      <td>{{ format_uang($product->quantity * $product->price) }}</td>
                  </tr>
                  @php
                      $total[] =  $product->quantity * $product->price;
                  @endphp
                  @endforeach
                  <tr>
                    @php
                        $totalFinal = array_sum($total);
                    @endphp
                    <td colspan="4" align="right"><b>Total Akhir</b></td>
                    <td>{{ format_uang($totalFinal)  }}</td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
