    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <?php
          $count_kriteria = $kriteria->num_rows();
          $all_kriteria   = $kriteria->result();
          $ksdx   = $ksd;

          print_r($ksdx);
          ?>

          <form method="POST" action="<?= base_url('backendc');?>">
            <table class="table table-bordered table-condensed table-hover table-responsive table-striped" id="kriteria">
              <thead>
                <tr>
                  <?php if( $count_kriteria ): ?>
                    <th>Nama Kriteria</th>
                    <?php foreach ($all_kriteria as $key => $value): ?>
                      <th><?php echo $value->kriteria_nama; ?></th>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
               <?php  
      //for($i=0;$i<$jumlah_kriteria;$i++)
               $i=0;
               $l = 0;
               $m = $count_kriteria;
               $b=0;
               foreach($all_kriteria as $row)
               {

                echo '<tr>';
                echo '<td>';
                echo $row->kriteria_nama;
                echo '</td>';

                for($k=0;$k<$l;$k++){
                  echo '<td> - </td>';
                }
                for($j=0;$j<$m;$j++) {
                  if($j==0){
                    echo '<td>';
                    echo '1';
                    echo '</td>';

                  }else{              
                    $bobot_dipilih = 1;
                    echo '<td>';
                    echo form_dropdown('bobot'.$b, $bobot, $bobot_dipilih, 'size="0"');
                    echo '</td>';
                    $b++;
                  }
                }
                $l++;
                $m--;
                echo '</tr>';
                $i++;
              } ?>
            </tbody>
          </table>
          <dd><input type="submit" name="save_perbandingan" id="save_perbandingan" value="Hitung" /></dd>

        </form>

        <div class="row match-height">
          <div class="col-xl-8 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Recent Orders</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
                <div class="card-body">
                  <p>Data Transaksi Terakhir.</p>

                  <?php
                  error_reporting(~E_NOTICE);
                  class AHP{
                    function get_row_total($matrix){
                      $arr = array();
                      foreach($matrix as $row){
                        foreach($row as $key => $col){
                          $arr[$key] += $col;
                        }
                      }
                      return $arr;
                    }

                    function normalize($matrix, $row_total){
                      $arr = array();
                      foreach($matrix as $key => $val){
                        foreach($val as $k => $v){
                          $arr[$key][$k] = round($v / $row_total[$k],9);
                        }
                      }
                      return $arr;
                    }

                    function get_priority($normal){
                      $arr = array();
                      foreach($normal as $key => $val){
                        $arr[$key] = round(array_sum($val) / count($val),6);
                      }
                      return $arr;
                    }   



                    function get_jumlah_normalisasi($normal){
                      $arr = array();
                      foreach($normal as $key => $val){
                        $arr[$key] = array_sum($val);
                      }
                      return $arr;
                    }   



                    function get_cm($matrix, $priority){
                      $arr = array();
                      foreach($matrix as $key => $val){
                        foreach($val as $k => $v){
                          $arr[$key]+=$v * $priority[$k];
                        }
                      }

                      foreach($arr as $key => $val){
                        $arr[$key] = $val/$priority[$key];
                      }
                      return $arr;
                    }

                    function get_consistency($cm){
                      $arr = array();

                      $sum = array_sum($cm);
                      $count = count($cm); 
                      $arr['ci'] = (($sum / $count) - $count) / ($count - 1);

                      $nRI = array (
                       1=>0,
                       2=>0,
                       3=>0.58,
                       4=>0.9,
                       5=>1.12,
                       6=>1.24,
                       7=>1.32,
                       8=>1.41,
                       9=>1.46,
                       10=>1.49,
                       11=>1.51,
                       12=>1.48,
                       13=>1.56,
                       14=>1.57,
                       15=>1.59
                     );
                      $arr['ri'] = $nRI[count($cm)];
                      $arr['cr'] = $arr['ci'] / $arr['ri'];
                      $arr['consistency'] =  $arr['cr']<=0.1 ? 'consistent' : 'inconsistent';

                      return $arr;
                    }
                  }

                  function display($arr, $echo = true){
                    $result = '<table border="1">';
                    foreach($arr as $key => $val){
                      $result.= '<tr>';
                      foreach($val as $k => $v){
                        $result.='<td>' . $v . '</td>';
                      }
                      $result.= '</tr>';
                    }
                    $result.= '</table>';

                    if($echo)
                      echo $result;
                    else
                      return $result;
                  }

                

                  $ahp = new AHP($ksdx);
                  display($ksdx);


                  echo "<br>Perbandingan :<br>";
                  $row_total = $ahp->get_row_total($ksdx);
                  display(array($row_total));

                  echo "<br>";
                  $normal = $ahp->normalize($ksdx, $row_total);
                  display($normal);

                  echo "<br>";
                  $priority = $ahp->get_priority($normal);
                  display(array($priority));

                  echo "<br>";
                  $sumnor = $ahp->get_jumlah_normalisasi($normal);
                  display(array($sumnor));


                  echo "<br>";
                  $cm = $ahp->get_cm($ksdx, $priority);
                  display(array($cm));


                  $consistency = $ahp->get_consistency($cm);

                  echo 'CI: ' . $consistency['ci'] . '<br />';
                  echo 'Ri: ' . $consistency['ri'] . '<br />';
                  echo 'CR: ' . $consistency['cr'] . '<br />';
                  echo 'Consistency: ' . $consistency['consistency'] . '<br />';
                  ?>




                
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
