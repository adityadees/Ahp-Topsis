    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">


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
                        foreach($matrix as $key => $val){
                          foreach($val as $k => $v){
                            $arr[$k]+=$v;
                          }
                        }
                        return $arr;
                      }
                      
                      function normalize($matrix, $row_total){
                        $arr = array();
                        foreach($matrix as $key => $val){
                          foreach($val as $k => $v){
                            $arr[$key][$k] = $v / $row_total[$k];
                          }
                        }
                        return $arr;
                      }
                      
                      function get_priority($normal){
                        $arr = array();
                        foreach($normal as $key => $val){
                          $arr[$key] = array_sum($val) / count($val);
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

                    $matrix = array(
                      array(1, 2, 3,2,7),
                      array(0.5, 1, 2,3,3),
                      array(0.333, 0.5, 1,2,3),   
                      array(0.5, 0.333, 0.5,1,2),   
                      array(0.143, 0.333, 0.333,0.5,1),   
                      array(2.476, 4.166, 6.833,8.5,16),   
                    );

                    echo '<h3>Step 1</h3>';
                    $ahp = new AHP($matrix);
                    display($matrix);


                    $ck = [2.476,4.166,6.833,8.5,16];

                    print_r($ck);
                    echo '<h3>Step 2</h3>';
                    $row_total = $ahp->get_row_total($matrix);
                    display(array($row_total));

                    echo '<h3>Step 3</h3>';
                    $normal = $ahp->normalize($matrix, $ck);
                    display($normal);

                    echo '<h3>Step 4</h3>';
                    $priority = $ahp->get_priority($normal);
                    display(array($priority));

                    echo '<h3>Step 5</h3>';
                    $cm = $ahp->get_cm($matrix, $priority);
                    display(array($cm));


                    echo '<h3>Step 5</h3>';
                    $consistency = $ahp->get_consistency($cm);

                    echo 'CI: ' . $consistency['ci'] . '<br />';
                    echo 'CI: ' . $consistency['ri'] . '<br />';
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
