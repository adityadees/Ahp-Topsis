    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <?php
          $count_kriteria = $kriteria->num_rows();
          $all_kriteria   = $kriteria->result();
          $ksdx   = $ksd;

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
              foreach($matrix as $row){
                foreach($row as $key => $col){
                  $arr[$key] += $col * $priority[$key];
                }
              }

                   /*   foreach($arr as $key => $val){
                        $arr[$key] = $val/$priority[$key];
                      }*/
                      return $arr;
                    }

                    function get_consistency($cm){
                      $arr = array();

                      $sum = array_sum($cm);
                      $count = count($cm); 
                      $arr['ci'] = round(($sum - $count) / ($count - 1),6);

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
                      $arr['cr'] = round($arr['ci'] / $arr['ri'],5);
                      $arr['consistency'] =  $arr['cr']<=0.1 ? 'consistent' : 'inconsistent';

                      return $arr;
                    }
                  }

                  function display($arr, $echo = true){
                    $result = '<div class="table table-responsive"><table class="table table-bordered">';
                    foreach($arr as $key => $val){
                      $result.= '<tr>';
                      foreach($val as $k => $v){
                        $result.='<td>' . $v . '</td>';
                      }
                      $result.= '</tr>';
                    }
                    $result.= '</table></div>';

                    if($echo)
                      echo $result;
                    else
                      return $result;
                  }
                  $ahp = new AHP($ksdx);

                  ?>




                  <div class="row match-height">
                    <div class="col-md-12 col-sm-12">
                      <div class="card text-white  bg-teal bg-lighten-1 text-center">
                        <div class="card-content">
                          <div class="card-body">
                            <h4 class="card-title mt-3">Form Kepentingan</h4>

                            <form method="POST" action="<?= base_url('backendc');?>">
                              <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-hover  table-striped" id="kriteria">
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
                            </div>


                            <div class="col-md-12"><input type="submit" name="save_perbandingan" class="btn btn-warning" id="save_perbandingan" value="Hitung" /></div>

                          </form>


                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row match-height">
                  <div class="col-lg-12 col-md-12">
                    <div class="card text-center">
                      <div class="card-content">
                        <div class="card-body">
                          <h4 class="card-title success">Nilai Perbandingan Berpasangan</h4>

                          <?=
                          display($ksdx);
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row match-height">
                  <div class="col-xl-12 col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title">Penilaian</h4>
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


                          <?php
                          $alternatif = $this->db->query("SELECT * FROM alternatif order by alternatif_kode asc");
                          $nilai = $this->db->query("SELECT * FROM `nilai` LEFT join parameter on nilai.parameter_id=parameter.parameter_id")->result();

                          class topsis{ 


                            public function baseKriteria($qKriteria){
                              $arKriteria = [];
                              $i=0;
                              foreach ($qKriteria->result()  as $vKriteria):
                                $arKriteria[$i] = $vKriteria->kriteria_nama;
                                $i++;
                              endforeach;
                              return $arKriteria;
                            }

                            public function baseAlternatif($qAlternatif){
                              $arAlternatif = [];
                              $i=0;
                              foreach ($qAlternatif->result()  as $vAlternatif):
                                $arAlternatif[$i] = $vAlternatif->alternatif_nama;
                                $i++;
                              endforeach;
                              return $arAlternatif;
                            }


                            public function nilaiAlkrit($qAlternatif,$qKriteria,$qnilai){
                              $arNAK = [];
                              foreach ($qAlternatif->result()  as $i => $vAlternatif) :
                                $vAlternatif1=$vAlternatif->alternatif_kode;
                                foreach ($qKriteria->result()  as $j => $vKriteria) :
                                  $vKriteria1=$vKriteria->kriteria_kode;

                                  foreach ($qnilai as $kk) {
                                   if($kk->alternatif_kode == $vAlternatif1 && $kk->kriteria_kode==$vKriteria1){
                                    $arNAK[$i][$j] = $kk->parameter_nilai;
                                  } 
                                }

                                $j++;
                              endforeach;
                              $i++;
                            endforeach;
                            return $arNAK;
                          }



                          public function pembagi($baseAlternatif,$baseKriteria,$nilaiAlkrit){
                            $pembagi = array();

                            for ($i=0;$i<count($baseKriteria);$i++)
                            {
                              $pembagi[$i] = 0;
                              for ($j=0;$j<count($baseAlternatif);$j++)
                              {
                                $pembagi[$i] = $pembagi[$i] + ($nilaiAlkrit[$j][$i] * $nilaiAlkrit[$j][$i]);
                              }
                              $pembagi[$i] = sqrt($pembagi[$i]);
                            }
                            return $pembagi;
                          }

                          public function normalisasi($baseAlternatif,$baseKriteria,$nilaiAlkrit,$pembagi){
                            $normalisasi = array();
                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              for ($j=0;$j<count($baseKriteria);$j++)
                              {
                                $normalisasi[$i][$j] = round($nilaiAlkrit[$i][$j] / $pembagi[$j],3);
                              }
                            }
                            return $normalisasi;
                          }

                          public function terbobot($baseAlternatif,$baseKriteria,$normalisasi,$priority){
                            $terbobot = array();
                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              for ($j=0;$j<count($baseKriteria);$j++)
                              {
                                $terbobot[$i][$j] = round($normalisasi[$i][$j] * $priority[$j],5);
                              }
                            } 
                            return $terbobot;
                          }


                          public function aplus($baseKriteria,$baseAlternatif,$terbobot){
                            $aplus = array();

                            for ($i=0;$i<count($baseKriteria);$i++)
                            {
                              for ($j=0;$j<count($baseAlternatif);$j++)
                              {
                                if ($j == 0) 
                                { 
                                  $aplus[$i] = $terbobot[$j][$i];
                                }
                                else 
                                {
                                  if ($aplus[$i] < $terbobot[$j][$i])
                                  {
                                    $aplus[$i] = $terbobot[$j][$i];
                                  }
                                }
                              }
                            }
                            return $aplus;
                          }


                          public function amin($baseKriteria,$baseAlternatif,$terbobot){
                            $amin = array();

                            for ($i=0;$i<count($baseKriteria);$i++)
                            {
                              for ($j=0;$j<count($baseAlternatif);$j++)
                              {
                                if ($j == 0) 
                                { 
                                  $amin[$i] = $terbobot[$j][$i];
                                }
                                else 
                                {
                                  if ($amin[$i] > $terbobot[$j][$i])
                                  {
                                    $amin[$i] = $terbobot[$j][$i];
                                  }
                                }
                              }
                            }
                            return $amin;
                          }



                          public function dplus($baseAlternatif,$baseKriteria,$terbobot,$aplus){
                            $dplus = array();

                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              $dplus[$i] = 0;
                              for ($j=0;$j<count($baseKriteria);$j++)
                              {
                                $dplus[$i] = $dplus[$i] + (($aplus[$j] - $terbobot[$i][$j]) * ($aplus[$j] - $terbobot[$i][$j]));
                              }
                              $dplus[$i] = round(sqrt($dplus[$i]),9);
                            }
                            return $dplus;
                          }


                          public function dmin($baseAlternatif,$baseKriteria,$terbobot,$amin){
                            $dmin = array();

                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              $dmin[$i] = 0;
                              for ($j=0;$j<count($baseKriteria);$j++)
                              {
                                $dmin[$i] = $dmin[$i] + (($terbobot[$i][$j] - $amin[$j]) * ($terbobot[$i][$j] - $amin[$j]));
                              }
                              $dmin[$i] = round(sqrt($dmin[$i]),9);
                            }

                            return $dmin;
                          }


                          public function hasil($dmin,$dplus,$baseAlternatif){

                            $hasil = array();

                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              $hasil[$i] = round($dmin[$i] / ($dmin[$i] + $dplus[$i]),3);
                            } 

                            $alterRank = array();
                            $hasilrangking = array();

                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              $hasilrangking[$i] = $hasil[$i];
                              $alterRank[$i] = $baseAlternatif[$i];
                            }

                            for ($i=0;$i<count($baseAlternatif);$i++)
                            {
                              for ($j=$i;$j<count($baseAlternatif);$j++)
                              {
                                if ($hasilrangking[$j] > $hasilrangking[$i])
                                {
                                  $tmphasil = $hasilrangking[$i];
                                  $tmpdosen = $alterRank[$i];
                                  $hasilrangking[$i] = $hasilrangking[$j];
                                  $alterRank[$i] = $alterRank[$j];
                                  $hasilrangking[$j] = $tmphasil;
                                  $alterRank[$j] = $tmpdosen;
                                }
                              }
                            }

                            return [
                              'hasil' => $hasil,
                              'alterRank' => $alterRank,
                              'hasilrangking' => $hasilrangking,
                            ];
                          }
                        }




                        $topsis = new topsis;
                        $baseKriteria = $topsis->baseKriteria($kriteria);
                        $baseAlternatif = $topsis->baseAlternatif($alternatif);
                        $nilaiAlkrit = $topsis->nilaiAlkrit($alternatif,$kriteria,$nilai);
                        $pembagi = $topsis->pembagi($baseAlternatif,$baseKriteria,$nilaiAlkrit);
                        $normalisasi = $topsis->normalisasi($baseAlternatif,$baseKriteria,$nilaiAlkrit,$pembagi);
                        $terbobot = $topsis->terbobot($baseAlternatif,$baseKriteria,$normalisasi,$priority);
                        $aplus = $topsis->aplus($baseKriteria,$baseAlternatif,$terbobot);
                        $amin = $topsis->amin($baseKriteria,$baseAlternatif,$terbobot);
                        $dplus = $topsis->dplus($baseAlternatif,$baseKriteria,$terbobot,$aplus);
                        $dmin = $topsis->dmin($baseAlternatif,$baseKriteria,$terbobot,$amin);
                        $hasil = $topsis->hasil($dmin,$dplus,$baseAlternatif);

                        function showb($gdarray)
                        {
                          echo '<div class="table table-responsive">';
                          echo '<table class="table table-bordered">';
                          echo '<tr>';
                          for ($i=0;$i<count($gdarray);$i++)
                          {
                            echo '<td>'.$gdarray[$i].'</td>';
                          }
                          echo "</tr>";
                          echo '</table>';
                          echo '</div>';
                        }
                        function showt($gdarray)
                        {
                          echo '<div class="table table-responsive">';
                          echo '<table  class="table">';
                          for ($i=0;$i<count($gdarray);$i++)
                          {
                            echo '<tr>';
                            for ($j=0;$j<count($gdarray[$i]);$j++)
                            {
                              echo '<td>'.$gdarray[$i][$j].'</td>';
                            }
                            echo '</tr>';
                          }
                          echo '</table>';
                          echo '</div>';
                        }

                        function showk($gdarray)
                        {
                          echo '<div class="table table-responsive">';
                          echo '<table class="table">';
                          for ($i=0;$i<count($gdarray);$i++)
                          {
                            echo '<tr>';
                            echo '<td>'.$gdarray[$i].'</td>';
                            echo "</tr>";
                          }
                          echo '</table>';
                          echo '</div>';
                        }

                        echo "Kriteria";
                        showb($baseKriteria);
                        echo "Alternatif";
                        showb($baseAlternatif);
                        echo "Nilai";
                        showt($nilaiAlkrit);
                        echo "pembagi";
                        showb($pembagi);
                        echo "<br>";
                        echo "Normalisasi";
                        showt($normalisasi);
                        echo "Normalisasi Terbobot";
                        showt($terbobot);
                        echo "Solusi Ideal Positif (A+)";
                        showb($aplus);
                        echo "Solusi Ideal Negatif (A-)";
                        showb($amin);
                        echo "Jarak Solusi Ideal Positif (D+)";
                        showk($dplus);
                        echo "Jarak Solusi Ideal Negatif (D-)";
                        showk($dmin);

                        echo "Bobot Preferensi";
                        showb($hasil['hasil']);

                        echo "Bobot Preferensi";
                        showb($hasil['alterRank']);

                        echo "Bobot Preferensi";
                        showb($hasil['hasilrangking']);

                        ?>




                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
