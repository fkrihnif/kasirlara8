<style>
  td{
    padding-right: 100px;
  }
  p{
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    font-size: 23px;
  }

</style>
<table>
  <tr>
    <td><p>{{ App\Models\Company::take(1)->first()->name }}</p></td>
  </tr>
  <tr>
    <td><p>{{ App\Models\Company::take(1)->first()->address }}</p></td>
  </tr>
  <tr>
    <td><p>Kasir : {{ $transaction->user->name }}</p></td>
  </tr>
  <tr>
    <td><p>Tanggal : {{ date('m-d-Y', strtotime($transaction->created_at)) }}</p></td>
  </tr>
</table>
{{-- <p style="font-size: 25px">{{ App\Models\Company::take(1)->first()->name }}</p>
<p style="font-size: 25px">{{ App\Models\Company::take(1)->first()->address }}</p>
<p style="font-size: 25px">Kasir : {{ $transaction->user->name }}</p>
<p style="font-size: 25px">Tanggal : {{ date('m-d-Y', strtotime($transaction->created_at)) }}</p> --}}
==========================================================

<table>
  @foreach ($productTransactions as $product)
  <tr>
    <td style="width:50%"><p>{{ \Illuminate\Support\Str::limit($product->product->name, 25, $end='.') }}</p></td>
    <td colspan="2"><p>{{ $product->quantity }} x {{ $product->product->price }}</p></td>
    <td align=right><p style="margin-left:50px">{{ $product->product->price * $product->quantity }}</p></td>
  </tr>
  @endforeach
  <tr><td colspan="4">===========================================================</td></tr>
  <tr>
    <td colspan="3" align="right"><p>Total Pembelian</p></td>
    <td align=right><p style="margin-left:50px">{{ $transaction->purchase_order }}</p></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><p>Bayar</p></td>
    <td align=right><p style="margin-left:50px">{{ $transaction->pay }}</p></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><p>Kembalian</p></td>
    <td align=right><p style="margin-left:50px">{{ $transaction->return }}</p></td>
  </tr>
</table>
=============================================================<br>
<p>Terimakasih telah berbelanja. Semoga harimu menyenangkan</p>