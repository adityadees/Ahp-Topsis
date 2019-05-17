<?php 

class User_m extends MY_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->data['table_name']   = 'user';
        $this->data['primary_key']  = 'user_id';
    }
}