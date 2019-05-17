<?php 

class Parameter_m extends MY_Model 
{
    public function __construct()
    {
        parent::__construct();
        $this->data['table_name']   = 'parameter';
        $this->data['primary_key']  = 'parameter_id';
    }
}