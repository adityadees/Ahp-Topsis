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

                  function display($data,$arr, $echo = true){
                    $result = '<div class="table-responsive"><table class="table table-hover table-striped table-bordered">
                    <thead><tr>';

                    foreach($data as $xd){
                      $result.='<th>' . $xd->kriteria_nama . '</th>';
                    }
                    $result.= '</tr></thead><tbody>';

                    foreach($arr as $key => $val){
                      $result.= '<tr>';
                      foreach($val as $k => $v){
                        $result.='<td>' . $v . '</td>';
                      }
                      $result.= '</tr>';
                    }
                    $result.= '</tbody></table></div>';

                    if($echo)
                      echo $result;
                    else
                      return $result;
                  }
                  $ahp = new AHP($ksdx);
                  $row_total = $ahp->get_row_total($ksdx);
                  $normal = $ahp->normalize($ksdx, $row_total);
                  $priority = $ahp->get_priority($normal);
                  $sumnor = $ahp->get_jumlah_normalisasi($normal);
                  $cm = $ahp->get_cm($ksdx, $priority);
                  $consistency = $ahp->get_consistency($cm);


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

                function showb($data,$gdarray)
                {
                  echo '<div class="table-responsive">';
                  echo '<table class="table table table-hover table-striped table-bordered">';
                  echo '<thead><tr>';
                  foreach($data as $xd){
                    echo '<th>' . $xd->kriteria_nama . '</th>';
                  }
                  echo '</tr></thead><tbody>';
                  echo '<tr>';
                  for ($i=0;$i<count($gdarray);$i++)
                  {
                    echo '<td>'.$gdarray[$i].'</td>';
                  }
                  echo "</tr>";
                  echo '</tbody></table>';
                  echo '</div>';
                }
                function showt($data,$gdarray)
                {
                  echo '<div class="table-responsive">';
                  echo '<table  class="table table table-hover table-striped table-bordered">';
                  echo '<thead><tr>';

                  foreach($data as $xd){
                    echo '<th>' . $xd->kriteria_nama . '</th>';
                  }

                  echo '</tr></thead><tbody>';

                  for ($i=0;$i<count($gdarray);$i++)
                  {
                    echo '<tr>';
                    for ($j=0;$j<count($gdarray[$i]);$j++)
                    {
                      echo '<td>'.$gdarray[$i][$j].'</td>';
                    }
                    echo '</tr>';
                  }
                  echo '</tbody></table>';
                  echo '</div>';
                }

                function showk($data,$gdarray)
                {
                  echo '<div class="table-responsive">';
                  echo '<table class="table table table-hover table-striped table-bordered">';
                  for ($i=0;$i<count($gdarray);$i++)
                  {
                    echo '<tr>';
                    echo '<td>'.$data[$i].'</td>';
                    echo '<td>'.$gdarray[$i].'</td>';
                    echo "</tr>";
                  }
                  echo '</table>';
                  echo '</div>';
                }
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



              <div class="row">
                <div class="col-lg-12 col-xl-12">
                  <div id="wrapahp" role="tablist" aria-multiselectable="true">
                    <div class=" collapse-icon accordion-icon-rotate">

                      <div id="headahp" class="card-header bg-success">
                        <a data-toggle="collapse" href="#acahp" aria-expanded="true"
                        aria-controls="acahp" class="card-title lead text-white">AHP</a>
                      </div>

                      <div id="acahp" role="tabpanel" data-parent="#wrapahp" aria-labelledby="headahp" class="collapse">

                        <div class="row match-height">
                          <div class="col-lg-12 col-md-12">
                            <div class="card text-center">
                              <div class="card-content">
                                <div class="card-body">
                                  <h4 class="card-title success">Nilai Perbandingan Berpasangan</h4>

                                  <?php
                                  display($all_kriteria,$ksdx);
                                  ?>
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
                                  <h4 class="card-title success">Jumlah Nilai Perbandingan Berpasangan</h4>
                                  <?php
                                  display($all_kriteria,[$row_total]);
                                  ?>
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
                                  <h4 class="card-title success">Matriks Normalisasi</h4>
                                  <?php
                                  display($all_kriteria,$normal);
                                  ?>
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
                                  <h4 class="card-title success">Bobot</h4>
                                  <?php
                                  display($all_kriteria,[$priority]);
                                  ?>
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
                                  <h4 class="card-title success">Jumlah Hasil Normalisasi</h4>
                                  <?php
                                  display($all_kriteria,[$sumnor]);
                                  ?>
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
                                  <h4 class="card-title success">Hasil Perhitungan Rasio Kriteria</h4>
                                  <?php
                                  display($all_kriteria,[$cm]);
                                  ?>
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
                                  <h4 class="card-title success">Dari tabel tersebut maka diperoleh nilai - nilai sebagai berikut :</h4>
                                  <div class="table-responsive">
                                    <table class="table table table-hover table-striped table-bordered">
                                      <tr>
                                        <td>CI</td>
                                        <td><?= $consistency['ci']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Ri</td>
                                        <td><?= $consistency['ri']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>CR</td>
                                        <td><?= $consistency['cr']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Consistency</td>
                                        <td><?= $consistency['consistency']; ?></td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>


                      </div>



                    </div>
                  </div>
                </div>

              </div>


