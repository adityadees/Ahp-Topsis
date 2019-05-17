<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Nilai extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('nilai_m');
		$this->load->model('alternatif_m');
		$this->load->model('parameter_m');
		$this->load->model('kriteria_m');
	}

	public function index(){
		$this->data['alternatif_grab'] = $this->alternatif_m->get();
		$this->data['parameter_grab'] = $this->parameter_m->get();
		$this->data['kriteria_grab'] = $this->kriteria_m->get();
		$this->data['nilai_grab'] = $this->nilai_m->get();
		$y['title'] = 'Nilai';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/penilaian/nilai',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_nilai'])){
			$nilai_id = $this->post('id');
			$alternatif = $this->post('alternatif');
			$parameter = $this->post('parameter');

			$this->db->trans_start();
			$update = $this->nilai_m->update($nilai_id,['alternatif_kode' => $alternatif,'parameter_id' => $parameter]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('nilai');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('nilai');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_nilai'])){
			$alternatif = $this->post('alternatif');
			$parameter = $this->post('parameter');

			$this->db->trans_start();
			$insert = $this->nilai_m->insert(['alternatif_kode' => $alternatif, 'parameter_id' => $parameter]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menambah data', 'danger');
				redirect('nilai');
			} else {
				$this->flashmsg('Sukses menambah data', 'success');
				redirect('nilai');
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_nilai'])){
			$nilai_id = $this->post('kode');

			$this->db->trans_start();
			$delete = $this->nilai_m->delete($nilai_id);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('nilai');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('nilai');
			}
		} 

	}

}
?>