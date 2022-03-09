<style>
  @media print {
    body{
        width: 5cm;
        height: 1.5;
        /* margin: 30mm 45mm 30mm 45mm;  */
        /* change the margins as you want them to be. */
   } 
}

</style>

<table>
  <tr>
    <td>
      <table>
        <tr>
          <td style="width:70%">
            {!! DNS1D::getBarcodeHTML($barcode->product_code, 'UPCA') !!}
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->product_code}} <br>
            {{ $barcode->name}} 
          </td>
          <td>
            {{ $barcode->price}} x1 <br>
            {{ $barcode->price3}} x3 <br>
            {{ $barcode->price6}} x6 
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table>
        <tr>
          <td style="width:70%">
            {!! DNS1D::getBarcodeHTML($barcode->product_code, 'UPCA') !!}
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->product_code}} <br>
            {{ $barcode->name}} 
          </td>
          <td>
            {{ $barcode->price}} x1 <br>
            {{ $barcode->price3}} x3 <br>
            {{ $barcode->price6}} x6 
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table>
        <tr>
          <td style="width:70%">
            {!! DNS1D::getBarcodeHTML($barcode->product_code, 'UPCA') !!}
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->product_code}} <br>
            {{ $barcode->name}} 
          </td>
          <td>
            {{ $barcode->price}} x1 <br>
            {{ $barcode->price3}} x3 <br>
            {{ $barcode->price6}} x6 
          </td>
        </tr>
      </table>
    </td>
  </tr>
  
 
</table>