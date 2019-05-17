<?php

class BackendC extends CI_Controller{
	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('kriteria_m');
		$this->load->model('alternatif_m');
		$this->load->model('nilai_m');
		$this->load->model('Mymod');
	}

	public function index()
	{
		$y['title']='Dashboard';

		$this->data['kriteria']     = $this->kriteria_m->get_by_order('kriteria_kode','asc');
		$this->data['alternatif']     = $this->alternatif_m->get_by_order('alternatif_kode','asc');
		$this->data['nilai']     = $this->nilai_m->getDataJoin(['parameter'],['nilai.parameter_id = parameter.parameter_id']);

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
}