<style>
  @media print {
      body {
          /* width: 5cm;
        height: 1.5; */
          /* margin: 30mm 45mm 30mm 45mm;  */
          /* change the margins as you want them to be. */
      }
  } 
  table td {
      width: 5cm; 
      height:1.8cm;
      overflow: hidden;
      display: inline-block;
      white-space: nowrap;
  }

  /* @page {
      size: 16.5cm 22cm;
      margin-top: 2mm;
      margin-bottom: 2mm;
      margin-left: 1mm;
      margin-right: 1mm;
  } */

  @media print 
{
    @page {
      size: 155mm 195mm;
      margin:0;
    }
    html, body {
        width: 155mm;
        /* height: 297mm; */
        height: 195mm;
        background: #FFF;
        overflow:visible;
    }
    body {
        padding-top:0mm;
    }
}
      /* ... the rest of the rules ... */
  }
  }
</style>

<table>

  @php
  $barcode->product_code = '12232122';
  if (strlen($barcode->product_code) >=1 && strlen($barcode->product_code) <=7) {                    
    $lebar = 1.2;
  } else if (strlen($barcode->product_code) >=8 && strlen($barcode->product_code) <=9) {
    $lebar = 1.1;
  } else if(strlen($barcode->product_code) >=10){
    $lebar = 0.93;
  } 
                  
  @endphp

  @for ($i = 0; $i < $banyak; $i++)
  <tr>
    <td style="margin-bottom: 0.2mm; margin-right: 1mm;">
          <div style="margin: auto; text-align:center;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',$lebar,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          @php
              //atur size utk harga
              if (strlen($barcode->price) >= 6 || strlen($barcode->price3) >= 6 || strlen($barcode->price6) >= 6 ) {
                $divPrice = '<div style="text-align: center; font-size: 8px; padding-top: 3px">';
              } else {
                $divPrice = '<div style="text-align: center; font-size: 50%; padding-top: 3px">';
              }
              
              echo $divPrice;
          @endphp
              @currency($barcode->price) x1 &ensp;
              @currency($barcode->price3) x3 &ensp;
              @currency($barcode->price6) x6
          </div>
    </td>
    <td style="margin-bottom: 0.2mm; margin-right: 1mm;">
          <div style="margin: auto; text-align:center;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',$lebar,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          @php
              echo $divPrice;
          @endphp
              @currency($barcode->price) x1 &ensp;
              @currency($barcode->price3) x3 &ensp;
              @currency($barcode->price6) x6
          </div>
    </td>
    <td style="margin-bottom: 0.2mm">
          <div style="margin: auto; text-align:center;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',$lebar,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          @php
            echo $divPrice;
          @endphp
              @currency($barcode->price) x1 &ensp;
              @currency($barcode->price3) x3 &ensp;
              @currency($barcode->price6) x6
          </div>
    </td>
  </tr>
  @endfor
 


  
 
</table>
<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>
