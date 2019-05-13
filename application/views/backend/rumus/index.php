<?php
include 'algoritma_ahp.php';

//Input
//3. Nilai Perbandingan Kriteria
$nilaiPerbandinganKriteria = array(
  [1,2,3,2,7],
  [0.5,1,2,3,3],
  [ 0.333,0.5,1,2,3],
  [0.5,0.333,0.5,1,2],
  [0.143,0.333,0.333,0.5,1],
);

//4. Nilai Perbandingan Alternatif setiap kriteria
$nilaiPerbandinganAlternatif = array(
  [3,4,2,3,3],
  [2,5,4,1,4],
  [4,4,5,4,3],
);

// Testing fungsi
//---------------------------------
//versi hitung"an


$vektor = vektorKriteria($nilaiPerbandinganKriteria);
$CR = CR($nilaiPerbandinganKriteria, $vektor);
$vektorAlternatif = vektorAlternatif($nilaiPerbandinganAlternatif);
$rangking = rangkingAlternatif($vektorAlternatif, $vektor);

//versi simple
$ahp = ahp($nilaiPerbandinganKriteria, $nilaiPerbandinganAlternatif);

echo '<pre>';
print_r($vektor);
echo '</pre>';