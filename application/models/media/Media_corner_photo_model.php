<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media_corner_photo_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_media_photos()
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_media').' media');
        $CI->db->where('media.media_type', 1);
        $CI->db->where('media.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('media.id', 'DESC');
        $results = $CI->db->get()->result_array();
        return $results;
    }

}