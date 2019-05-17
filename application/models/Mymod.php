<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymod extends CI_Model{

    public function cekadminlogin($user_username,$user_password){
        $res=$this->db->query("SELECT * FROM user WHERE user_username='$user_username' AND user_password=md5('$user_password')");
        return $res;
    }

    public function CekDataRows($table,$where){
        $res=$this->db->get_where($table,$where);
        return $res;
    }

}
