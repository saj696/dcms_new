<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_member_info_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    //////  START CABINET SERVICE HOLDER INCOME REPORT //////////////

    public function get_blog_member_info_union($division, $zilla, $upazila, $union)
    {
        $CI = & get_instance();
        if (!empty($division))
        {
            $this->db->where('divisions.divid',$division);
            if (!empty($zilla))
            {
                $this->db->where('zillas.zillaid',$zilla);
                if (!empty($upazila))
                {
                    $this->db->where('upa_zilas.upazilaid',$upazila);
                    if (!empty($union))
                    {
                        $this->db->where('unions.unionid',$union);
                    }
                }
            }
        }
        $result_array=array();
        $this->db->select
            ("
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                upa_zilas.upazilaid,
                upa_zilas.upazilaname,
                unions.unionid,
                unions.unionname,
                uisc_infos.id uisc_id,
                uisc_infos.uisc_type,
                uisc_infos.user_group_id,
                uisc_infos.uisc_name,
                entrepreneur_infos.entrepreneur_blog_member,
                entrepreneur_infos.entrepreneur_fb_group_member,
                entrepreneur_infos.entrepreneur_type,
                entrepreneur_infos.entrepreneur_name,
                entrepreneur_infos.entrepreneur_sex
            ", false);
        $this->db->from($CI->config->item('table_uisc_infos')." uisc_infos");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = uisc_infos.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = uisc_infos.division AND zillas.zillaid = uisc_infos.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_upazilas')." upa_zilas",'upa_zilas.zillaid = uisc_infos.zilla AND upa_zilas.upazilaid = uisc_infos.upazilla', 'LEFT');
        $this->db->join($CI->config->item('table_unions')." unions",'unions.zillaid = uisc_infos.zilla AND unions.upazilaid = uisc_infos.upazilla AND unions.unionid = uisc_infos.`union`', 'LEFT');
        $this->db->join($CI->config->item('table_entrepreneur_infos')." entrepreneur_infos",'entrepreneur_infos.uisc_id = uisc_infos.id', 'LEFT');
        $this->db->join($CI->config->item('table_entrepreneur_education')." entrepreneur_education_info",'entrepreneur_education_info.uisc_id = uisc_infos.id', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_UNION_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));

        $this->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid','ASC');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            $result_array[$result[$i]['divid']]['division_id']=$result[$i]['divid'];
            $result_array[$result[$i]['divid']]['division_name']=$result[$i]['divname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_id']=$result[$i]['zillaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_name']=$result[$i]['zillaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['upazilla_id']=$result[$i]['upazilaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['upazilla_name']=$result[$i]['upazilaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['union_id']=$result[$i]['unionid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['union_name']=$result[$i]['unionname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['uisc_id']=$result[$i]['uisc_id'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['uisc_name']=$result[$i]['uisc_name'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['entrepreneur_info'][]=array
            (
                'entrepreneur_name'=>$result[$i]['entrepreneur_name'],
                'entrepreneur_type'=>$result[$i]['entrepreneur_type'],
                'entrepreneur_sex'=>$result[$i]['entrepreneur_sex'],
                'entrepreneur_blog_member'=>$result[$i]['entrepreneur_blog_member'],
                'entrepreneur_fb_group_member'=>$result[$i]['entrepreneur_fb_group_member'],
            );
        }

        return $result_array;

    }
    public function get_blog_member_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward)
    {

        $CI = & get_instance();
        if (!empty($division))
        {
            $this->db->where('divisions.divid',$division);
            if (!empty($zilla))
            {
                $this->db->where('zillas.zillaid',$zilla);
                if (!empty($city_corporation))
                {
                    $this->db->where('city_corporations.citycorporationid',$city_corporation);
                    if (!empty($city_corporation_ward))
                    {
                        $this->db->where('city_corporation_wards.citycorporationwardid',$city_corporation_ward);
                    }
                }
            }
        }

        $result_array=array();
        $this->db->select
            ("
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                uisc_infos.id AS uisc_id,
                uisc_infos.uisc_type,
                uisc_infos.user_group_id,
                uisc_infos.uisc_name,
                entrepreneur_infos.entrepreneur_blog_member,
                entrepreneur_infos.entrepreneur_fb_group_member,
                entrepreneur_infos.entrepreneur_type,
                entrepreneur_infos.entrepreneur_name,
                entrepreneur_infos.entrepreneur_sex,
                city_corporations.citycorporationid,
                city_corporations.citycorporationname,
                city_corporation_wards.citycorporationwardid,
                city_corporation_wards.wardname
            ", false);

        $this->db->from($CI->config->item('table_uisc_infos')." uisc_infos");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = uisc_infos.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = uisc_infos.division AND zillas.zillaid = uisc_infos.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations')." city_corporations",'city_corporations.zillaid = uisc_infos.zilla AND city_corporations.citycorporationid = uisc_infos.citycorporation', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporation_wards')." city_corporation_wards",'city_corporation_wards.zillaid = uisc_infos.zilla AND city_corporation_wards.citycorporationid = uisc_infos.citycorporation AND city_corporation_wards.citycorporationwardid = uisc_infos.citycorporationward', 'LEFT');
        $this->db->join($CI->config->item('table_entrepreneur_infos')." entrepreneur_infos",'entrepreneur_infos.uisc_id = uisc_infos.id', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));

        $this->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid','ASC');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            $result_array[$result[$i]['divid']]['division_id']=$result[$i]['divid'];
            $result_array[$result[$i]['divid']]['division_name']=$result[$i]['divname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_id']=$result[$i]['zillaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_name']=$result[$i]['zillaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_id']=$result[$i]['citycorporationid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_name']=$result[$i]['citycorporationname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['city_corporation_ward_id']=$result[$i]['citycorporationwardid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['city_corporation_ward_name']=$result[$i]['wardname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['uisc_id']=$result[$i]['uisc_id'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['uisc_name']=$result[$i]['uisc_name'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['entrepreneur_info'][]=array
            (
                'entrepreneur_name'=>$result[$i]['entrepreneur_name'],
                'entrepreneur_type'=>$result[$i]['entrepreneur_type'],
                'entrepreneur_sex'=>$result[$i]['entrepreneur_sex'],
                'entrepreneur_blog_member'=>$result[$i]['entrepreneur_blog_member'],
                'entrepreneur_fb_group_member'=>$result[$i]['entrepreneur_fb_group_member'],
            );
        }
        return $result_array;
    }
    public function get_blog_member_info_municipal($division, $zilla, $municipal, $municipal_ward)
    {
        $CI = & get_instance();

        if (!empty($division))
        {
            $this->db->where('divisions.divid',$division);
            if (!empty($zilla))
            {
                $this->db->where('zillas.zillaid',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('municipals.municipalid',$municipal);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('municipal_wards.wardid',$municipal_ward);
                    }
                }
            }
        }

        $result_array=array();
        $this->db->select
            ("
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                uisc_infos.id AS uisc_id,
                uisc_infos.uisc_type,
                uisc_infos.user_group_id,
                uisc_infos.uisc_name,
                entrepreneur_infos.entrepreneur_blog_member,
                entrepreneur_infos.entrepreneur_fb_group_member,
                entrepreneur_infos.entrepreneur_type,
                entrepreneur_infos.entrepreneur_name,
                entrepreneur_infos.entrepreneur_sex,
                municipals.municipalid,
                municipals.municipalname,
                municipal_wards.wardid,
                municipal_wards.wardname
            ", false);

        $this->db->from($CI->config->item('table_uisc_infos')." uisc_infos");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = uisc_infos.division', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = uisc_infos.division AND zillas.zillaid = uisc_infos.zilla', 'LEFT');
        $this->db->join($CI->config->item('table_municipals')." municipals",'municipals.zillaid = uisc_infos.zilla AND municipals.municipalid = uisc_infos.municipal', 'LEFT');
        $this->db->join($CI->config->item('table_municipal_wards')." municipal_wards",'municipal_wards.zillaid = uisc_infos.zilla AND municipal_wards.municipalid = uisc_infos.municipal AND municipal_wards.wardid = uisc_infos.municipalward', 'LEFT');
        $this->db->join($CI->config->item('table_entrepreneur_infos')." entrepreneur_infos",'entrepreneur_infos.uisc_id = uisc_infos.id', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));

        $this->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid','ASC');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            $result_array[$result[$i]['divid']]['division_id']=$result[$i]['divid'];
            $result_array[$result[$i]['divid']]['division_name']=$result[$i]['divname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_id']=$result[$i]['zillaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_name']=$result[$i]['zillaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_id']=$result[$i]['municipalid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_name']=$result[$i]['municipalname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['municipal_ward_id']=$result[$i]['wardid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['municipal_ward_name']=$result[$i]['wardname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['uisc_id']=$result[$i]['uisc_id'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['uisc_name']=$result[$i]['uisc_name'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['entrepreneur_info'][]=array
            (
                'entrepreneur_name'=>$result[$i]['entrepreneur_name'],
                'entrepreneur_type'=>$result[$i]['entrepreneur_type'],
                'entrepreneur_sex'=>$result[$i]['entrepreneur_sex'],
                'entrepreneur_blog_member'=>$result[$i]['entrepreneur_blog_member'],
                'entrepreneur_fb_group_member'=>$result[$i]['entrepreneur_fb_group_member'],
            );
        }
        return $result_array;
    }


    //////  END DIGITAL CENTER INFO REPORT ////////////////

}