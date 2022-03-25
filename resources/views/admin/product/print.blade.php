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

  @for ($i = 0; $i < $banyak; $i++)
  <tr>
    <td style="margin-bottom: 0.2mm; margin-right: 1mm;">
           <div style="margin: auto; width: 81.5%;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.7,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          <div style="text-align: center; font-size: 50%; padding-top: 3px">
              @currency($barcode->price) x1 &ensp;
              @currency($barcode->price3) x3 &ensp;
              @currency($barcode->price6) x6
          </div>
    </td>
    <td style="margin-bottom: 0.2mm; margin-right: 1mm;">
           <div style="margin: auto; width: 81.5%;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.7,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          <div style="text-align: center; font-size: 50%; padding-top: 3px">
              @currency($barcode->price) x1 &ensp;
              @currency($barcode->price3) x3 &ensp;
              @currency($barcode->price6) x6
          </div>
    </td>
    <td style="margin-bottom: 0.2mm">
           <div style="margin: auto; width: 81.5%;">
            <?php 
              echo DNS1D::getBarcodeSVG($barcode->product_code, 'CODABAR',1.7,40);
            ?>
           </div>
          <div style="text-align: center; font-size: 55%; padding-top: 4px">
            @php
              echo substr($barcode->name,0,45);
            @endphp
          </div>
          <div style="text-align: center; font-size: 50%; padding-top: 3px">
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
