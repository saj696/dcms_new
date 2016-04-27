<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services_report_list_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_services()
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_services'));
        $CI->db->select(['service_id','service_name']);
        $CI->db->where('status',1);

        $result=$CI->db->get()->result_array();

        /*echo "<pre>";
        print_r($result);
        echo "</pre>";
        die;*/
        return $result;
    }
}