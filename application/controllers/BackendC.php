<?php

class BackendC extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('Mymod');
	}

	public function index()
	{
		$y['title']='Dashboard';

		$this->data['kriteria']     = $this->db->query("select * from kriteria order by kriteria_kode asc");
		$this->data['alternatif']     = $this->db->query("select * from alternatif order by alternatif_kode asc");
		$this->data['bobot'] = array(
			1 => '1',
			2 => '2',
			3 => '3',
			4 => '4',
			5 => '5',
			6 => '5',
			7 => '7',
			8 => '8',
			9 => '9',
		);


		if(isset($_POST['save_perbandingan'])){
			$jumlah_kriteria = 5;
			$array1 = array();
			$k = 0;
			$l = 0;
			for($i=0;$i<$jumlah_kriteria;$i++)
			{
				for($j=$k;$j<$jumlah_kriteria;$j++)
				{
					if($i==$j)
					{
						$array1[$i][$j] = 1;
					}
					else
					{
						$array1[$i][$j] = $this->input->post('bobot'.$l);
						$array1[$j][$i] = round(1/$array1[$i][$j],3);
						$l++;				
					}
				}
				$k++;
			}

			$this->data['ksd'] = $array1;

		}
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/index',$this->data);
		$this->load->view('backend/layout/footer');
	}
	public function proses()
	{


		$jumlah_kriteria = 5;
		$array1 = array();
		$k = 0;
		$l = 0;
		for($i=0;$i<$jumlah_kriteria;$i++)
		{
			for($j=$k;$j<$jumlah_kriteria;$j++)
			{
				if($i==$j)
				{
					$array1[$i][$j] = 1;
				}
				else
				{
					$array1[$i][$j] = $this->input->post('bobot'.$l);
					$array1[$j][$i] = round(1/$array1[$i][$j],3);
					$l++;				
				}
			}
			$k++;
		}

		$x = array(                   
			array(3,4,2,3,3),               
			array(2,5,4,1,4),                                    
			array(4,4,5,4,3),                                                   
		);

		$k = $array1;

		$jk = array();
		for ($ix=0;$ix<$jumlah_kriteria;$ix++)
		{
			$jk[$ix]=0;
			for ($jx=0;$jx<$jumlah_kriteria;$jx++)
			{     
				$jk[$ix] += $k[$jx][$ix];
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

		echo "<pre>".var_dump($ci)."</pre>";

		print_r($jk);


		/*		echo '<pre>' , var_dump($array1) , '</pre>';*/
		exit();
			//menampilkan semua elemen array
		for($p=0;$p<$jumlah_kriteria;$p++)
		{
			for($q=0;$q<$jumlah_kriteria;$q++)
			{
				echo '['.$p.']['.$q.'] = '.$array1[$p][$q];
				echo '<br />';
			}
		}
			//mencari jumlah setiap baris matriks perbandingan berpasangan
		$jumlah_per_baris = array();
		$jumlah_per_cell = 0;
		for($y=0;$y<$jumlah_kriteria;$y++)
		{
			for($z=0;$z<$jumlah_kriteria;$z++)
			{
				$jumlah_per_cell = $jumlah_per_cell + $array1[$y][$z];
			}
			$jumlah_per_baris[$y] = $jumlah_per_cell;
			$jumlah_per_cell = 0;
				//echo 'jumlah baris ['.$y.'] = '.$jumlah_per_baris[$y];
				//echo '<br />';
		}
			//matriks nilai kriteria
		$array2 = array();
		for($m=0;$m<$jumlah_kriteria;$m++)
		{
			for($n=0;$n<$jumlah_kriteria;$n++)
			{				
				$array2[$m][$n] = round($array1[$m][$n]/$jumlah_per_baris[$m],2);
					//echo '['.$m.']['.$n.'] = '.$array2[$m][$n];
					//echo '<br />';
			}
		}
			//print jumlah per baris matriks nilai kriteria
		$jumlah_per_baris2 = array();
		$jumlah_per_cell2 = 0;
		$prioritas = array();
		for($o=0;$o<$jumlah_kriteria;$o++)
		{
			for($p=0;$p<$jumlah_kriteria;$p++)
			{				
				$jumlah_per_cell2 = $jumlah_per_cell2 + $array2[$p][$o];
			}
			$jumlah_per_baris2[$o] = $jumlah_per_cell2;
			$prioritas[$o] = round($jumlah_per_cell2/$jumlah_kriteria, 2);
				//menyimpan nilai prioritas ke database tabel kriteria
			$data = array('PRIORITAS_KRITERIA' => $prioritas[$o]);
			/*$this->kriteria_model->update($this->input->post($o), $data);*/

			$jumlah_per_cell2 = 0;
				//echo 'jumlah baris 2 ['.$o.'] = '.$jumlah_per_baris2[$o];
				//echo '<br />';
				//echo 'prioritas ['.$o.'] = '.$prioritas[$o];
				//echo '<br />';
		}
			//matriks penjumlahan setiap baris
		$array3 = array();
		for($r=0;$r<$jumlah_kriteria;$r++)
		{
			for($s=0;$s<$jumlah_kriteria;$s++)
			{				
				$array3[$s][$r] = round($array1[$s][$r]*$prioritas[$r],2);
					//echo '['.$r.']['.$s.'] = '.$array3[$r][$s];
					//echo '<br />';
			}
		}
			//print matriks penjumlahan setiap baris
		$jumlah_per_baris3 = array();
		$hasil = array();
		$jumlah_per_cell3 = 0;
		$jumlah = 0;
		for($t=0;$t<$jumlah_kriteria;$t++)
		{
			for($u=0;$u<$jumlah_kriteria;$u++)
			{	
				$jumlah_per_cell3 = $jumlah_per_cell3 + $array3[$u][$t];			
					//echo '['.$t.']['.$u.'] = '.$array3[$t][$u];
					//echo '<br />';
			}
			$jumlah_per_baris3[$t] = $jumlah_per_cell3;
			$hasil[$t] = $jumlah_per_baris3[$t] + $prioritas[$t];
			$jumlah = $jumlah + $hasil[$t];
			$jumlah_per_cell3 = 0;
				//echo 'jumlah baris 3 ['.$t.'] = '.$jumlah_per_baris3[$t];
				//echo '<br />';
				//echo 'hasil ['.$t.'] => '.$jumlah_per_baris3[$t].'+'.$prioritas[$t].' = '.$hasil[$t];
				//echo '<br />';
		}
		$nilai_IR[1] = 0.00;
		$nilai_IR[2] = 0.00;
		$nilai_IR[3] = 0.58;
		$nilai_IR[4] = 0.90;
		$nilai_IR[5] = 1.12;
		$nilai_IR[6] = 1.24;
		$nilai_IR[7] = 1.32;
		$nilai_IR[8] = 1.41;
		$nilai_IR[9] = 1.45;
		$nilai_IR[10] = 1.49;
		$nilai_IR[11] = 1.51;
		$nilai_IR[12] = 1.48;
		$nilai_IR[13] = 1.56;
		$nilai_IR[14] = 1.57;
		$nilai_IR[15] = 1.59;
		$alpha_max = $jumlah/$jumlah_kriteria;
		$consistency_index = ($alpha_max - $jumlah_kriteria)/$jumlah_kriteria;

		print_r($consistency_index);
		exit();
	}


}