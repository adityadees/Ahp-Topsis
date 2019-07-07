<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Laporan extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('hasil_rank_m');
	}

	public function index(){
		if($_SESSION['user_role'] == 'supervisor') :
			$this->data['hasil_report']     = $this->db->query("SELECT * from hasil_rank INNER JOIN alternatif on hasil_rank.alternatif_kode=alternatif.alternatif_kode order by hasil_rank.hr_value desc")->result();
		endif;
		$y['title'] = 'Laporan';
		$this->load->view('backend/laporan/cetak',$this->data);
	}


}
?>