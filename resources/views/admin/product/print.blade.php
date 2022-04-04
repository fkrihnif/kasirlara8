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

<table border="1px">

  @php
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
            {{-- <div class="mb-3">{!! DNS1D::getBarcodeSVG('4445645656', 'UPCA') !!}</div>  --}}
            {{-- <div>{!! DNS2D::getBarcodeHTML($barcode->product_code, 'C39') !!}</div> --}}
            @php
               echo DNS1D::getBarcodeSVG($barcode->product_code, 'C39',1.2,33,'black', false);
            @endphp
         
           </div>
       
   
    </td>
  </tr>
  @endfor
 


  
 
</table>
<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>
