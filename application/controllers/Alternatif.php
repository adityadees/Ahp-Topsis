<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Alternatif extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('alternatif_m');
	}

	public function index(){
		$this->data['alternatif_grab'] = $this->alternatif_m->get();
		$y['title'] = 'Alternatif';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/alternatif/alternatif',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_alternatif'])){
			$alternatif_kode = $this->post('id');
			$alternatif_nama = $this->post('nama');

			$this->db->trans_start();
			$update = $this->alternatif_m->update($alternatif_kode,['alternatif_nama' => $alternatif_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('alternatif');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('alternatif');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_alternatif'])){
			$alternatif_kode = $this->post('kode');
			$alternatif_nama = $this->post('nama');

			$this->db->trans_start();
			$insert = $this->alternatif_m->insert(['alternatif_kode' => $alternatif_kode, 'alternatif_nama' => $alternatif_nama]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menambah data', 'danger');
				redirect('alternatif');
			} else {
				$this->flashmsg('Sukses menambah data', 'success');
				redirect('alternatif');
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_alternatif'])){
			$alternatif_kode = $this->post('kode');

			$this->db->trans_start();
			$delete = $this->alternatif_m->delete($alternatif_kode);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('alternatif');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('alternatif');
			}
		} 

	}

}
?>