<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile_update_status_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    /*Get profile_update-status_report*/

    public function get_all_user_info($inputs)
    {
        /* echo "<pre>";
         print_r($inputs);
         echo "</pre>";
         die;*/
        $CI = &get_instance();
        $CI->db->from($CI->config->item('table_users') . ' user');
        $CI->db->select('user.*');
        $CI->db->select(['tei.id entrepreneur_id', 'tei.entrepreneur_type', 'tei.entrepreneur_name', 'tei.entrepreneur_father_name', 'tei.entrepreneur_mother_name', 'tei.entrepreneur_mobile', 'tei.entrepreneur_email', 'tei.entrepreneur_sex', 'tei.entrepreneur_address', 'tei.entrepreneur_nid']);
        $CI->db->select(['tee.id education_id', 'tee.latest_education', 'tee.passing_year']);
        $CI->db->select(['tt.id training_id', 'tt.course_name', 'tt.institute_name', 'tt.timespan']);
        $CI->db->select(['ti.id investment_id', 'ti.self_investment', 'ti.invest_debt', 'ti.invested_money', 'ti.invest_sector']);
        $CI->db->select(['tcl.id center_location_id', 'tcl.center_type']);
        $CI->db->select(['tur.id uisc_resources_id', 'tur.res_id', 'tur.quantity']);
        $CI->db->select(['tdi.id device_info_id', 'tdi.connection_type', 'tdi.modem', 'tdi.ip_address']);
        $CI->db->select(['te.id electricity_id', 'te.electricity', 'te.solar', 'te.ips']);
        $CI->db->select('div.divname division');
        $CI->db->select('zil.zillaname zilla');
        $CI->db->select('tui.uisc_name');
        if (!empty($inputs['division'])) {
            $CI->db->where('user.division =' . $inputs['division']);
        }
        if (!empty($inputs['zilla'])) {
            $CI->db->where('user.zilla =' . $inputs['zilla']);
        }
        $CI->db->join($CI->config->item('table_entrepreneur_infos') . ' tei', 'tei.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_entrepreneur_education') . ' tee', 'tee.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_training') . ' tt', 'tt.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_investment') . ' ti', 'ti.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_center_location') . ' tcl', 'tcl.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_uisc_resources') . ' tur', 'tur.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_device_infos') . ' tdi', 'tdi.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_electricity') . ' te', 'te.user_id=user.id', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . ' zil', 'zil.zillaid=user.zilla and zil.divid=user.division', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . ' div', 'div.divid=user.division', 'LEFT');
        $CI->db->join($CI->config->item('table_uisc_infos') . ' tui', 'tui.id=user.uisc_id', 'LEFT');
        $CI->db->group_by('user.id');
        $CI->db->where('user.status =1');
        $CI->db->where('user.user_group_id =13');

        /* $CI->db->order_by('user.zilla');*/
        if ($inputs['report_type'] == 1) {
            $CI->db->select('tu.upazilaname upazila');
            $CI->db->select('unioun.unionname unioun');
            if(!empty($inputs['upazila']))
            {
                $CI->db->join($CI->config->item('table_upazilas') . ' tu', 'tu.upazilaid=user.upazila and tu.zillaid=user.zilla', 'LEFT');
                $CI->db->where('user.upazila =' . $inputs['upazila']);
            }
            if(!empty($inputs['union']))
            {
                $CI->db->join($CI->config->item('table_unions') . ' unioun', 'unioun.unionid=user.unioun and unioun.zillaid=user.zilla and unioun.upazilaid=user.upazila', 'LEFT');
                $CI->db->where('user.unioun =' . $inputs['union']);
            }
            if (empty($inputs['upazila'])) {
                $CI->db->join($CI->config->item('table_upazilas') . ' tu', 'tu.upazilaid=user.upazila and tu.zillaid=user.zilla', 'INNER');
                $CI->db->join($CI->config->item('table_unions') . ' unioun', 'unioun.unionid=user.unioun and unioun.zillaid=user.zilla and unioun.upazilaid=user.upazila', 'LEFT');
            }elseif(empty($inputs['union']))
            {
                $CI->db->join($CI->config->item('table_unions') . ' unioun', 'unioun.unionid=user.unioun and unioun.zillaid=user.zilla and unioun.upazilaid=user.upazila', 'INNER');
            }

            $CI->db->order_by('user.upazila', 'ASC');
            $CI->db->order_by('user.unioun', 'ASC');
        } elseif ($inputs['report_type'] == 2) {
            $CI->db->select('tcc.citycorporationname citycorporation');
            $CI->db->select('tccw.wardname citycorporationward');

            if (!empty($inputs['city_corporation'])) {
                $CI->db->join($CI->config->item('table_city_corporations') . ' tcc', 'tcc.citycorporationid=user.citycorporation', 'LEFT');
                $CI->db->where('user.citycorporation =' . $inputs['city_corporation']);
            }

            if (!empty($inputs['city_corporation_ward'])) {
                $CI->db->join($CI->config->item('table_city_corporation_wards') . ' tccw', 'tccw.citycorporationwardid=user.citycorporationward and tccw.citycorporationid=user.citycorporation', 'LEFT');
                $CI->db->where('user.citycorporationward =' . $inputs['city_corporation_ward']);
            }

            if (empty($inputs['city_corporation'])) {
                $CI->db->join($CI->config->item('table_city_corporations') . ' tcc', 'tcc.citycorporationid=user.citycorporation', 'INNER');
                $CI->db->join($CI->config->item('table_city_corporation_wards') . ' tccw', 'tccw.citycorporationwardid=user.citycorporationward and tccw.citycorporationid=user.citycorporation', 'LEFT');

            } elseif (empty($inputs['city_corporation_ward'])) {
                $CI->db->join($CI->config->item('table_city_corporation_wards') . ' tccw', 'tccw.citycorporationwardid=user.citycorporationward and tccw.citycorporationid=user.citycorporation', 'INNER');
            }
            $CI->db->order_by('user.citycorporation');
            $CI->db->order_by('tccw.citycorporationwardid', 'ASC');
        } elseif ($inputs['report_type'] == 3) {

            $CI->db->select('municipal_ward.wardname municipalward');
            $CI->db->select('municipal.municipalname municipal');

            if(!empty($inputs['municipal']))
            {
                $CI->db->join($CI->config->item('table_municipals') . ' municipal', 'municipal.municipalid=user.municipal and municipal.zillaid=user.zilla', 'LEFT');
                $CI->db->where('user.municipal =' . $inputs['municipal']);
            }
            if(!empty($inputs['municipal_ward']))
            {
                $CI->db->join($CI->config->item('table_municipal_wards') . ' municipal_ward', 'municipal_ward.wardid=user.municipalward and municipal_ward.municipalid=user.municipal and municipal.zillaid=user.zilla', 'LEFT');
                $CI->db->where('user.municipalward =' . $inputs['municipal_ward']);
            }

            if (empty($inputs['municipal'])) {
                $CI->db->join($CI->config->item('table_municipals') . ' municipal', 'municipal.municipalid=user.municipal and municipal.zillaid=user.zilla', 'INNER');
                $CI->db->join($CI->config->item('table_municipal_wards') . ' municipal_ward', 'municipal_ward.wardid=user.municipalward and municipal_ward.municipalid=user.municipal and municipal.zillaid=user.zilla', 'LEFT');
            } elseif (empty($inputs['municipal_ward'])) {
                $CI->db->join($CI->config->item('table_municipal_wards') . ' municipal_ward', 'municipal_ward.wardid=user.municipalward and municipal_ward.municipalid=user.municipal and municipal.zillaid=user.zilla', 'INNER');
            }

            $CI->db->order_by('user.zilla', 'ASC');
            $CI->db->order_by('user.municipal', 'ASC');
            $CI->db->order_by('user.municipalward');
        }


        $results = $CI->db->get()->result_array();
        /* echo "<pre>";
         print_r($results);
         echo "</pre>";
         die;*/
        return $results;

    }


}