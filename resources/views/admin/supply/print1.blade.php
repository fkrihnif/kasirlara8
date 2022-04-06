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
                $tampil = '<td style="margin-bottom: 0.92mm; 1mm; margin-right: 1mm;">';
              }
              else {
                $tampil = '<td style="; margin-bottom: 1.1mm; margin-right: 1mm;">';
              }
              echo $tampil;
            ?>
                  <div style="margin-top: 1px;text-align:center;">
                {{-- <div style="margin: auto; text-align:center;"> --}}
                          <?php 
                          if (strlen($jumlah[$i]['kode']) >=1 && strlen($jumlah[$i]['kode']) <=6) {    
                            echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1.3,23,'black', false);
                          } else if (strlen($jumlah[$i]['kode']) == 7 ) {    
                            echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1.2,23,'black', false);
                          }else if (strlen($jumlah[$i]['kode']) == 8 ) {    
                            echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1.1,23,'black', false);
                          } else if (strlen($jumlah[$i]['kode']) == 9 ) {    
                            echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',1.02,23,'black', false);
                          }else if(strlen($jumlah[$i]['kode']) >=10){
                            echo DNS1D::getBarcodeSVG($jumlah[$i]['kode'], 'C39',0.9,23,'black', false);
                          } 
                        ?>
                   </div>
                   <div style="font-size: 60%; text-align: left; width: 99px; white-space: initial; float:left; margin:3px 0 3px 3px; padding-left: 5px">
                    @php
                      echo substr($jumlah[$i]['kode'],0,45);
                    @endphp 
                    <br>
                    @php
                      echo substr($jumlah[$i]['nama'],0,32);
                    @endphp
                    </div>
                    <div style="text-align: right; font-size: 60%; width: 100%; max-width: 71px; float:right; margin:3px; padding-right: 4px">
                {{-- atur jika harga 1 3 6 sama --}}
              @if ($jumlah[$i]['harga'] == $jumlah[$i]['harga3'] && $jumlah[$i]['harga3'] == $jumlah[$i]['harga6'])
              @currency($jumlah[$i]['harga'])
              @else
              @currency($jumlah[$i]['harga']) x 1<br>
              @currency($jumlah[$i]['harga3']) x 3<br>
              @currency($jumlah[$i]['harga6']) x 6
              @endif
                    </div>
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
  