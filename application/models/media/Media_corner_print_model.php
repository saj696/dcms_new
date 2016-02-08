<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media_corner_print_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_media_prints()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_media').' media');
        $CI->db->where('media.media_type', 3);
        $CI->db->where('media.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('media.print_year', 'DESC');
        $results = $CI->db->get()->result_array();
        return $results;
    }

    public function get_media_search_result($title)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_media').' media');
        $CI->db->like('media.media_title', $title);
        $CI->db->where('media.media_type', 3);
        $CI->db->where('media.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('media.print_year', 'DESC');
        $results = $CI->db->get()->result_array();
        return $results;
    }

}