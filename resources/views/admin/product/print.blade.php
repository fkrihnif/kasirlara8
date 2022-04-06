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
    <td style="margin-bottom: 0.3mm; margin-right: 1mm;">
        <div style="margin: auto; text-align:center;">
                  <?php 
                  if (strlen($barcode->product_code) >=1 && strlen($barcode->product_code) <=6) {    
                    echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.3,23,'black', false);
                  } else if (strlen($barcode->product_code) == 7 ) {    
                    echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.2,23,'black', false);
                  }else if (strlen($barcode->product_code) == 8 ) {    
                    echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.1,23,'black', false);
                  } else if (strlen($barcode->product_code) == 9 ) {    
                    echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.02,23,'black', false);
                  }else if(strlen($barcode->product_code) >=10){
                    echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',0.9,23,'black', false);
                  } 
                ?>
           <div style="font-size: 60%; text-align: left; width: 99px; white-space: initial; float:left; margin:3px 0 3px 3px; padding-left: 5px">
            @php
              echo substr($barcode->product_code,0,45);
            @endphp 
            <br>
            @php
              echo substr($barcode->name,0,32);
            @endphp
            </div>
            <div style="text-align: right; font-size: 60%; width: 100%; max-width: 71px; float:right; margin:3px; padding-right: 4px">
        {{-- atur jika harga 1 3 6 sama --}}
      @if ($barcode->price == $barcode->price3 && $barcode->price3 == $barcode->price6)
      @currency($barcode->price)
      @else
      @currency($barcode->price) x 1<br>
      @currency($barcode->price3) x 3<br>
      @currency($barcode->price6) x 6
      @endif
            </div>
          </div>
    </td>
    <td style="margin-bottom: 0.3mm; margin-right: 1mm;">
      <div style="margin: auto; text-align:center;">
        <?php 
        if (strlen($barcode->product_code) >=1 && strlen($barcode->product_code) <=6) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.3,23,'black', false);
        } else if (strlen($barcode->product_code) == 7 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.2,23,'black', false);
        }else if (strlen($barcode->product_code) == 8 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.1,23,'black', false);
        } else if (strlen($barcode->product_code) == 9 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.02,23,'black', false);
        }else if(strlen($barcode->product_code) >=10){
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',0.9,23,'black', false);
        } 
      ?>
 <div style="font-size: 60%; text-align: left; width: 99px; white-space: initial; float:left; margin:3px 0 3px 3px; padding-left: 5px">
  @php
    echo substr($barcode->product_code,0,45);
  @endphp 
  <br>
  @php
    echo substr($barcode->name,0,32);
  @endphp
  </div>
  <div style="text-align: right; font-size: 60%; width: 100%; max-width: 71px; float:right; margin:3px; padding-right: 4px">
{{-- atur jika harga 1 3 6 sama --}}
@if ($barcode->price == $barcode->price3 && $barcode->price3 == $barcode->price6)
@currency($barcode->price)
@else
@currency($barcode->price) x 1<br>
@currency($barcode->price3) x 3<br>
@currency($barcode->price6) x 6
@endif
  </div>
</div>
    </td>
    <td style="margin-bottom: 0.3mm">
      <div style="margin: auto; text-align:center;">
        <?php 
        if (strlen($barcode->product_code) >=1 && strlen($barcode->product_code) <=6) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.3,23,'black', false);
        } else if (strlen($barcode->product_code) == 7 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.2,23,'black', false);
        }else if (strlen($barcode->product_code) == 8 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.1,23,'black', false);
        } else if (strlen($barcode->product_code) == 9 ) {    
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.02,23,'black', false);
        }else if(strlen($barcode->product_code) >=10){
          echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',0.9,23,'black', false);
        } 
      ?>
 <div style="font-size: 60%; text-align: left; width: 99px; white-space: initial; float:left; margin:3px 0 3px 3px; padding-left: 5px">
  @php
    echo substr($barcode->product_code,0,45);
  @endphp 
  <br>
  @php
    echo substr($barcode->name,0,32);
  @endphp
  </div>
  <div style="text-align: right; font-size: 60%; width: 100%; max-width: 71px; float:right; margin:3px; padding-right: 4px">
{{-- atur jika harga 1 3 6 sama --}}
@if ($barcode->price == $barcode->price3 && $barcode->price3 == $barcode->price6)
@currency($barcode->price)
@else
@currency($barcode->price) x 1<br>
@currency($barcode->price3) x 3<br>
@currency($barcode->price6) x 6
@endif
  </div>
</div>
    </td>
  </tr>
  @endfor
 


  
 
</table>
<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>
