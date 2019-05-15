  <?php 
                  $cb = array("-", "+", "+", "+", "+", "+");  
                  $x = array(                   

                    array(3,4,2,3,3),               
                    array(2,5,4,1,4),                                    
                    array(4,4,5,4,3),                                                   
                  );
                  $k = array(               
                    [1,2,3,2,7],
                    [0.5,1,2,3,3],
                    [0.333,0.5,1,2,3],
                    [0.5,0.333,0.5,1,2],
                    [0.143,0.333,0.333,0.5,1],
                  );

                  $jk = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $jk[$i]=0;
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $jk[$i] += $k[$j][$i];
                    }
                  }

                  $nk = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $nk[$i][$j] = $k[$i][$j] / $jk[$j];
                    }
                  }



                  $jnk = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $jnk[$i] = 0;
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $jnk[$i] += $nk[$i][$j]; 
                    }
                  }

                  $w = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $w[$i] = $jnk[$i] / count($x[0]); 
                  }



                  $kw = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $kw[$i] = 0;
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $kw[$i] += $k[$i][$j] * $w[$j]; 
                    }
                  }



                  $t=0;
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $t += $kw[$i] / $w[$i]; 
                  }
                  $t = $t / count($x[0]);
                  $ci = ($t - count($x[0])) / (count($x[0]) - 1);
                  if (count($x[0]) == 3)
                  {
                    $ri = 0.58;
                  }
                  else if (count($x[0]) == 4)
                  {
                    $ri = 0.9;
                  }
                  else if (count($x[0]) == 5)
                  {
                    $ri = 1.12;
                  }
                  else if (count($x[0]) == 6)
                  {
                    $ri = 1.24;
                  }
                  else if (count($x[0]) <= 2)
                  {
                    $ri = 0.01;
                  }
                  else 
                  {
                    $ri = 1.32;
                  } 
                  $cr = $ci / $ri;

                  //  echo "<pre>".var_dump($ci)."</pre>";



                  $nmin = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $nmin[$i] = 1000000;

                    if ($cb[$i] == "-")
                    {
                      for ($j=0;$j<count($x);$j++)
                      { 
                        if ($nmin[$i] > $x[$j][$i])
                        {
                          $nmin[$i] = $x[$j][$i];
                        }   
                      }
                    }
                    else
                    {
                      $nmin[$i] = -1000000;

                      for ($j=0;$j<count($x);$j++)
                      { 
                        if ($nmin[$i] < $x[$j][$i])
                        {
                          $nmin[$i] = $x[$j][$i];
                        }
                      }
                    }
                  }
                  $mnkr = array();
                  for ($i=0;$i<count($x);$i++)
                  {
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      if ($cb[$j] == "-")
                      {
                        $mnkr[$i][$j] = $nmin[$j] / $x[$i][$j]; 
                      }
                      else
                      {
                        $mnkr[$i][$j] = $x[$i][$j] / $nmin[$j]; 
                      }
                    }
                  }
                  $jmn = array();
                  for ($i=0;$i<count($x[0]);$i++)
                  {
                    $jmn[$i] = 0;
                    for ($j=0;$j<count($x);$j++)
                    {     
                      $jmn[$i] = $jmn[$i] + $mnkr[$j][$i];
                    }
                  }
                  $nrmn = array();
                  for ($i=0;$i<count($x);$i++)
                  {
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $nrmn[$i][$j] = $mnkr[$i][$j] / $jmn[$j]; 
                    }
                  }
                  $hsl = array();
                  for ($i=0;$i<count($x);$i++)
                  {
                    $hsl[$i] = 0;
                    for ($j=0;$j<count($x[0]);$j++)
                    {     
                      $hsl[$i] += $nrmn[$i][$j] * $w[$j]; 
                    }
                      //echo $hsl[$i]."<br/>";
                  }
                  ?>