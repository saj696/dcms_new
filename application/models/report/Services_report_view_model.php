<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services_report_view_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_services_based_report_union($division, $zilla, $service_id, $from_date, $to_date)
    {
        $CI = &get_instance();

        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                /*if (!empty($upazila)) {
                    $this->db->where('upa_zilas.upazilaid', $upazila);
                    if (!empty($union)) {
                        $this->db->where('unions.unionid', $union);
                    }
                }*/
            }
        }

        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            upa_zilas.upazilaid,
            upa_zilas.upazilaname,
            invoice_details.service_name,
            count(invoice_details.id) as total_service,
            sum(invoice_details.income) as total_income
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_upazilas') . " upa_zilas", 'upa_zilas.zillaid = zillas.zillaid', 'INNER');
//        $CI->db->join($CI->config->item('table_unions') . " unions", 'unions.zillaid = upa_zilas.zillaid AND unions.upazilaid = upa_zilas.upazilaid', 'INNER');
        $CI->db->join($CI->config->item('table_invoices') . " invoices", 'invoices.divid = divisions.divid AND invoices.zillaid = zillas.zillaid AND invoices.upazilaid = upa_zilas.upazilaid', 'LEFT');
        $CI->db->join($CI->config->item('table_invoice_details') . " invoice_details", 'invoice_details.invoice_id = invoices.invoice_id', 'LEFT');
        $CI->db->where('invoices.invoice_date >=', $from_date);
        $CI->db->where('invoices.invoice_date <=', $to_date);
        $CI->db->where('invoice_details.service_id', $service_id);
        $CI->db->group_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, invoice_details.service_id');
        $CI->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid', 'ASC');
        $result = $CI->db->get()->result_array();

        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_services_based_report_city_corporation($division, $zilla, $service_id, $from_date, $to_date)
    {
        $CI = &get_instance();

        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                /*if (!empty($upazila)) {
                    $this->db->where('upa_zilas.upazilaid', $upazila);
                    if (!empty($union)) {
                        $this->db->where('unions.unionid', $union);
                    }
                }*/
            }
        }

        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            city.citycorporationid,
            city.citycorporationname,
            invoice_details.service_name,
            count(invoice_details.id) as total_service,
            sum(invoice_details.income) as total_income
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_city_corporations') . " city", 'city.zillaid = zillas.zillaid', 'INNER');
//        $CI->db->join($CI->config->item('table_unions') . " unions", 'unions.zillaid = upa_zilas.zillaid AND unions.upazilaid = upa_zilas.upazilaid', 'INNER');
        $CI->db->join($CI->config->item('table_invoices') . " invoices", 'invoices.divid = divisions.divid AND invoices.zillaid = zillas.zillaid AND invoices.citycorporationid = city.citycorporationid', 'LEFT');
        $CI->db->join($CI->config->item('table_invoice_details') . " invoice_details", 'invoice_details.invoice_id = invoices.invoice_id', 'LEFT');
        $CI->db->where('invoices.invoice_date >=', $from_date);
        $CI->db->where('invoices.invoice_date <=', $to_date);
        $CI->db->where('invoice_details.service_id', $service_id);
        $CI->db->group_by('divisions.divid, zillas.zillaid, city.citycorporationid, invoice_details.service_id');
        $CI->db->order_by('divisions.divid, zillas.zillaid, city.citycorporationid', 'ASC');
        $result = $CI->db->get()->result_array();

        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_services_based_report_municipal($division, $zilla, $service_id, $from_date, $to_date)
    {
        $CI = &get_instance();

        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                /*if (!empty($upazila)) {
                    $this->db->where('upa_zilas.upazilaid', $upazila);
                    if (!empty($union)) {
                        $this->db->where('unions.unionid', $union);
                    }
                }*/
            }
        }

        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            municipal.municipalid,
            municipal.municipalname,
            invoice_details.service_name,
            count(invoice_details.id) as total_service,
            sum(invoice_details.income) as total_income
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_municipals') . " municipal", 'municipal.zillaid = zillas.zillaid', 'INNER');
//        $CI->db->join($CI->config->item('table_unions') . " unions", 'unions.zillaid = upa_zilas.zillaid AND unions.upazilaid = upa_zilas.upazilaid', 'INNER');
        $CI->db->join($CI->config->item('table_invoices') . " invoices", 'invoices.divid = divisions.divid AND invoices.zillaid = zillas.zillaid AND invoices.municipalid = municipal.municipalid', 'LEFT');
        $CI->db->join($CI->config->item('table_invoice_details') . " invoice_details", 'invoice_details.invoice_id = invoices.invoice_id', 'LEFT');
        $CI->db->where('invoices.invoice_date >=', $from_date);
        $CI->db->where('invoices.invoice_date <=', $to_date);
        $CI->db->where('invoice_details.service_id', $service_id);
        $CI->db->group_by('divisions.divid, zillas.zillaid, municipal.municipalid, invoice_details.service_id');
        $CI->db->order_by('divisions.divid, zillas.zillaid, municipal.municipalid', 'ASC');
        $result = $CI->db->get()->result_array();

        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }
}