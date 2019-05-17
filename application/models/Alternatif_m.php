<?php 

class Alternatif_m extends MY_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->data['table_name']   = 'alternatif';
        $this->data['primary_key']  = 'alternatif_kode';
    }
}