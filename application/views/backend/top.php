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
class topsis{ //topsis class


  public function pembagi($data){ //### Step 1 ###
    /*
    * Create an evaluation matrix consisting of m alternatives and n criteria, with the intersection of each alternative and criteria given as {\displaystyle x_{ij}} x_{ij}, we therefore have a matrix 
    */
    for($kolom = 0; $kolom < count($data[0]);$kolom++){
      $jumlahBaris = 0;
      for($baris = 0; $baris < count($data);$baris++){
        $jumlahBaris += pow($data[$baris][$kolom]['nilai'], 2);
      }
      $hasil[$kolom] = sqrt($jumlahBaris);
    }
    return $hasil;
  }

  public function ternomalisasi($data, $pembagi){ //### step 2 ###
    /*
    * then normalised to form the matrix
    */
    for($kolom = 0; $kolom < count($data[0]);$kolom++){
      for($baris = 0; $baris < count($data);$baris++){
        $hasil[$baris][$kolom]['nilai'] = $data[$baris][$kolom]['nilai']/$pembagi[$kolom];
        $hasil[$baris][$kolom]['id_kriteria'] = $data[$baris][$kolom]['id_kriteria'];
        $hasil[$baris][$kolom]['id_alternatif'] = $data[$baris][$kolom]['id_alternatif'];
      }
    }
    return $hasil;
  }

  public function terbobot($ternomalisasi, $kepentingan){ //### step 3 ###
    /*
    * Calculate the weighted normalised decision matrix
    */
    for($kolom = 0; $kolom < count($ternomalisasi[0]);$kolom++){
      for($baris = 0; $baris < count($ternomalisasi);$baris++){
        $hasil[$baris][$kolom]['nilai'] = $ternomalisasi[$baris][$kolom]['nilai']*$kepentingan[$kolom];
        $hasil[$baris][$kolom]['id_kriteria'] = $ternomalisasi[$baris][$kolom]['id_kriteria'];
        $hasil[$baris][$kolom]['id_alternatif'] = $ternomalisasi[$baris][$kolom]['id_alternatif'];
      }
    }
    return $hasil;
  }
  public function ideal_positif_negatif($terbobot, $sifat){ //### step 4 ###
    /*
    * Determine the worst ideal and best ideal
    */
    for($kolom = 0; $kolom < count($terbobot[0]);$kolom++){
      $hasilKolomTerbesar = $terbobot[0][$kolom];
      $hasilKolomTerkecil = $terbobot[0][$kolom];
      for($baris = 0; $baris < count($terbobot);$baris++){
        if($terbobot[$baris][$kolom] > $hasilKolomTerbesar){
          $hasilKolomTerbesar = $terbobot[$baris][$kolom];
        }
        if($terbobot[$baris][$kolom] < $hasilKolomTerkecil){
          $hasilKolomTerkecil = $terbobot[$baris][$kolom];
        }
      }
      $hasil['positif'][$kolom] = $sifat[$kolom]=='benefit'?$hasilKolomTerbesar:$hasilKolomTerkecil;
      $hasil['negatif'][$kolom] = $sifat[$kolom]=='benefit'?$hasilKolomTerkecil:$hasilKolomTerbesar;
    }
    return $hasil;
  }
  public function jarak_alternatif_positif($ideal_positif, $terbobot){ //### step 5 ###
    /*
    * Calculate the L2-distance between the target alternative i and the best condition 
    */
    for($baris = 0; $baris < count($terbobot);$baris++){
      $jumlahBaris = 0;
      for($kolom = 0; $kolom < count($terbobot[0]);$kolom++){
        $jumlahBaris += pow(($terbobot[$baris][$kolom]['nilai']-$ideal_positif[$kolom]['nilai']), 2);
      }
      $hasil[$baris]['nilai'] = sqrt($jumlahBaris);
      $hasil[$baris]['id_alternatif'] = $terbobot[$baris][0]['id_alternatif'];
    }
    return $hasil;
  }
  public function jarak_alternatif_negatif($ideal_negatif, $terbobot){ 
    /*
    * and the distance between the alternative {\displaystyle i} i and the worst condition
    */
    for($baris = 0; $baris < count($terbobot);$baris++){
      $jumlahBaris = 0;
      for($kolom = 0; $kolom < count($terbobot[0]);$kolom++){
        $jumlahBaris += pow(($terbobot[$baris][$kolom]['nilai']-$ideal_negatif[$kolom]['nilai']), 2);
      }
      $hasil[$baris]['nilai'] = sqrt($jumlahBaris);
      $hasil[$baris]['id_alternatif'] = $terbobot[$baris][0]['id_alternatif'];
    }
    return $hasil;
  }
  public function kedekatan_relative_terhadap_solusi_ideal($jarak_alternatif_negatif, $jarak_alternatif_positif){ //### step 6 ###
    /*
    * Calculate the similarity to the worst condition
    */
    for ($i=0; $i < count($jarak_alternatif_negatif); $i++) {
      $hasil[$i]['nilai'] = $jarak_alternatif_negatif[$i]['nilai']/($jarak_alternatif_negatif[$i]['nilai']+$jarak_alternatif_positif[$i]['nilai']);
      $hasil[$i]['id_alternatif'] = $jarak_alternatif_negatif[$i]['id_alternatif'];
    }
    $this->merangking_alternatif($hasil,"nilai");
    return $hasil;
  }
  public function merangking_alternatif(&$array, $key){ //### step 7 ###
    /*
    * then rank alternative
    */
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
      $sorter[$ii]=$va[$key];
    }
    arsort($sorter);
    foreach ($sorter as $ii => $va) {
      $ret[$ii]=$array[$ii];
    }
    $array=$ret;
  }
  public function tertinggi($arr){
    /*
    * then get highest rank
    */
    $hasil = reset($arr);
    return $hasil;
  }
}

