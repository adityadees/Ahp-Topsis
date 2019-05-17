<?php
defined('BASEPATH') OR exit('No direct script allowed');
class User extends MY_Controller{

	function __construct(){
		parent::__construct();
		if(!isset($_SESSION['logged_in'])){
			$url=base_url('loginadmin');
			redirect($url);
		};
		$this->load->model('user_m');
	}

	public function index(){
		$this->data['user_grab'] = $this->user_m->get();
		$y['title'] = 'User';
		$this->load->view('backend/layout/header',$y);
		$this->load->view('backend/layout/topbar');
		$this->load->view('backend/layout/sidebar');
		$this->load->view('backend/user/user',$this->data);
		$this->load->view('backend/layout/footer');
	}

	public function edit(){

		if(isset($_POST['edit_user'])){
			$user_id = $this->post('user_id');
			$username = $this->post('username');
			$nama = $this->post('nama');
			$password = $this->post('password');
			$repassword = $this->post('repassword');
			$email = $this->post('email');
			$jk = $this->post('jk');
			$tel = $this->post('tel');
			$role = $this->post('role');
			$alamat = $this->post('alamat');

			$this->db->trans_start();
			$update = $this->user_m->update($user_id,['user_username' => $username,'user_nama'=>$nama,'user_email'=>$email,'user_alamat'=>$alamat,'user_jk'=>$jk,'user_tel'=>$tel,'user_role'=>$role]);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal merubah data', 'danger');
				redirect('user');
			} else {
				$this->flashmsg('Sukses merubah data', 'success');
				redirect('user');
			}
		} 

	}

	public function create(){

		if(isset($_POST['save_user'])){
			$username = $this->post('username');
			$nama = $this->post('nama');
			$password = $this->post('password');
			$repassword = $this->post('repassword');
			$email = $this->post('email');
			$jk = $this->post('jk');
			$tel = $this->post('tel');
			$role = $this->post('role');
			$alamat = $this->post('alamat');

			
			$cekuname=$this->user_m->get(['user_username' => $username]);

			if(count($cekuname)==1){
				$this->session->flashmsg('Username telah dipakai, silahkan ulangi lagi', 'error');
				redirect('user');	
			}else{
				if($password==$repassword){

					if($jk=='on'){
						$jk='L';
					}else {
						$jk='P';
					}


					$this->db->trans_start();
					$insert = $this->user_m->insert(['user_username' => $username,'user_password' => md5($password), 'user_nama'=>$nama,
						'user_email'=>$email,
						'user_alamat'=>$alamat,
						'user_jk'=>$jk,
						'user_tel'=>$tel,
						'user_role'=>$role]);
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->flashmsg('Gagal menambah data', 'danger');
						redirect('user');
					} else {
						$this->flashmsg('Sukses menambah data', 'success');
						redirect('user');
					}
				}else {
					$this->session->flashmsg('Password tidak sama, silahkan diulangi lagi', 'error');
					redirect('user');		
				}
			}
		} 

	}

	public function delete(){

		if(isset($_POST['delete_user'])){
			$user_id = $this->post('user_id');

			$this->db->trans_start();
			$delete = $this->user_m->delete($user_id);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->flashmsg('Gagal menghapus data', 'danger');
				redirect('user');
			} else {
				$this->flashmsg('Sukses menghapus data', 'success');
				redirect('user');
			}
		} 

	}

}
?>