 <?php

 class Topsis{ 

   public function baseKriteria($qKriteria){
     $arKriteria = [];
     $i=0;
     foreach ($qKriteria  as $vKriteria):
       $arKriteria[$i] = $vKriteria->kriteria_nama;
       $i++;
     endforeach;
     return $arKriteria;
   }

   public function baseAlternatif($qAlternatif){
    $arAlternatif = [];
    $i=0;
    foreach ($qAlternatif  as $vAlternatif):
      $arAlternatif[$i] = $vAlternatif->alternatif_nama;
      $i++;
    endforeach;
    return $arAlternatif;
  }
  public function baseALterKD($qAlternatif){
    $arAlterKD = [];
    $arAlterNM = [];
    $i=0;
    foreach ($qAlternatif  as $vAlternatif):
      $arAlterKD[$i] = $vAlternatif->alternatif_kode;
      $arAlterNM[$i] = $vAlternatif->alternatif_nama;
      $i++;
    endforeach;
    return [
      'alter_kd' => $arAlterKD,
      'alter_nm' => $arAlterNM,
    ];
  }


  public function nilaiAlkrit($qAlternatif,$qKriteria,$qnilai){
    $arNAK = [];
    foreach ($qAlternatif  as $i => $vAlternatif) :
      $vAlternatif1=$vAlternatif->alternatif_kode;
      foreach ($qKriteria  as $j => $vKriteria) :
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


  public function hasil($dmin,$dplus,$baseALterKD){

    $hasil = array();

    for ($i=0;$i<count($baseALterKD['alter_kd']);$i++)
    {
      $hasil[$i] = round($dmin[$i] / ($dmin[$i] + $dplus[$i]),3);
    } 

    $alterRank = array();
    $hasilrangking = array();

    for ($i=0;$i<count($baseALterKD['alter_kd']);$i++)
    {
      $hasilrangking[$i] = $hasil[$i];
      $alterRank[$i] = $baseALterKD['alter_nm'][$i];
      $alterKD[$i] = $baseALterKD['alter_kd'][$i];
    }

    for ($i=0;$i<count($baseALterKD['alter_kd']);$i++)
    {
      for ($j=$i;$j<count($baseALterKD['alter_kd']);$j++)
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
      'alterKD' => $alterKD,
      'hasilrangking' => $hasilrangking,
    ];
  }
}
