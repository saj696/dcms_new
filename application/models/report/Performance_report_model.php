<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Performance_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_union_performance_report($division, $zilla, $upazila, $union, $status, $from_date, $to_date)
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_uisc_infos') . ' uisc');
        if ($status == 1) {
            $CI->db->select('sum(invoice.total_income) as total_income');
        } elseif ($status == 2) {
            $CI->db->select('sum(invoice.total_service) as total_service');
        } elseif ($status == 3) {
            $CI->db->select('count(excel.id) as total_upload');
        }
        $CI->db->select('uisc.uisc_name');
        $CI->db->select('division.divname');
        $CI->db->select('zilla.zillaname');
        $CI->db->select('upazila.upazilaname');
        $CI->db->select('union.unionname');


        //$CI->db->join($CI->config->item('table_invoice_details') . ' tid', 'tid.invoice_id=invoice.id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . ' division', 'division.divid=uisc.division', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . ' zilla', 'zilla.zillaid=uisc.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_upazilas') . ' upazila', 'upazila.upazilaid=uisc.upazilla', 'LEFT');
        $CI->db->join($CI->config->item('table_unions') . ' union', 'union.unionid=uisc.union and union.zillaid=zilla.zillaid', 'LEFT');
        if($status==3)
        {
            $CI->db->join($CI->config->item('table_excel_history') . ' excel', 'excel.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('excel.upload_date >=', strtotime($from_date));
            $CI->db->where('excel.upload_date <=', strtotime($to_date));
            $CI->db->order_by('total_upload','desc');
        }else{
            $CI->db->join($CI->config->item('table_invoices') . ' invoice', 'invoice.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('invoice.invoice_date >=', $from_date);
            $CI->db->where('invoice.invoice_date <=', $to_date);
            if($status==1)
            {
                $CI->db->order_by('total_income','desc');
            }else
            {
                $CI->db->order_by('total_service','desc');
            }
        }


        $CI->db->where('uisc.uisc_type', 1);
        $CI->db->where('uisc.division', $division);
        if (!empty($zilla)) {
            $CI->db->where('uisc.zilla', $zilla);
        }
        if (!empty($upazila)) {
            $CI->db->where('uisc.upazilla', $upazila);
        }
        if (!empty($union)) {
            $CI->db->where('uisc.union', $union);
        }



        $CI->db->group_by('uisc.id');
        $result = $CI->db->get()->result_array();

        /*echo "<pre>";
        print_r($result);
        echo "</pre>";
        die;*/

        return $result;

    }

    public function get_city_corporation_performance_report($division, $zilla, $city_corporation, $city_corporation_ward,$status, $from_date, $to_date)
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_uisc_infos') . ' uisc');
        if ($status == 1) {
            $CI->db->select('sum(invoice.total_income) as total_income');
        } elseif ($status == 2) {
            $CI->db->select('sum(invoice.total_service) as total_service');
        } elseif ($status == 3) {
            $CI->db->select('count(excel.id) as total_upload');
        }
        $CI->db->select('uisc.uisc_name');
        $CI->db->select('division.divname');
        $CI->db->select('zilla.zillaname');
        $CI->db->select('city_corporation.citycorporationname');
        $CI->db->select('ward.wardname');


        //$CI->db->join($CI->config->item('table_invoice_details') . ' tid', 'tid.invoice_id=invoice.id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . ' division', 'division.divid=uisc.division', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . ' zilla', 'zilla.zillaid=uisc.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_city_corporations') . ' city_corporation', 'city_corporation.zillaid=uisc.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_city_corporation_wards') . ' ward', 'ward.zillaid=zilla.zillaid and ward.citycorporationid=city_corporation.citycorporationid', 'LEFT');
        if($status==3)
        {
            $CI->db->join($CI->config->item('table_excel_history') . ' excel', 'excel.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('excel.upload_date >=', strtotime($from_date));
            $CI->db->where('excel.upload_date <=', strtotime($to_date));
            $CI->db->order_by('total_upload','desc');
        }else{
            $CI->db->join($CI->config->item('table_invoices') . ' invoice', 'invoice.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('invoice.invoice_date >=', $from_date);
            $CI->db->where('invoice.invoice_date <=', $to_date);
            if($status==1)
            {
                $CI->db->order_by('total_income','desc');
            }else
            {
                $CI->db->order_by('total_service','desc');
            }
        }


        $CI->db->where('uisc.uisc_type', 2);
        $CI->db->where('uisc.division', $division);
        if (!empty($zilla)) {
            $CI->db->where('uisc.zilla', $zilla);
        }
        if (!empty($city_corporation)) {
            $CI->db->where('uisc.citycorporation', $city_corporation);
        }
        if (!empty($city_corporation_ward)) {
            $CI->db->where('uisc.citycorporationward', $city_corporation_ward);
        }



        $CI->db->group_by('uisc.id');
        $result = $CI->db->get()->result_array();

       /* echo "<pre>";
        print_r($result);
        echo "</pre>";
        die;*/

        return $result;

    }

    public function get_municipal_performance_report($division, $zilla, $municipal, $municipal_ward ,$status, $from_date, $to_date)
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_uisc_infos') . ' uisc');
        if ($status == 1) {
            $CI->db->select('sum(invoice.total_income) as total_income');
        } elseif ($status == 2) {
            $CI->db->select('sum(invoice.total_service) as total_service');
        } elseif ($status == 3) {
            $CI->db->select('count(excel.id) as total_upload');
        }
        $CI->db->select('uisc.uisc_name');
        $CI->db->select('division.divname');
        $CI->db->select('zilla.zillaname');
        $CI->db->select('municipal.municipalname');
        $CI->db->select('ward.wardname');


        //$CI->db->join($CI->config->item('table_invoice_details') . ' tid', 'tid.invoice_id=invoice.id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . ' division', 'division.divid=uisc.division', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . ' zilla', 'zilla.zillaid=uisc.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_municipals') . ' municipal', 'municipal.zillaid=uisc.zilla', 'LEFT');
        $CI->db->join($CI->config->item('table_municipal_wards') . ' ward', 'ward.zillaid=uisc.zilla and ward.municipalid=municipal.municipalid', 'LEFT');
        if($status==3)
        {
            $CI->db->join($CI->config->item('table_excel_history') . ' excel', 'excel.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('excel.upload_date >=', strtotime($from_date));
            $CI->db->where('excel.upload_date <=', strtotime($to_date));
            $CI->db->order_by('total_upload','desc');
        }else{
            $CI->db->join($CI->config->item('table_invoices') . ' invoice', 'invoice.uisc_id=uisc.id', 'LEFT');
            $CI->db->where('invoice.invoice_date >=', $from_date);
            $CI->db->where('invoice.invoice_date <=', $to_date);
            if($status==1)
            {
                $CI->db->order_by('total_income','desc');
            }else
            {
                $CI->db->order_by('total_service','desc');
            }
        }


        $CI->db->where('uisc.uisc_type', 3);
        $CI->db->where('uisc.division', $division);
        if (!empty($zilla)) {
            $CI->db->where('uisc.zilla', $zilla);
        }
        if (!empty($municipal)) {
            $CI->db->where('uisc.municipal', $municipal);
        }
        if (!empty($municipal_ward)) {
            $CI->db->where('uisc.municipalward', $municipal_ward);
        }



        $CI->db->group_by('uisc.id');
        $result = $CI->db->get()->result_array();

        return $result;

    }
}