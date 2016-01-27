<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }


    public function get_list()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_api_services'));
        $CI->db->select('*');
        $CI->db->where('status =',1);

        $results=$CI->db->get()->result_array();

        foreach($results as & $result)
        {
            $result['edit_link']=$CI->get_encoded_url('basic_setup/services/index/edit/'.$result['id']);
            if($result['status']==1)
            {
                $result['status_text']="Active";
            }else
            {
                $result['status_text']="In-Active";
            }

            if($result['service_logo'])
            {
                $result['service_logo']="Yes";
            }else
            {
                $result['service_logo']="No";
            }
        }

        return $results;
    }


}