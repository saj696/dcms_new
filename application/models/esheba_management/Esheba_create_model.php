<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Esheba_create_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_record_list()
    {
        $CI =& get_instance();
        $this->db->select('service_id id, service_name, service_type, service_amount, status');
        $this->db->from($CI->config->item('table_services'));
        $this->db->where('status', $this->config->item('STATUS_ACTIVE'));
        $users = $this->db->get()->result_array();
        $service_type=$this->config->item('service_type');
        foreach($users as &$user)
        {
            $user['edit_link']=$CI->get_encoded_url('esheba_management/Esheba_create/index/edit/'.$user['id']);
            if($user['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $user['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($user['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $user['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $user['status_text']=$user['status'];
            }

            if($user['service_type']==1)
            {
                $user['service_type_text']=$service_type[1];
            }
            else if($user['service_type']==2)
            {
                $user['service_type_text']=$service_type[2];
            }
            else if($user['service_type']==3)
            {
                $user['service_type_text']=$service_type[3];
            }
            else
            {
                $user['service_type_text']='';//$user['service_type'];
            }
            //$user['service_type_text']=$user['service_type'];
        }
        return $users;
    }

    public function check_existence($value,$id, $field_name)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_services'));
        $CI->db->where($field_name,$value);
        if($id>0)
        {
            $CI->db->where('service_id !=',$id);
        }

        $result = $CI->db->get()->row_array();
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_esheba_status($id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_invoice_details'));
        if($id>0)
        {
            $CI->db->where('service_id',$id);
        }
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        //$result = $CI->db->get()->row_array();
        if($rowcount>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}