    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <?php

          $count_kriteria = count($kriteria);
          $all_kriteria   = $kriteria;
          if (isset($ksd)) {

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

        <?php if(isset($ksd)){?>

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
                              display($all_kriteria,$ksd);
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

        <?php } ?>

      </div>
    </div>
  </div>
