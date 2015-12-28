<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services_info_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_services_info_union($division, $zilla, $upazila, $union, $from_date, $to_date)
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
                divisions.divname,
                zillas.zillaname,
                upa_zilas.upazilaname,
                unions.unionname,
                uisc_infos.uisc_name,
                uisc_infos.user_group_id,
                uisc_infos.uisc_type,
                invoices.invoice_date,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid,
                zillas.zillaid,
                upa_zilas.upazilaid,
                unions.unionid,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=1 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_gov_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=2 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_private_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=3 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_local_service
            ", false);
        $this->db->from($CI->config->item('table_invoices')." invoices");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = invoices.divid', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $this->db->join($CI->config->item('table_upazilas')." upa_zilas",'upa_zilas.zillaid = invoices.zillaid AND upa_zilas.upazilaid = invoices.upazilaid', 'LEFT');
        $this->db->join($CI->config->item('table_unions')." unions",'unions.zillaid = invoices.zillaid AND unions.upazilaid = invoices.upazilaid AND unions.unionid = invoices.unionid', 'LEFT');
        $this->db->join($CI->config->item('table_uisc_infos')." uisc_infos",'uisc_infos.id = invoices.uisc_id', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_UNION_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));
        $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid','ASC');
        $this->db->group_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid, invoices.uisc_id');
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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['invoice_date']=$result[$i]['invoice_date'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_gov_service']=$result[$i]['total_gov_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_private_service']=$result[$i]['total_private_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_local_service']=$result[$i]['total_local_service'];
        }

        return $result_array;

    }

    public function get_services_info_municipal($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date)
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
                        $this->db->where('uisc_infos.municipalward',$municipal_ward);
                    }
                }
            }
        }

        $result_array=array();
        $this->db->select
            ("
                divisions.divname,
                zillas.zillaname,
                uisc_infos.uisc_name,
                uisc_infos.user_group_id,
                uisc_infos.uisc_type,
                invoices.invoice_date,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid,
                zillas.zillaid,
                uisc_infos.municipal,
                municipals.municipalname,
                uisc_infos.municipalward,
                municipal_wards.wardname,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=1 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_gov_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=2 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_private_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=3 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_local_service
            ", false);
        $this->db->from($CI->config->item('table_invoices')." invoices");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = invoices.divid', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $this->db->join($CI->config->item('table_uisc_infos')." uisc_infos",'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $this->db->join($CI->config->item('table_municipals')." municipals",'municipals.zillaid = uisc_infos.zilla AND municipals.municipalid = uisc_infos.municipal', 'LEFT');
        $this->db->join($CI->config->item('table_municipal_wards')." municipal_wards",'municipal_wards.municipalid = uisc_infos.municipal AND municipal_wards.wardid = uisc_infos.municipalward', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));
        $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid','ASC');
        $this->db->group_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            $result_array[$result[$i]['divid']]['division_id']=$result[$i]['divid'];
            $result_array[$result[$i]['divid']]['division_name']=$result[$i]['divname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_id']=$result[$i]['zillaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_name']=$result[$i]['zillaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_id']=$result[$i]['municipal'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_name']=$result[$i]['municipalname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['municipal_ward_id']=$result[$i]['municipalward'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['municipal_ward_name']=$result[$i]['wardname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['uisc_id']=$result[$i]['uisc_id'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['uisc_name']=$result[$i]['uisc_name'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['invoice_date']=$result[$i]['invoice_date'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_gov_service']=$result[$i]['total_gov_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_private_service']=$result[$i]['total_private_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipal']]['municipal_ward'][$result[$i]['municipalward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_local_service']=$result[$i]['total_local_service'];
        }

        return $result_array;

    }

    public function get_services_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date)
    {

        $CI = & get_instance();
        if (!empty($division))
        {
            $this->db->where('invoices.divid',$division);
            if (!empty($zilla))
            {
                $this->db->where('invoices.zillaid',$zilla);
                if (!empty($municipal))
                {
                    $this->db->where('uisc_infos.citycorporation',$city_corporation);
                    if (!empty($municipal_ward))
                    {
                        $this->db->where('uisc_infos.citycorporationward',$city_corporation_ward);
                    }
                }
            }
        }

        $result_array=array();
        $this->db->select
            ("
                divisions.divname,
                zillas.zillaname,
                uisc_infos.uisc_name,
                uisc_infos.user_group_id,
                uisc_infos.uisc_type,
                invoices.invoice_date,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid,
                zillas.zillaid,
                uisc_infos.citycorporation,
                city_corporations.citycorporationname,
                uisc_infos.citycorporationward,
                city_corporation_wards.wardname,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=1 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_gov_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=2 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_private_service,
                (
                SELECT
                count(invoice_details.id)
                FROM
                invoice_details
                LEFT JOIN services ON services.service_id = invoice_details.service_id
                WHERE services.service_type=3 AND invoice_details.invoice_id=invoices.invoice_id
                ) total_local_service
            ", false);
        $this->db->from($CI->config->item('table_invoices')." invoices");
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = invoices.divid', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $this->db->join($CI->config->item('table_uisc_infos')." uisc_infos",'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations')." city_corporations",'city_corporations.zillaid = uisc_infos.zilla AND city_corporations.citycorporationid = uisc_infos.citycorporation', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporation_wards')." city_corporation_wards",'city_corporation_wards.citycorporationid = uisc_infos.citycorporation AND city_corporation_wards.citycorporationwardid = uisc_infos.citycorporationward', 'LEFT');

        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));
        $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid','ASC');
        $this->db->group_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid');
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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['city_corporation_ward_id']=$result[$i]['citycorporationward'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['city_corporation_ward_name']=$result[$i]['wardname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['uisc_id']=$result[$i]['uisc_id'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['uisc_name']=$result[$i]['uisc_name'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['invoice_date']=$result[$i]['invoice_date'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_gov_service']=$result[$i]['total_gov_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_private_service']=$result[$i]['total_private_service'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationward']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_local_service']=$result[$i]['total_local_service'];
        }

        return $result_array;

    }
    //////  END CABINET INCOME  REPORT ////////////////

}