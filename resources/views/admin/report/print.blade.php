<style>
  p{
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  }

  @media print 
{
    @page {
      width: 56mm;
      margin:0;
    }
    html, body {
        width: 56mm;
        background: #FFF;
        overflow:visible;
    }
    body {
        padding-top:0mm;
    }
}

</style>
<table>
  <tr>
    <td style=" width: 58mm; overflow: hidden; display: inline-block; white-space: nowrap;">
      <div style="text-align: center; font-size: 55%;">
        {{ App\Models\Company::take(1)->first()->name }}
      </div>
     <div style="text-align: center; font-size: 55%;">
        {{ App\Models\Company::take(1)->first()->address }}
     </div>
     <div style="text-align: center; font-size: 55%;">
      Kasir : {{ $transaction->user->name }}
    </div>
    <div style="text-align: center; font-size: 55%;">
      Tanggal : {{ date('d-m-Y', strtotime($transaction->created_at)) }}
    </div>
  </td>
  </tr>
  
</table>
================================================================

<table border="1px" style="width: 55mm">
  @foreach ($productTransactions as $product)
  <tr>
    <td><p>{{ \Illuminate\Support\Str::limit($product->product->name, 25, $end='.') }}</p></td>
    @php
    if ($product->quantity >= 1 && $product->quantity<=2) {
      $price = $product->product->price;
    } elseif ($product->quantity >= 3 && $product->quantity<=5) {
      $price = $product->product->price3;
    } elseif ($product->quantity >= 6) {
      $price = $product->product->price6;
    }
@endphp
    <td><p>{{ $product->quantity }} x {{ $price }}</p></td>
    @php
    $discountItem = $product->disc_rp + (($product->disc_prc/100) * ($price * $product->quantity));
    @endphp
    <td><p>disc {{ $discountItem }}</p></td>
    <td align=right><p style="margin-left:50px">{{ format_uang(($price * $product->quantity)- $discountItem) }}</p></td>
  </tr>
  @endforeach
  <tr><td colspan="4">===================================================================</td></tr>
  <tr>
    <td colspan="3" align="right"><p>Total</p></td>
    <td align=right><p style="margin-left:50px">{{ format_uang($transaction->totalSementara)  }}</p></td>
  </tr>
  @php
  $discPercent = ($transaction->disc_total_prc / 100) * $transaction->totalSementara;
  $discount = $discPercent + $transaction->disc_total_rp;
  @endphp
    <tr>
      <td colspan="3" align="right"><p>Discount</p></td>
      <td align=right><p style="margin-left:50px">{{ format_uang($discount)  }}</p></td>
    </tr>
  <tr>
    <td colspan="3" align="right"><p>Total Akhir</p></td>
    <td align=right><p style="margin-left:50px">{{ format_uang($transaction->purchase_order) }}</p></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><p>Bayar</p></td>
    <td align=right><p style="margin-left:50px">{{ format_uang($transaction->pay) }}</p></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><p>Kembalian</p></td>
    <td align=right><p style="margin-left:50px">{{ format_uang($transaction->return) }}</p></td>
  </tr>
</table>
=============================================================<br>
<p>Terimakasih telah berbelanja. Semoga harimu menyenangkan</p>
<p>Barang yang sudah dibeli tidak dapat dikembalikan</p>

<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>