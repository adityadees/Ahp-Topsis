<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Parameter extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('parameter_m');
		$this->load->model('kriteria_m');
	}

	public function index(){
		$this->data['kriteria_grab'] = $this->kriteria_m->get();
		$this->data['parameter_grab'] = $this->parameter_m->get();
		$y['title'] = 'Parameter';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/penilaian/parameter',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_parameter'])){
			$parameter_id = $this->post('id');
			$kriteria_kode = $this->post('kriteria');
			$parameter_ukuran = $this->post('ukuran');
			$parameter_nilai = $this->post('nilai');

			$this->db->trans_start();
			$update = $this->parameter_m->update($parameter_id,['kriteria_kode' => $kriteria_kode,'parameter_ukuran' => $parameter_ukuran, 'parameter_nilai'=>$parameter_nilai]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('parameter');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('parameter');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_parameter'])){
			$kriteria_kode = $this->post('kriteria');
			$parameter_ukuran = $this->post('ukuran');
			$parameter_nilai = $this->post('nilai');

			$this->db->trans_start();
			$insert = $this->parameter_m->insert(['kriteria_kode' => $kriteria_kode, 'parameter_ukuran' => $parameter_ukuran, 'parameter_nilai' => $parameter_nilai]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menambah data', 'danger');
				redirect('parameter');
			} else {
				$this->flashmsg('Sukses menambah data', 'success');
				redirect('parameter');
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_parameter'])){
			$parameter_id = $this->post('kode');

			$this->db->trans_start();
			$delete = $this->parameter_m->delete($parameter_id);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('parameter');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('parameter');
			}
		} 

	}

}
?>