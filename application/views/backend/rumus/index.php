<?php
include 'algoritma_ahp.php';

$nilaiPerbandinganKriteria = array(
  [1,2,3,2,7],
  [0.5,1,2,3,3],
  [ 0.333,0.5,1,2,3],
  [0.5,0.333,0.5,1,2],
  [0.143,0.333,0.333,0.5,1],
);

$nilaiPerbandinganAlternatif = array(
  [3,4,2,3,3],
  [2,5,4,1,4],
  [4,4,5,4,3],
);


$vektor = vektorKriteria($nilaiPerbandinganKriteria);
$CR = CR($nilaiPerbandinganKriteria, $vektor);
$vektorAlternatif = vektorAlternatif($nilaiPerbandinganAlternatif);
$rangking = rangkingAlternatif($vektorAlternatif, $vektor);

$ahp = ahp($nilaiPerbandinganKriteria, $nilaiPerbandinganAlternatif);

echo '<pre>';
print_r($vektor);
echo '</pre>';