<hr>


              
              <div class="row">
                <div class="col-lg-12 col-xl-12">
                  <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                    <div class=" collapse-icon accordion-icon-rotate">

                      <div id="heading11" class="card-header bg-info">
                        <a data-toggle="collapse" href="#actopsis" aria-expanded="true"
                        aria-controls="actopsis" class="card-title lead  text-white">Topsis</a>
                      </div>

                      <div id="actopsis" role="tabpanel" data-parent="#accordionWrap1" aria-labelledby="heading11" class="collapse">

                        <div class="row match-height">
                          <div class="col-lg-12 col-md-12">
                            <div class="card text-center">
                              <div class="card-content">
                                <div class="card-body">
                                  <h4 class="card-title info">Nilai Alternatif - Matrix Keputusan (x)</h4>
                                  <?php showt($all_kriteria,$nilaiAlkrit); ?>
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
                                  <h4 class="card-title info">Nilai Pembagi</h4>
                                  <?php showb($all_kriteria,$pembagi); ?>
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
                                  <h4 class="card-title info">Matriks Normalisasi (R)</h4>
                                  <?php showt($all_kriteria,$normalisasi);  ?>
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
                                  <h4 class="card-title info">Matriks Normalisasi Terbobot (Y)</h4>
                                  <?php showt($all_kriteria,$terbobot); ?>
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
                                  <h4 class="card-title info">Solusi Ideal Positif (A+)</h4>
                                  <?php showb($all_kriteria,$aplus); ?>
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
                                  <h4 class="card-title info">Solusi Ideal Negatif (A-)</h4>
                                  <?php showb($all_kriteria,$amin); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="row match-height">
                          <div class="col-lg-6 col-md-6">
                            <div class="card text-center">
                              <div class="card-content">
                                <div class="card-body">
                                  <h4 class="card-title info">Jarak Solusi Ideal Positif (D+)</h4>
                                  <?php showk($baseAlternatif,$dplus); ?>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-6 col-md-6">
                            <div class="card text-center">
                              <div class="card-content">
                                <div class="card-body">
                                  <h4 class="card-title info">Jarak Solusi Ideal Negatif (D-)</h4>
                                  <?php showk($baseAlternatif,$dmin); ?>
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
                                  <h4 class="card-title info">Nilai Preferensi (V)</h4>
                                  <?php showk($baseAlternatif,$hasil['hasil']); ?>
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
                                  <h4 class="card-title info">Perangkingan</h4>
                                  <?php showk($hasil['alterRank'],$hasil['hasilrangking']); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>


                      </div>



                    </div>
                  </div>
                </div>

              </div>


              


              




            </div>
          </div>
        </div>
