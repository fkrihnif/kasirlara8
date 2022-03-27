<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script type="text/javascript">
            window.onload = function() { window.print(); }
          </script>
        <style>
            * {
    font-size: 12px;
    font-family: 'Times New Roman';
}

table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 20mm;
    max-width: 20mm;
}

td.quantity,
th.quantity {
    width: 15mm;
    max-width: 15mm;
    word-break: break-all;
}

td.price,
th.price {
    width: 15mm;
    max-width: 15mm;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 56mm;
    max-width: 56mm;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
        </style>
        <title>{{ App\Models\Company::take(1)->first()->name }}</title>
    </head>
    <body>
        <div class="ticket" style="margin-left: 1mm;">
            <p class="centered">{{ App\Models\Company::take(1)->first()->name }}
                <br>{{ App\Models\Company::take(1)->first()->address }}
            </p>
            <div>{{ $transaction->user->name }}</div>
          
            <div>Kode : {{$transaction->transaction_code}} -   @if ($transaction->customer_name != null or $transaction->account_number != null)
                Card
                              @else
                Cash
                @endif </div>
            
            <table>
        
                <tbody>
                    

                    @foreach ($productTransactions as $product)
                    <tr>
                        @php
                        if ($product->quantity >= 1 && $product->quantity<=2) {
                          $price = $product->product->price;
                        } elseif ($product->quantity >= 3 && $product->quantity<=5) {
                          $price = $product->product->price3;
                        } elseif ($product->quantity >= 6) {
                          $price = $product->product->price6;
                        }
                   
                       $discountItem = $product->disc_rp + (($product->disc_prc/100) * ($price * $product->quantity));
                       @endphp
                        <td class="description" colspan="2" style="width: 35mm; max-width:35mm;">{{ \Illuminate\Support\Str::limit($product->product->name, 40, $end='.') }} <div style="font-size: 70%;">({{$product->product->product_code}})</div>
                      
                        <div style="font-size: 90%">{{ $product->quantity }} x @ {{ format_uang($price)  }}</div>
                        @if ($product->disc_rp != null || $product->disc_prc != null)
                            <div style="font-size: 70%"> - disc {{format_uang($discountItem)}}</div>
                        @endif <div></div>
                        </td>
                        <td class="price" style="font-size: 90%">{{ format_uang(($price * $product->quantity)- $discountItem) }}</td>
                    </tr>
                        
                    @endforeach
                    @if ($transaction->disc_total_prc != null || $transaction->disc_total_rp != null)
                    @php
                    $discPercent = ($transaction->disc_total_prc / 100) * $transaction->totalSementara;
                    $discount = $discPercent + $transaction->disc_total_rp;
                    @endphp
                    <tr style="  border-top: 1px solid black;
                      border-collapse: collapse;">
                        <td class="quantity"></td>
                        <td class="description">Disc</td>
                        <td class="price" style="font-size: 90%">{{ format_uang($discount)  }}</td>
                    </tr>
                    @endif
                    <tr style="  border-top: 1px solid black;
                    border-collapse: collapse;">
                        <td class="quantity"></td>
                        <td class="description">Total</td>
                        <td class="price" style="font-size: 90%">{{ format_uang($transaction->purchase_order)  }}</td>
                    </tr>
                    <tr>
                        <td class="quantity"></td>
                        <td class="description">Cash</td>
                        <td class="price" style="font-size: 90%">{{ format_uang($transaction->pay)  }}</td>
                    </tr>
                    <tr>
                        <td class="quantity"></td>
                        <td class="description">Kembali</td>
                        <td class="price" style="font-size: 90%">{{ format_uang($transaction->return)  }}</td>
                    </tr>
         
                </tbody>
            </table>
            <p class="centered" style="font-size: 50%">
                <b>Terima Kasih Sudah Berbelanja</b><br>Barang yg sudah dibeli tdk dapat dikembalikan lagi.</p>
                
                <p class="centered">{{ date('d-M-Y H:i:s', strtotime($transaction->created_at)) }}</p>
        </div>
    </body>
</html>