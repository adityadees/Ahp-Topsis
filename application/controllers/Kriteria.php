<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Kriteria extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('kriteria_m');
	}

	public function index(){
		$this->data['kriteria_grab'] = $this->kriteria_m->get();
		$y['title'] = 'Kriteria';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/kriteria/kriteria',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_kriteria'])){
			$kriteria_kode = $this->post('id');
			$kriteria_nama = $this->post('nama');

			$this->db->trans_start();
			$update = $this->kriteria_m->update($kriteria_kode,['kriteria_nama' => $kriteria_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('kriteria');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('kriteria');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_kriteria'])){
			$kriteria_kode = $this->post('kode');
			$kriteria_nama = $this->post('nama');

			$this->db->trans_start();
			$insert = $this->kriteria_m->insert(['kriteria_kode' => $kriteria_kode, 'kriteria_nama' => $kriteria_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menambah data', 'danger');
				redirect('kriteria');
			} else {
				$this->flashmsg('Sukses menambah data', 'success');
				redirect('kriteria');
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_kriteria'])){
			$kriteria_kode = $this->post('kode');

			$this->db->trans_start();
			$delete = $this->kriteria_m->delete($kriteria_kode);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('kriteria');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('kriteria');
			}
		} 

	}

}
?>