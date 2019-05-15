    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <?php
          $count_kriteria = $kriteria->num_rows();
          $all_kriteria   = $kriteria->result();

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
          <div class="col-xl-12 col-lg-12">
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



                $topsis = new topsis;
                $baseKriteria = $topsis->baseKriteria($kriteria);
                $baseAlternatif = $topsis->baseAlternatif($alternatif);
                $nilaiAlkrit = $topsis->nilaiAlkrit($alternatif,$kriteria,$nilai);
                $pembagi = $topsis->pembagi($baseAlternatif,$baseKriteria,$nilaiAlkrit);
                $normalisasi = $topsis->normalisasi($baseAlternatif,$baseKriteria,$nilaiAlkrit,$pembagi);

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



                ?>





              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
