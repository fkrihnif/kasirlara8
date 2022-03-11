<style>
  @media print {
    body{
        /* width: 5cm;
        height: 1.5; */
        /* margin: 30mm 45mm 30mm 45mm;  */
        /* change the margins as you want them to be. */
   } 
}

  /* table {
          margin-left: auto;
          margin-right: auto;
          height: 100%;
          table-layout: fixed;
        } */

</style>

<table border="1px">

  @for ($i = 0; $i < $banyak; $i++)
  <tr>
    <td>
      <table style="width: 50mm; height:18mm">
        <tr >
          <td style="width:55%;">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'UPCA',2,45);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->name}} 
          </td>
          <td>
            @currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table style="width: 50mm; height:18mm">
        <tr >
          <td style="width:55%;">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'UPCA',2,45);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->name}} 
          </td>
          <td>
            @currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table style="width: 50mm; height:18mm">
        <tr >
          <td style="width:55%;">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'UPCA',2,45);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $barcode->name}} 
          </td>
          <td>
            @currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 
          </td>
        </tr>
      </table>
    </td>
  
  </tr>
  @endfor
 


  
 
</table>