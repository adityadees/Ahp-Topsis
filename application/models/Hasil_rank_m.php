<?php 

class Hasil_rank_m extends MY_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->data['table_name']   = 'hasil_rank';
        $this->data['primary_key']  = 'hr_id';
    }
}