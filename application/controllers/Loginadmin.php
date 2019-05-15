<?php
class Loginadmin extends CI_Controller{
    function __construct(){
        parent:: __construct();
        $this->load->model('Mymod');
    }
   public function index(){
        $this->load->view('backend/login');
    }
    public function auth(){
        $user_username=strip_tags(str_replace("'", "", $this->input->post('user_username',TRUE)));
        $user_password=strip_tags(str_replace("'", "", $this->input->post('user_password',TRUE)));

        $cekuser = $this->Mymod->CekDataRows('user',['user_username' => $user_username, 'user_role' => 'admin'])->num_rows();
        if($cekuser==0){
            $this->session->set_flashdata('error', 'Username atau password anda salah');
            redirect('loginadmin');
        } else {

            $cadmin=$this->Mymod->cekadminlogin($user_username,$user_password);
            if($cadmin->num_rows() > 0){
                $xcadmin=$cadmin->row_array();
                $newdata = array(
                    'user_username'   => $xcadmin['user_username'],
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($newdata);
                redirect(); 
            }else{
                $this->session->set_flashdata('success', 'Username atau password anda salah');
                redirect('loginadmin'); 
            }
        }

    }


    public function gagallogin(){
        $this->session->set_flashdata('error', 'Username atau password anda salah');
        redirect('loginadmin');
    }

    public function logout(){
        $this->session->sess_destroy();
        $url=base_url();
        redirect($url);
    }
}