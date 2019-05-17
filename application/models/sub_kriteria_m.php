<?php 

class Sub_kriteria_m extends MY_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->data['table_name']   = 'sub_kriteria';
        $this->data['primary_key']  = 'sk_id';
    }
}