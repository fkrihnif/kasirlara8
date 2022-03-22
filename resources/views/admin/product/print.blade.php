<style>
  @media print {
    body{
        /* width: 5cm;
        height: 1.5; */
        /* margin: 30mm 45mm 30mm 45mm;  */
        /* change the margins as you want them to be. */
   } 
}

  table {
          /* margin-left: auto;
          margin-right: auto;
          height: 100%; */
          table-layout: fixed;
        }

</style>

<table>

  @for ($i = 0; $i < $banyak; $i++)
  <tr>
    <td style="height: 20mm">
      <table style="width: 50mm; height:20mm">
        <tr >
          <td style="width:55%">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.8,40);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <p style="font-size: 13px">
              @php
                  echo substr($barcode->name,0,45);
              @endphp
              </p>
          </td>
          <td><br>
            <p style="font-size: 12px">@currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 </p>
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table style="width: 50mm; height:20mm">
        <tr>
          <td style="width:55%;">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.8,40);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <p style="font-size: 13px">
              @php
                  echo substr($barcode->name,0,45);
              @endphp
              </p>
          </td>
          <td><br>
            <p style="font-size: 12px">@currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 </p>
          </td>
        </tr>
      </table>
    </td>
    <td>
      <table style="width: 50mm; height:20mm">
        <tr >
          <td style="width:55%;">
            <?php 
             echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.8,40);
            ?>
          </td>
          <td></td>
        </tr>
        <tr>
          <td>
            <p style="font-size: 13px">
              @php
                  echo substr($barcode->name,0,45);
              @endphp
              </p>
          </td>
          <td><br>
            <p style="font-size: 12px">@currency($barcode->price) x1 <br>
            @currency($barcode->price3) x3 <br>
            @currency($barcode->price6) x6 </p>
          </td>
        </tr>
      </table>
    </td>
  
  </tr>
  @endfor
 


  
 
</table>