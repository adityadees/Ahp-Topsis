<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Subkriteria extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('sub_kriteria_m');
		$this->load->model('kriteria_m');
	}

	public function index(){
		$this->data['kriteria_grab'] = $this->kriteria_m->get();
		$this->data['sub_kriteria_grab'] = $this->sub_kriteria_m->get();
		$y['title'] = 'Sub Kriteria';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/kriteria/sub_kriteria',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_subkriteria'])){
			$sk_id = $this->post('id');
			$kriteria_kode = $this->post('kriteria');
			$sk_nama = $this->post('nama');

			$this->db->trans_start();
			$update = $this->sub_kriteria_m->update($sk_id,['kriteria_kode' => $kriteria_kode,'sk_nama' => $sk_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('subkriteria');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('subkriteria');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_subkriteria'])){
			$sk_id = $this->post('id');
			$kriteria_kode = $this->post('kriteria');
			$sk_nama = $this->post('nama');

			$this->db->trans_start();
			$insert = $this->sub_kriteria_m->insert(['sk_id' => $sk_id,'kriteria_kode' => $kriteria_kode, 'sk_nama' => $sk_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menambah data', 'danger');
				redirect('subkriteria');
			} else {
				$this->flashmsg('Sukses menambah data', 'success');
				redirect('subkriteria');
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_subkriteria'])){
			$sk_id = $this->post('kode');

			$this->db->trans_start();
			$delete = $this->sub_kriteria_m->delete($sk_id);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('subkriteria');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('subkriteria');
			}
		} 

	}

}
?>