$sifat = array('cost','benefit','benefit','benefit','benefit','benefit');
$kepentingan = array(4,5,4,3,3,2);
$matrix = array(
  array(
    array('nilai' => '3',
      'id_alternatif' => '1',
      'id_kriteria' => '1'),
    array('nilai' => '4',
      'id_alternatif' => '1',
      'id_kriteria' => '2'),
    array('nilai' => '2',
      'id_alternatif' => '1',
      'id_kriteria' => '3'),
    array('nilai' => '3',
      'id_alternatif' => '1',
      'id_kriteria' => '4'),
    array('nilai' => '3',
      'id_alternatif' => '1',
      'id_kriteria' => '5'),
  ),
  array(
    array('nilai' => '2',
      'id_alternatif' => '2',
      'id_kriteria' => '1'),
    array('nilai' => '5',
      'id_alternatif' => '2',
      'id_kriteria' => '2'),
    array('nilai' => '4',
      'id_alternatif' => '2',
      'id_kriteria' => '3'),
    array('nilai' => '1',
      'id_alternatif' => '2',
      'id_kriteria' => '4'),
    array('nilai' => '4',
      'id_alternatif' => '2',
      'id_kriteria' => '5'),
  ),
  array(
    array('nilai' => '4',
      'id_alternatif' => '3',
      'id_kriteria' => '1'),
    array('nilai' => '4',
      'id_alternatif' => '3',
      'id_kriteria' => '2'),
    array('nilai' => '5',
      'id_alternatif' => '3',
      'id_kriteria' => '3'),
    array('nilai' => '4',
      'id_alternatif' => '3',
      'id_kriteria' => '4'),
    array('nilai' => '3',
      'id_alternatif' => '3',
      'id_kriteria' => '5'),
  ),
);

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
$pembagi = $topsis->pembagi($matrix);
$ternomalisasi = $topsis->ternomalisasi($matrix, $pembagi);
$terbobot = $topsis->terbobot($ternomalisasi, $kepentingan);
$ideal_positif_negatif = $topsis->ideal_positif_negatif($terbobot, $sifat);
$jarak_alternatif_positif = $topsis->jarak_alternatif_positif($ideal_positif_negatif['positif'], $terbobot);
$jarak_alternatif_negatif = $topsis->jarak_alternatif_negatif($ideal_positif_negatif['negatif'], $terbobot);
$kedekatan_relative_terhadap_solusi_ideal = $topsis->kedekatan_relative_terhadap_solusi_ideal($jarak_alternatif_negatif, $jarak_alternatif_positif);
$tertinggi = $topsis->tertinggi($kedekatan_relative_terhadap_solusi_ideal);
/*echo 'Kepentingan <pre>';
var_dump($kepentingan);*/
/*echo 'Matrix <pre>';
var_dump($matrix);*/
/*echo 'Pembagi <pre>';
var_dump($pembagi);
echo '</pre><br><br>';*/

echo '$ternomalisasi <pre>';
var_dump($ternomalisasi);
echo '</pre>';
echo 'terbobot <pre>';
var_dump($terbobot);
echo '</pre><br><br>';
echo 'ideal positif negatif <pre>';
var_dump($ideal_positif_negatif);
echo '</pre>';
echo 'Jarak alternatif +<pre>';
var_dump($jarak_alternatif_positif);
echo '</pre><br><br>';
echo 'Jarak alternatif - <pre>';
var_dump($jarak_alternatif_negatif);
echo '</pre>';
echo '$kedekatan_relative_terhadap_solusi_ideal <pre>';
var_dump($kedekatan_relative_terhadap_solusi_ideal);
echo '</pre>';
echo 'Tertinggi <pre>';
var_dump($tertinggi);
echo '</pre>';

?>





</div>
</div>
</div>
</div>
</div>


</div>
</div>
</div>
