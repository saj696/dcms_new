<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice_create_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_user_groups()
    {
        $user = User_helper::get_user();
        $user_group_level = $user->user_group_level;
        $CI =& get_instance();
        $this->db->from($CI->config->item('table_user_group').' group');
        //$this->db->where('id >= '.$CI->config->item('user_level_min'));
        $this->db->where('id <= '.$CI->config->item('user_level_max'));
        $this->db->where('level > '.$user_group_level);
        $results=$this->db->get()->result_array();

        $levels=array();
        foreach($results as $result)
        {
            $levels[$result['id']]=$result['name_bn'];
        }

        $this->db->from($CI->config->item('table_user_group').' group');
        $this->db->select('group.id,group.ordering,group.status, group.level');
        $this->db->select('group.name_'.$CI->get_language_code().' name');
        $this->db->where('group.level > '.$user_group_level);
        $this->db->where('group.id >= '.$CI->config->item('user_level_min'));
        $this->db->where('group.id <= '.$CI->config->item('user_level_max'));
        $this->db->order_by('group.ordering ASC');
        $this->db->where('status != 99');
        $groups=$this->db->get()->result_array();

        foreach($groups as &$group)
        {
            $group['level']=$levels[$group['level']];
        }
        return $groups;
    }

    public function get_record_list()
    {
        $user=User_helper::get_user();
        $CI =& get_instance();
        $this->db->select('notice_infos.id,
                            notice_infos.notice_title,
                            notice_infos.notice_details,
                            notice_infos.upload_file,
                            notice_infos.`status`,
                            notice_infos.create_by');
        $this->db->from($CI->config->item('table_notice')." notice_infos");
        //$this->db->where('status', $this->config->item('STATUS_ACTIVE'));
        $this->db->where('create_by', $user->id);
        $notices = $this->db->get()->result_array();
        foreach($notices as &$notice)
        {
            $notice['edit_link']=$CI->get_encoded_url('notice_management/notice_create/index/edit/'.$notice['id']);
            if($notice['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $notice['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($notice['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $notice['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $notice['status_text']=$notice['status'];
            }

            if(!empty($notice['upload_file']))
            {
                $notice['upload_status']=$CI->lang->line('FILE_UPLOADED');
            }
            else
            {
                $notice['upload_status']=$CI->lang->line('FILE_NOT_UPLOADED');
            }
        }
        return $notices;
    }

    public function get_notice_detail($id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_notice').' notice');
        $CI->db->where('notice.id',$id);
        $result = $this->db->get()->row_array();

        if(is_array($result) && sizeof($result)>0)
        {
            $CI =& get_instance();
            $CI->db->from($CI->config->item('table_notice_view').' notice_view');
            $CI->db->where('notice_view.notice_id',$id);
            $CI->db->where('notice_view.status !='. $this->config->item('STATUS_DELETE'));
            $detail = $this->db->get()->result_array();
            $result['detail'] = $detail;
        }
        return $result;
    }

    public function get_sub_groups($user_level)
    {
        $CI =& get_instance();
        $this->db->from($CI->config->item('table_user_group').' group');
        $this->db->select('group.id,group.ordering,group.status, group.level');
        $this->db->select('group.name_'.$CI->get_language_code().' name');
        $this->db->where('group.id != '.$user_level);
        $this->db->where('group.level', $user_level);
        $this->db->order_by('group.ordering ASC');
        $this->db->where('status != 99');
        $groups = $this->db->get()->result_array();
        return $groups;
    }

    public function get_child_parent($child)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_user_group').' user_group');
        $CI->db->select('user_group.level, user_group.id');
        $CI->db->where('user_group.id',$child);
        $result = $CI->db->get()->row_array();
        return $result['level'];
    }

    public function initial_notice_update($id)
    {
        $CI =& get_instance();
        $data=array('status'=>$this->config->item('STATUS_INACTIVE'));
        $CI->db->where('notice_id',$id);
        $CI->db->update($CI->config->item('table_notice_view'),$data);
    }

    public function existing_viewer_groups($id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_notice_view').' notice_view');
        $CI->db->select('notice_view.viewer_user_group');
        $CI->db->where('notice_view.notice_id',$id);
        $details = $this->db->get()->result_array();
        $groups = array();
        foreach($details as $detail)
        {
            $groups[] = $detail['viewer_user_group'];
        }
        return $groups;
    }
}