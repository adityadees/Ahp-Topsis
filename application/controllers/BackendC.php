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
		$this->load->model('hasil_rank_m');
		$this->load->model('Mymod');
		$this->load->library('Ahp');
		$this->load->library('Topsis');
	}

	public function index()
	{
		$y['title']='Dashboard';

		$this->data['kriteria']     = $this->kriteria_m->get_by_order('kriteria_kode','asc');
		$this->data['hasil_rank']     = $this->hasil_rank_m->get_by_order('hr_value','desc');
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
			$this->data['row_total'] = $this->ahp->get_row_total($array1);
			$this->data['normal'] = $this->ahp->normalize($array1, $this->data['row_total']);
			$this->data['priority'] = $this->ahp->get_priority($this->data['normal']);
			$this->data['sumnor'] = $this->ahp->get_jumlah_normalisasi($this->data['normal']);
			$this->data['cm'] = $this->ahp->get_cm($array1, $this->data['priority']);
			$this->data['consistency'] = $this->ahp->get_consistency($this->data['cm']);


			$this->data['baseKriteria'] = $this->topsis->baseKriteria($this->data['kriteria']);
			$this->data['baseAlternatif'] = $this->topsis->baseAlternatif($this->data['alternatif']);
			$this->data['baseALterKD'] = $this->topsis->baseALterKD($this->data['alternatif']);
			$this->data['nilaiAlkrit'] = $this->topsis->nilaiAlkrit($this->data['alternatif'],$this->data['kriteria'],$this->data['nilai']);
			$this->data['pembagi'] = $this->topsis->pembagi($this->data['baseAlternatif'],$this->data['baseKriteria'],$this->data['nilaiAlkrit']);
			$this->data['normalisasi'] = $this->topsis->normalisasi($this->data['baseAlternatif'],$this->data['baseKriteria'],$this->data['nilaiAlkrit'],$this->data['pembagi']);
			$this->data['terbobot'] = $this->topsis->terbobot($this->data['baseAlternatif'],$this->data['baseKriteria'],$this->data['normalisasi'],$this->data['priority']);
			$this->data['aplus'] = $this->topsis->aplus($this->data['baseKriteria'],$this->data['baseAlternatif'],$this->data['terbobot']);
			$this->data['amin'] = $this->topsis->amin($this->data['baseKriteria'],$this->data['baseAlternatif'],$this->data['terbobot']);
			$this->data['dplus'] = $this->topsis->dplus($this->data['baseAlternatif'],$this->data['baseKriteria'],$this->data['terbobot'],$this->data['aplus']);
			$this->data['dmin'] = $this->topsis->dmin($this->data['baseAlternatif'],$this->data['baseKriteria'],$this->data['terbobot'],$this->data['amin']);
			$this->data['hasil'] = $this->topsis->hasil($this->data['dmin'],$this->data['dplus'],$this->data['baseALterKD']);


			for($i=0;$i<count(($this->data['hasil']['alterKD']));$i++){
				$cek = $this->hasil_rank_m->get()[$i];
				if (!isset($cek)) {
					$insertAk = $this->hasil_rank_m->insert(['alternatif_kode' => $this->data['hasil']['alterKD'][$i]]);
				} else {
					$updateAk = $this->hasil_rank_m->update($cek->hr_id,['alternatif_kode' => $this->data['hasil']['alterKD'][$i]]);
				}
			}

			$arrs = [];
			for($j=0;$j<count(($this->data['hasil']['hasil']));$j++){
				$cek = $this->hasil_rank_m->get()[$j];
				$arrs[] = [
					'id' => $cek->hr_id,
					'alter' => $cek->alternatif_kode,
					'vals' => $this->data['hasil']['hasil'][$j],
				];
			}

			foreach ($arrs as $key => $value) {
				$updateAk = $this->hasil_rank_m->update($value['id'],['hr_value' => $value['vals']]);
			}

		}


		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/index',$this->data);
		$this->load->view('backend/layout/footer');
	}
}