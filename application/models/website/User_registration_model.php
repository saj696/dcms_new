<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_registration_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function CountUnionServiceCenter($division_id, $zilla_id, $upzilla_id, $unioun_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('count(id)');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('upazilla', $upzilla_id);
        $CI->db->where('union', $unioun_id);
        $CI->db->where('status', 1);
        $CI->db->group_by("division", "zilla", "upazilla", "union");

        $count = $CI->db->count_all_results();

        if($count > 0)
        {
            $total_uisc = $count + 1;
        }
        else
        {
            $total_uisc = "01";
        }
        return $total_uisc;
    }

    public function getUnionServiceCenter($division_id, $zilla_id, $upzilla_id, $unioun_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('id, uisc_name');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('upazilla', $upzilla_id);
        $CI->db->where('union', $unioun_id);

        $results = $CI->db->get()->result_array();
        return $results;
    }

    public function countCityServiceCenter($division_id, $zilla_id, $citycorporation_id, $city_corporation_ward_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('count(id) as uisc_id');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('citycorporation', $citycorporation_id);
        $CI->db->where('citycorporationward', $city_corporation_ward_id);
        $CI->db->where('status', 1);
        $CI->db->group_by("division", "zilla", "citycorporation", "citycorporationward");

        $count = $CI->db->count_all_results();

        if($count > 0)
        {
            $total_uisc = $count + 1;
        }
        else
        {
            $total_uisc = "01";
        }
        return $total_uisc;
    }

    public function getCityServiceCenter($division_id, $zilla_id, $citycorporation_id, $city_corporation_ward_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('id, uisc_name');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('citycorporation', $citycorporation_id);
        $CI->db->where('citycorporationward', $city_corporation_ward_id);
        $results = $CI->db->get()->result_array();
        return $results;
    }

    public function countMunicipalServiceCenter($division_id, $zilla_id, $municipal_id, $municipal_ward_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('count(id) as uisc_id');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('municipal', $municipal_id);
        $CI->db->where('municipalward', $municipal_ward_id);
        $CI->db->where('status', 1);
        $CI->db->group_by("division", "zilla", "municipal", "municipalward");

        $count = $CI->db->count_all_results();

        if($count > 0)
        {
            $total_uisc = $count + 1;
        }
        else
        {
            $total_uisc = "01";
        }
        return $total_uisc;
    }

    public function getMunicipalServiceCenter($division_id, $zilla_id, $municipal_id, $municipal_ward_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->select('id, uisc_name');
        $CI->db->where('division', $division_id);
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('municipal', $municipal_id);
        $CI->db->where('municipalward', $municipal_ward_id);

        $results = $CI->db->get()->result_array();
        return $results;
    }

    public function get_union_name($zilla, $upazilla, $union)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_unions'));
        $CI->db->select('unionname');
        $CI->db->where('zillaid', $zilla);
        $CI->db->where('upazilaid', $upazilla);
        $CI->db->where('unionid', $union);
        $result = $CI->db->get()->row_array();
        return $result['unionname'];
    }

    public function get_city_name($zilla, $city)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_city_corporations'));
        $CI->db->select('citycorporationname');
        $CI->db->where('zillaid', $zilla);
        $CI->db->where('citycorporationid', $city);
        $result = $CI->db->get()->row_array();
        return $result['citycorporationname'];
    }

    public function get_city_ward_name($zilla, $city, $ward)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_city_corporation_wards'));
        $CI->db->select('wardname');
        $CI->db->where('zillaid', $zilla);
        $CI->db->where('citycorporationid', $city);
        $CI->db->where('citycorporationwardid', $ward);
        $result = $CI->db->get()->row_array();
        return $result['wardname'];
    }

    public function get_municipal_name($zilla, $municipal)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_municipals'));
        $CI->db->select('municipalname');
        $CI->db->where('zillaid', $zilla);
        $CI->db->where('municipalid', $municipal);
        $result = $CI->db->get()->row_array();
        return $result['municipalname'];
    }

    public function get_municipal_ward_name($zilla, $municipal, $ward)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_municipal_wards'));
        $CI->db->select('wardname');
        $CI->db->where('zillaid', $zilla);
        $CI->db->where('municipalid', $municipal);
        $CI->db->where('wardid', $ward);
        $result = $CI->db->get()->row_array();
        return $result['wardname'];
    }

    public function check_division($division_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_divisions'));
        $CI->db->where('divid', $division_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_zilla($division_id, $zilla_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_zillas'));
        $CI->db->where('divid', $division_id);
        $CI->db->where('zillaid', $zilla_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_upazilla($zilla_id, $upazilla_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_upazilas'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('upazilaid', $upazilla_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_union($zilla_id, $upazilla_id, $union_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_unions'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('upazilaid', $upazilla_id);
        $CI->db->where('unionid', $union_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_dcms_udc($zilla_id, $upazilla_id, $union_id, $uisc_name_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('upazilla', $upazilla_id);
        $CI->db->where('union', $union_id);
        $CI->db->where('id', $uisc_name_id);
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();

        if(isset($results[0]['id']))
        {
            if($results[0]['id']!=$uisc_name_id)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    public function check_city_corporation($zilla_id, $city_corporation_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_city_corporations'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('citycorporationid', $city_corporation_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_city_corporation_word($zilla_id, $city_corporation_id, $city_corporation_word_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_city_corporation_wards'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('citycorporationid', $city_corporation_id);
        $CI->db->where('citycorporationwardid', $city_corporation_word_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_dcms_cdc($zilla_id, $city_corporation_id, $city_corporation_word_id, $uisc_name_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('citycorporation', $city_corporation_id);
        $CI->db->where('citycorporationward', $city_corporation_word_id);
        $CI->db->where('id', $uisc_name_id);
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if(isset($results[0]['id']))
        {
            if($results[0]['id']!=$uisc_name_id)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    public function check_municipal($zilla_id, $municipal_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_municipals'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('municipalid', $municipal_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_municipal_word($zilla_id, $municipal_id, $municipal_word_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_municipal_wards'));
        $CI->db->where('zillaid', $zilla_id);
        $CI->db->where('municipalid', $municipal_id);
        $CI->db->where('wardid', $municipal_word_id);
        $results = $CI->db->get()->result_array();
        if(!$results)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function check_dcms_pdc($zilla_id, $municipal_id, $municipal_word_id, $uisc_name_id)
    {
        $CI =& get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos'));
        $CI->db->where('zilla', $zilla_id);
        $CI->db->where('municipal', $municipal_id);
        $CI->db->where('municipalward', $municipal_word_id);
        $CI->db->where('id', $uisc_name_id);
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if(isset($results[0]['id']))
        {
            if($results[0]['id']!=$uisc_name_id)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    public function get_uisc_serial($uisc_id)
    {
        $CI =& get_instance();
        $CI->db->select('username');
        $CI->db->from($CI->config->item('table_users'));
        $CI->db->where('uisc_id', $uisc_id);
        $result = $CI->db->get()->row_array();

        if($result)
        {
            $explode_result = explode('-', $result['username']);
            $fourth_segment = $explode_result[3];
            return $fourth_segment;
        }
        else
        {
            return '01';
        }
    }

    public function get_user_serial($uisc_id)
    {
        $CI =& get_instance();
        $CI->db->select('count(id)');
        $CI->db->from($CI->config->item('table_users'));
        $CI->db->where('uisc_id', $uisc_id);
        $count = $CI->db->count_all_results();
        if($count > 0)
        {
            $total_uisc = $count + 1;
        }
        else
        {
            $total_uisc = "01";
        }
        return $total_uisc;
    }
}