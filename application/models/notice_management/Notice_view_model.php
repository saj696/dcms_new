<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice_view_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_record_list()
    {
        $user=User_helper::get_user();
        $CI =& get_instance();
        $this->db->select('notice_view.*');
        $this->db->select('notice.notice_type, notice.notice_title, notice.notice_details, notice.upload_file, notice.status');
        $this->db->select('user_group.name_bn');
        $this->db->from($CI->config->item('table_notice_view')." notice_view");
        $this->db->join($CI->config->item('table_notice')." notice",'notice.id = notice_view.notice_id', 'LEFT');
        $this->db->join($CI->config->item('table_user_group')." user_group",'user_group.id = notice_view.sender_user_group', 'LEFT');
        $this->db->where('notice_view.status', $this->config->item('STATUS_ACTIVE'));
        $this->db->where('notice.status', $this->config->item('STATUS_ACTIVE'));
        $this->db->where('notice.notice_type !=', 3);
        $this->db->where('notice_view.viewer_user_group', $user->user_group_id);
        $results = $this->db->get()->result_array();
        
        foreach($results as $key=>&$result)
        {
            $result['edit_link']=$CI->get_encoded_url('notice_management/notice_view/index/batch_details/'.$result['notice_id']);
            if($result['status']==$this->config->item('STATUS_ACTIVE'))
            {
                $result['status_text']=$CI->lang->line('ACTIVE');
            }
            else if($result['status']==$this->config->item('STATUS_INACTIVE'))
            {
                $result['status_text']=$CI->lang->line('INACTIVE');
            }
            else
            {
                $result['status_text']=$result['status'];
            }
            if(!empty($result['upload_file']))
            {
                $result['upload_status']=$CI->lang->line('FILE_UPLOADED');
            }
            else
            {
                $user['upload_status']=$CI->lang->line('FILE_NOT_UPLOADED');
            }

            if($result['notice_type']==2)
            {
                if($result['viewer_user_group']==$CI->config->item('DIVISION_GROUP_ID') && $result['division'] != $user->division)
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('DISTRICT_GROUP_ID') && $result['zilla'] != $user->zilla)
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('UPAZILLA_GROUP_ID') && ($result['upazila'] != $user->upazila || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('UNION_GROUP_ID') && ($result['unioun'] != $user->unioun || $result['upazila'] != $user->upazila || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('CITY_CORPORATION_GROUP_ID') && ($result['citycorporation'] != $user->citycorporation || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID') && ($result['citycorporationward'] != $user->citycorporationward || $result['citycorporation'] != $user->citycorporation || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('MUNICIPAL_GROUP_ID') && ($result['municipal'] != $user->municipal || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('MUNICIPAL_WORD_GROUP_ID') && ($result['municipalward'] != $user->municipalward || $result['municipal'] != $user->municipal || $result['zilla'] != $user->zilla))
                {
                    unset($results[$key]);
                }
                if($result['viewer_user_group']==$CI->config->item('UISC_GROUP_ID'))
                {
                    if($result['upazila']>0 && $result['unioun']>0)
                    {
                        if($result['upazila'] != $user->upazila || $result['unioun'] != $user->unioun || $result['uisc_id'] != $user->uisc_id)
                        {
                            unset($results[$key]);
                        }
                    }
                    elseif($result['citycorporation']>0 && $result['citycorporationward']>0)
                    {
                        if($result['citycorporation'] != $user->citycorporation || $result['citycorporationward'] != $user->citycorporationward || $result['uisc_id'] != $user->uisc_id)
                        {
                            unset($results[$key]);
                        }
                    }
                    elseif($result['municipal']>0 && $result['municipalward']>0)
                    {
                        if($result['municipal'] != $user->municipal || $result['municipalward'] != $user->municipalward || $result['uisc_id'] != $user->uisc_id)
                        {
                            unset($results[$key]);
                        }
                    }
                }
            }
        }

        return array_values($results);
    }

    public function get_notice_info($id)
    {
        $user=User_helper::get_user();
        $CI =& get_instance();
        $this->db->select('notice.*');
        $this->db->from($CI->config->item('table_notice')." notice");
        $this->db->where('notice.id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }
}