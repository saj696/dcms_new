<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uno_activities_login_status_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_uno_user_activities_login_status($division, $zilla, $upazila, $union, $month, $year)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($upazila))
                {
                    $this->db->where('core_01_users.upazila',$upazila);
                    if (!empty($union))
                    {
                        $this->db->where('core_01_users.unioun',$union);
                    }
                }
            }
        }
        //$month=9; $year=2015;
        $days_in_month = @date('t', @mktime(0, 0, 0, $month, 1, $year));
        $s_date=$year.'-'.$month.'-01';
        $e_date=$year.'-'.$month."-".$days_in_month;
        $start_date = strtotime($s_date);
        $end_date = strtotime($e_date);

        $first_start_date = $start_date;
        $first_end_date = strtotime("+10 day", $start_date);

        $second_first_date=strtotime("+11 day", $start_date);
        $second_end_date=strtotime("+20 day", $start_date);

        $three_first_date=strtotime("+21 day", $start_date);
        $three_end_date=$end_date;

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.upazila,
                upa_zilas.upazilaname,
                core_01_users.unioun,
                unions.unionname,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$first_start_date AND core_07_user_login_history.login_time<=$first_end_date
                ) ten_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$second_first_date AND core_07_user_login_history.login_time<=$second_end_date
                ) twenty_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$three_first_date AND core_07_user_login_history.login_time<=$three_end_date
                ) thirty_days
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $this->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_upazilas').' upa_zilas','upa_zilas.zillaid = core_01_users.zilla AND upa_zilas.upazilaid = core_01_users.upazila', 'LEFT');
        $this->db->join($CI->config->item('table_unions').' unions','unions.zillaid = core_01_users.zilla AND unions.upazilaid = core_01_users.upazila AND unions.unionid = core_01_users.unioun', 'LEFT');
        $CI->db->where('core_01_users.user_group_id = '.$CI->config->item('UPAZILLA_GROUP_ID').' OR core_01_users.user_group_id = '.$CI->config->item('UNION_GROUP_ID'));
        $this->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if(strtotime($s_date) && strtotime($e_date))
        {
            return $results;
        }
        else
        {
            return false;
        }

    }

    public function get_municipal_user_activities_login_status($division, $zilla, $municipal, $municipal_ward, $month, $year)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('core_01_users.municipal',$municipal);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('core_01_users.municipalward',$municipal_ward);
                    }
                }
            }
        }

        //$month=9; $year=2015;
        $days_in_month = @date('t', @mktime(0, 0, 0, $month, 1, $year));
        $s_date=$year.'-'.$month.'-01';
        $e_date=$year.'-'.$month."-".$days_in_month;
        $start_date = strtotime($s_date);
        $end_date = strtotime($e_date);

        $first_start_date = $start_date;
        $first_end_date = strtotime("+10 day", $start_date);

        $second_first_date=strtotime("+11 day", $start_date);
        $second_end_date=strtotime("+20 day", $start_date);

        $three_first_date=strtotime("+21 day", $start_date);
        $three_end_date=$end_date;

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.municipal,
                municipals.municipalname,
                core_01_users.municipalward,
                municipal_wards.wardname,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$first_start_date AND core_07_user_login_history.login_time<=$first_end_date
                ) ten_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$second_first_date AND core_07_user_login_history.login_time<=$second_end_date
                ) twenty_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$three_first_date AND core_07_user_login_history.login_time<=$three_end_date
                ) thirty_days
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $this->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_municipals').' municipals','municipals.zillaid = core_01_users.zilla AND municipals.municipalid = core_01_users.municipal', 'LEFT');
        $this->db->join($CI->config->item('table_municipal_wards').' municipal_wards','municipal_wards.zillaid = core_01_users.zilla AND municipal_wards.municipalid = core_01_users.municipal AND municipal_wards.wardid = core_01_users.municipalward', 'LEFT');
        $CI->db->where('core_01_users.user_group_id = '.$CI->config->item('MUNICIPAL_WORD_GROUP_ID').' OR core_01_users.user_group_id = '.$CI->config->item('MUNICIPAL_GROUP_ID'));
        $this->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if(strtotime($s_date) && strtotime($e_date))
        {
            return $results;
        }
        else
        {
            return false;
        }

    }

    public function get_uisc_registration_city_corporation_info($division, $zilla, $city_corporation, $city_corporation_ward, $month, $year)
    {

        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('core_01_users.citycorporation',$city_corporation);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('core_01_users.citycorporationward',$city_corporation_ward);
                    }
                }
            }
        }

        //$month=9; $year=2015;
        $days_in_month = @date('t', @mktime(0, 0, 0, $month, 1, $year));
        $s_date=$year.'-'.$month.'-01';
        $e_date=$year.'-'.$month."-".$days_in_month;
        $start_date = strtotime($s_date);
        $end_date = strtotime($e_date);

        $first_start_date = $start_date;
        $first_end_date = strtotime("+10 day", $start_date);

        $second_first_date=strtotime("+11 day", $start_date);
        $second_end_date=strtotime("+20 day", $start_date);

        $three_first_date=strtotime("+21 day", $start_date);
        $three_end_date=$end_date;

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.citycorporation,
                core_01_users.citycorporationward,
                city_corporations.citycorporationname,
                city_corporation_wards.wardname,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$first_start_date AND core_07_user_login_history.login_time<=$first_end_date
                ) ten_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$second_first_date AND core_07_user_login_history.login_time<=$second_end_date
                ) twenty_days,
                (
                SELECT
                count(core_07_user_login_history.user_id)
                FROM core_07_user_login_history
                WHERE
                core_07_user_login_history.user_id=core_01_users.id
                AND core_07_user_login_history.login_time>=$three_first_date AND core_07_user_login_history.login_time<=$three_end_date
                ) thirty_days
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $this->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations').' city_corporations','city_corporations.zillaid = core_01_users.zilla AND city_corporations.citycorporationid = core_01_users.citycorporation', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporation_wards').' city_corporation_wards','city_corporation_wards.zillaid = core_01_users.zilla AND city_corporation_wards.citycorporationid = core_01_users.citycorporation AND city_corporation_wards.citycorporationwardid = core_01_users.citycorporationward', 'LEFT');
        $CI->db->where('core_01_users.user_group_id = '.$CI->config->item('CITY_CORPORATION_GROUP_ID').' OR core_01_users.user_group_id = '.$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'));
        $this->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if(strtotime($s_date) && strtotime($e_date))
        {
            return $results;
        }
        else
        {
            return false;
        }

    }


    public function get_union_user_activities_login_status($division, $zilla, $upazila, $union, $month, $year)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($upazila))
                {
                    $this->db->where('core_01_users.upazila',$upazila);
                    if (!empty($union))
                    {
                        $this->db->where('core_01_users.unioun',$union);
                    }
                }
            }
        }

        $s_date=$year.'-'.$month.'-'.date('d');

        $date = date($s_date);// current date

        $first_date=strtotime($date);

        $date_one = strtotime(date("Y-m-d", strtotime($date)) . " -1 day");

        $date_two = strtotime(date("Y-m-d", strtotime($date)) . " -2 days");

        $date_three = strtotime(date("Y-m-d", strtotime($date)) . " -3 days");

        $date_four = strtotime(date("Y-m-d", strtotime($date)) . " -4 days");

        $date_five = strtotime(date("Y-m-d", strtotime($date)) . " -5 days");

        $date_six = strtotime(date("Y-m-d", strtotime($date)) . " -6 days");

        $date_seven = strtotime(date("Y-m-d", strtotime($date)) . " -7 days");

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.upazila,
                upa_zilas.upazilaname,
                core_01_users.unioun,
                unions.unionname,
                uisc_infos.uisc_name,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$first_date AND core_07_user_login_history.login_time>=$date_one
                ) one_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_two
                ) two_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_three
                ) three_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_three AND core_07_user_login_history.login_time>=$date_four
                ) four_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_four AND core_07_user_login_history.login_time>=$date_five
                ) five_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_five AND core_07_user_login_history.login_time>=$date_six
                ) six_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_six AND core_07_user_login_history.login_time>=$date_seven
                ) seven_day
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $this->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_upazilas').' upa_zilas','upa_zilas.zillaid = core_01_users.zilla AND upa_zilas.upazilaid = core_01_users.upazila', 'LEFT');
        $this->db->join($CI->config->item('table_unions').' unions','unions.zillaid = core_01_users.zilla AND unions.upazilaid = core_01_users.upazila AND unions.unionid = core_01_users.unioun', 'LEFT');
        $this->db->join($CI->config->item('table_uisc_infos').' uisc_infos','uisc_infos.id = core_01_users.uisc_id', 'LEFT');
        $CI->db->where('core_01_users.user_group_id',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('core_01_users.uisc_type',$CI->config->item('ONLINE_UNION_GROUP_ID'));
        $this->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        return $results;

    }

    public function get_uisc_municipal_user_activities_login_status($division, $zilla, $municipal, $municipal_ward, $month, $year)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('core_01_users.municipal',$municipal);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('core_01_users.municipalward',$municipal_ward);
                    }
                }
            }
        }

        $s_date=$year.'-'.$month.'-'.date('d');

        $date = date($s_date);// current date

        $first_date=strtotime($date);

        $date_one = strtotime(date("Y-m-d", strtotime($date)) . " -1 day");

        $date_two = strtotime(date("Y-m-d", strtotime($date)) . " -2 days");

        $date_three = strtotime(date("Y-m-d", strtotime($date)) . " -3 days");

        $date_four = strtotime(date("Y-m-d", strtotime($date)) . " -4 days");

        $date_five = strtotime(date("Y-m-d", strtotime($date)) . " -5 days");

        $date_six = strtotime(date("Y-m-d", strtotime($date)) . " -6 days");

        $date_seven = strtotime(date("Y-m-d", strtotime($date)) . " -7 days");

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.municipal,
                municipals.municipalname,
                core_01_users.municipalward,
                municipal_wards.wardname,
                uisc_infos.uisc_name,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$first_date AND core_07_user_login_history.login_time>=$date_one
                ) one_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_two
                ) two_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_three
                ) three_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_three AND core_07_user_login_history.login_time>=$date_four
                ) four_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_four AND core_07_user_login_history.login_time>=$date_five
                ) five_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_five AND core_07_user_login_history.login_time>=$date_six
                ) six_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_six AND core_07_user_login_history.login_time>=$date_seven
                ) seven_day
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $CI->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_municipals').' municipals','municipals.zillaid = core_01_users.zilla AND municipals.municipalid = core_01_users.municipal', 'LEFT');
        $CI->db->join($CI->config->item('table_municipal_wards').' municipal_wards','municipal_wards.zillaid = core_01_users.zilla AND municipal_wards.municipalid = core_01_users.municipal AND municipal_wards.wardid = core_01_users.municipalward', 'LEFT');
        $CI->db->join($CI->config->item('table_uisc_infos').' uisc_infos','uisc_infos.id = core_01_users.uisc_id', 'LEFT');
        $CI->db->where('core_01_users.user_group_id',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('core_01_users.uisc_type',$CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $CI ->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        return $results;

    }

    public function get_uisc_city_corporation_user_activities_login_status($division, $zilla, $city_corporation, $city_corporation_ward, $month, $year)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('core_01_users.division',$division);
            if (!empty($zilla))
            {
                $this->db->where('core_01_users.zilla',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('core_01_users.citycorporation',$city_corporation);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('core_01_users.citycorporationward',$city_corporation_ward);
                    }
                }
            }
        }

        $s_date=$year.'-'.$month.'-'.date('d');

        $date = date($s_date);// current date

        $first_date=strtotime($date);

        $date_one = strtotime(date("Y-m-d", strtotime($date)) . " -1 day");

        $date_two = strtotime(date("Y-m-d", strtotime($date)) . " -2 days");

        $date_three = strtotime(date("Y-m-d", strtotime($date)) . " -3 days");

        $date_four = strtotime(date("Y-m-d", strtotime($date)) . " -4 days");

        $date_five = strtotime(date("Y-m-d", strtotime($date)) . " -5 days");

        $date_six = strtotime(date("Y-m-d", strtotime($date)) . " -6 days");

        $date_seven = strtotime(date("Y-m-d", strtotime($date)) . " -7 days");

        $CI->db->select
            (
                "
                core_01_users.id,
                core_01_users.username,
                core_01_users.name_bn,
                core_01_users.name_en,
                core_01_users.uisc_type,
                core_01_users.uisc_id,
                core_01_users.division,
                divisions.divname,
                core_01_users.zilla,
                zillas.zillaname,
                core_01_users.citycorporation,
                core_01_users.citycorporationward,
                city_corporations.citycorporationname,
                city_corporation_wards.wardname,
                uisc_infos.uisc_name,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$first_date AND core_07_user_login_history.login_time>=$date_one
                ) one_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_two
                ) two_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_one AND core_07_user_login_history.login_time>=$date_three
                ) three_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_three AND core_07_user_login_history.login_time>=$date_four
                ) four_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_four AND core_07_user_login_history.login_time>=$date_five
                ) five_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_five AND core_07_user_login_history.login_time>=$date_six
                ) six_day,
                (
                    SELECT
                    count(core_07_user_login_history.user_id)
                    FROM core_07_user_login_history
                    WHERE
                    core_07_user_login_history.user_id=core_01_users.id
                    AND core_07_user_login_history.login_time<=$date_six AND core_07_user_login_history.login_time>=$date_seven
                ) seven_day
                "
            );
        $CI->db->from($CI->config->item('table_users').' core_01_users');
        $CI->db->join($CI->config->item('table_divisions').' divisions','divisions.divid = core_01_users.division', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas').' zillas','zillas.divid = core_01_users.division AND zillas.zillaid = core_01_users.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations').' city_corporations','city_corporations.zillaid = core_01_users.zilla AND city_corporations.citycorporationid = core_01_users.citycorporation', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporation_wards').' city_corporation_wards','city_corporation_wards.zillaid = core_01_users.zilla AND city_corporation_wards.citycorporationid = core_01_users.citycorporation AND city_corporation_wards.citycorporationwardid = core_01_users.citycorporationward', 'LEFT');
        $CI->db->join($CI->config->item('table_uisc_infos').' uisc_infos','uisc_infos.id = core_01_users.uisc_id', 'LEFT');
        $CI->db->where('core_01_users.user_group_id',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('core_01_users.uisc_type',$CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $CI ->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid','ASC');
        $results = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        return $results;

    }

}