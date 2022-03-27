<style>
  @media print {
      body {
          /* width: 5cm;
        height: 1.5; */
          /* margin: 30mm 45mm 30mm 45mm;  */
          /* change the margins as you want them to be. */
      }
  }
  table{
      width: 156mm; 
  }
  
  table td {
      width: 5cm; 
      height:1.8cm;
      overflow: hidden;
      display: inline-block;
      white-space: nowrap;
  }

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
    <thead>
        <tr>
        </tr>
    </thead>
    <tfoot>
        <tr>
        </tr>
    </tfoot>
    <tbody>
        <tr>
          <?php 
          $keys = array_keys($jumlah);
          $lastKey = $keys[count($jumlah)-1];         
            for ($i=0; $i <= $lastKey; $i++) {
            if ($i < 30) {
              $tampil = '<td style="margin-bottom: 0.9mm; margin-right: 1mm;">';
            }
            else {
              $tampil = '<td style="; margin-bottom: 1.1mm; margin-right: 1mm;">';
            }
            echo $tampil;
          ?>
                {{-- <div style="margin: auto; width: 81.5%;"> --}}
                  <div style="margin: auto; text-align:center;">
                  <?php 
                    if (strlen($jumlah[$i]['kode']) >=1 && strlen($jumlah[$i]['kode']) <=7) {
                      
                      echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1.2,40);
                    } else if (strlen($jumlah[$i]['kode']) >=8 && strlen($jumlah[$i]['kode']) <=9) {
                      echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1,40);
                    } else if(strlen($jumlah[$i]['kode']) >=10){
                      echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',0.93,40);
                    } 
                  ?>
                 </div>
                <div style="text-align: center; font-size: 55%; padding-top: 4px">
                  @php
                    echo substr($jumlah[$i]['nama'],0,45);
                  @endphp
                </div>
                @php
                //atur size utk harga
                if (strlen($jumlah[$i]['harga']) >= 6 || strlen($jumlah[$i]['harga3']) >= 6 || strlen($jumlah[$i]['harga6']) >= 6 ) {
                  $divPrice = '<div style="text-align: center; font-size: 8px; padding-top: 3px">';
                } else {
                  $divPrice = '<div style="text-align: center; font-size: 50%; padding-top: 3px">';
                }
                
                echo $divPrice;
                @endphp
                    @currency($jumlah[$i]['harga']) x1 &ensp;
                    @currency($jumlah[$i]['harga3']) x3 &ensp;
                    @currency($jumlah[$i]['harga6']) x6
                </div>
          </td>
        <?php
        } 
        ?>
        </tr>
</table>
<script type="text/javascript">
  window.onload = function() { window.print(); }
</script>
