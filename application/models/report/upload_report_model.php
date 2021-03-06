<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    public function get_uisc($division, $zilla, $upazila, $union)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                if (!empty($upazila)) {
                    $this->db->where('upa_zilas.upazilaid', $upazila);
                    if (!empty($union)) {
                        $this->db->where('unions.unionid', $union);
                    }
                }
            }
        }
        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            upa_zilas.upazilaid,
            upa_zilas.upazilaname,
            unions.unionid,
            unions.unionname,
            uisc_infos.uisc_type,
            uisc_infos.user_group_id,
            uisc_infos.uisc_name,
            uisc_infos.id uisc_id
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_upazilas') . " upa_zilas", 'upa_zilas.zillaid = zillas.zillaid', 'INNER');
        $CI->db->join($CI->config->item('table_unions') . " unions", 'unions.zillaid = upa_zilas.zillaid AND unions.upazilaid = upa_zilas.upazilaid', 'INNER');
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.division = divisions.divid AND uisc_infos.zilla = unions.zillaid AND uisc_infos.upazilla = unions.upazilaid AND uisc_infos.union = unions.unionid', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_UNION_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid,unions.unionid, uisc_infos.id', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_uisc_for_cdc($division, $zilla, $city_corporation, $ward)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                if (!empty($upazila)) {
                    $this->db->where('city.upazilaid', $city_corporation);
                    if (!empty($union)) {
                        $this->db->where('ward.unionid', $ward);
                    }
                }
            }
        }
        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            city.citycorporationid,
            city.citycorporationname,
            ward.citycorporationwardid,
            ward.wardname,
            uisc_infos.uisc_type,
            uisc_infos.user_group_id,
            uisc_infos.uisc_name,
            uisc_infos.id uisc_id
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_city_corporations') . " city", 'city.zillaid = zillas.zillaid', 'INNER');
        $CI->db->join($CI->config->item('table_city_corporation_wards') . " ward", 'ward.zillaid = city.zillaid AND ward.citycorporationid = city.citycorporationid', 'INNER');
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.division = divisions.divid AND uisc_infos.zilla = ward.zillaid AND uisc_infos.citycorporation = ward.citycorporationid AND uisc_infos.citycorporationward = ward.citycorporationwardid', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('divisions.divid, zillas.zillaid, city.citycorporationid,ward.citycorporationwardid, uisc_infos.id', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_uisc_for_pdc($division, $zilla, $municipal, $ward)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('divisions.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('zillas.zillaid', $zilla);
                if (!empty($upazila)) {
                    $this->db->where('municipal.municipalid', $municipal);
                    if (!empty($union)) {
                        $this->db->where('ward.wardid', $ward);
                    }
                }
            }
        }
        $CI->db->select('divisions.divid,
            divisions.divname,
            zillas.zillaid,
            zillas.zillaname,
            municipal.municipalid,
            municipal.municipalname,
            ward.wardid,
            ward.wardname,
            uisc_infos.uisc_type,
            uisc_infos.user_group_id,
            uisc_infos.uisc_name,
            uisc_infos.id uisc_id
            ');
        $CI->db->from($CI->config->item('table_divisions') . " divisions");
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = divisions.divid', 'INNER');
        $CI->db->join($CI->config->item('table_municipals') . " municipal", 'municipal.zillaid = zillas.zillaid', 'INNER');
        $CI->db->join($CI->config->item('table_municipal_wards') . " ward", 'ward.zillaid = municipal.zillaid AND ward.municipalid = municipal.municipalid', 'INNER');
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.division = divisions.divid AND uisc_infos.zilla = ward.zillaid AND uisc_infos.municipal = ward.municipalid AND uisc_infos.municipalward = ward.wardid', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', $CI->config->item('STATUS_ACTIVE'));
        $CI->db->order_by('divisions.divid, zillas.zillaid, municipal.municipalid,ward.wardid, uisc_infos.id', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('uisc_infos.division', $division);
            if (!empty($zilla)) {
                $this->db->where('uisc_infos.zilla', $zilla);
                if (!empty($upazila)) {
                    $this->db->where('uisc_infos.upazilla', $upazila);
                    if (!empty($union)) {
                        $this->db->where('uisc_infos.union', $union);
                    }
                }
            }
        }

        $CI->db->select('
                            uisc_infos.id uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            uisc_infos.division divid,
                            uisc_infos.zilla zillaid,
                            uisc_infos.upazilla upazilaid,
                            uisc_infos.union unionid,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_income,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_uisc_infos') . " uisc_infos");
        $CI->db->join($CI->config->item('table_invoices') . " invoices", "invoices.uisc_id=uisc_infos.id", 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_UNION_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        $CI->db->order_by('uisc_infos.id', 'uisc_infos.division, uisc_infos.zilla, uisc_infos.upazilla,uisc_infos.union, invoices.invoice_date', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }

    }

    public function get_municipal_report_upload_status($division, $zilla, $municipal, $ward, $from_date, $to_date)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('uisc_infos.division', $division);
            if (!empty($zilla)) {
                $this->db->where('uisc_infos.zilla', $zilla);
                if (!empty($city_corporation)) {
                    $this->db->where('uisc_infos.municipal', $municipal);
                    if (!empty($ward)) {
                        $this->db->where('uisc_infos.municipalward', $ward);
                    }
                }
            }
        }

        $CI->db->select('
                            uisc_infos.id uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            uisc_infos.division divid,
                            uisc_infos.zilla zillaid,
                            uisc_infos.municipal municipalid,
                            uisc_infos.municipalward wardid,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_income,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_uisc_infos') . " uisc_infos");
        $CI->db->join($CI->config->item('table_invoices') . " invoices", "invoices.uisc_id=uisc_infos.id", 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        $CI->db->order_by('uisc_infos.id', 'uisc_infos.division, uisc_infos.zilla, uisc_infos.municipal,uisc_infos.municipalward, invoices.invoice_date', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_city_corporation_report_upload_status($division, $zilla, $city_corporation, $ward, $from_date, $to_date)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('uisc_infos.division', $division);
            if (!empty($zilla)) {
                $this->db->where('uisc_infos.zilla', $zilla);
                if (!empty($city_corporation)) {
                    $this->db->where('uisc_infos.citycorporation', $city_corporation);
                    if (!empty($ward)) {
                        $this->db->where('uisc_infos.citycorporationward', $ward);
                    }
                }
            }
        }

        $CI->db->select('
                            uisc_infos.id uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            uisc_infos.division divid,
                            uisc_infos.zilla zillaid,
                            uisc_infos.citycorporation citycorporationid,
                            uisc_infos.citycorporationward wardid,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_income,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_uisc_infos') . " uisc_infos");
        $CI->db->join($CI->config->item('table_invoices') . " invoices", "invoices.uisc_id=uisc_infos.id", 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        $CI->db->order_by('uisc_infos.id', 'uisc_infos.division, uisc_infos.zilla, uisc_infos.citycorporation,uisc_infos.citycorporationward, invoices.invoice_date', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }


    }
    //////  END UPLOAD STATUS REPORT ////////////////

    //////  START UPLOAD INCOME REPORT ////////////////
    public function get_union_report_upload_income($division, $zilla, $upazila, $union, $from_date, $to_date, $status)
    {
        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('invoices.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('invoices.zillaid', $zilla);
                if (!empty($upazila)) {
                    $this->db->where('invoices.upazilaid', $upazila);
                    if (!empty($union)) {
                        $this->db->where('invoices.unionid', $union);
                    }
                }
            }
        }

        if ($status == 1) {
            $this->db->select('invoices.total_income');
        } else if ($status == 2) {
            $this->db->order_by('invoices.total_income', 'DESC');
            $this->db->group_by('invoices.divid, invoices.zillaid, invoices.upazilaid,invoices.unionid, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else if ($status == 3) {
            $this->db->order_by('invoices.total_income', 'ASC');
            $this->db->group_by('invoices.divid, invoices.zillaid, invoices.upazilaid,invoices.unionid, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else {
            return false;
        }
        $CI->db->select('
                            invoices.uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            invoices.divid,
                            divisions.divname,
                            invoices.zillaid,
                            zillas.zillaname,
                            invoices.upazilaid,
                            upa_zilas.upazilaname,
                            invoices.unionid,
                            unions.unionname,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_invoices') . " invoices");
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . " divisions", 'divisions.divid = invoices.divid', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $CI->db->join($CI->config->item('table_upazilas') . " upa_zilas", 'upa_zilas.zillaid = invoices.zillaid AND upa_zilas.upazilaid = invoices.upazilaid', 'LEFT');
        $CI->db->join($CI->config->item('table_unions') . " unions", 'unions.zillaid = invoices.zillaid AND unions.upazilaid = invoices.upazilaid AND unions.unionid = invoices.unionid', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_UNION_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        //$CI->db->order_by('invoices.divid, invoices.zillaid, invoices.upazilaid,invoices.unionid, invoices.invoice_date','ASC');

        $result = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }

    }

    public function get_municipal_report_upload_income($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date, $status)
    {
        $CI = &get_instance();

        if (!empty($division)) {
            $this->db->where('invoices.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('invoices.zillaid', $zilla);
                if (!empty($municipal)) {
                    $this->db->where('uisc_infos.municipal', $municipal);
                    if (!empty($municipal_ward)) {
                        $this->db->where('uisc_infos.municipalward', $municipal_ward);
                    }
                }
            }
        }
        if ($status == 1) {
            $this->db->select('invoices.total_income');
        } else if ($status == 2) {
            $this->db->order_by('invoices.total_income', 'DESC');
            $this->db->group_by('invoices.divid, invoices.zillaid, uisc_infos.municipal, uisc_infos.municipalward, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else if ($status == 3) {
            $this->db->order_by('invoices.total_income', 'ASC');
            $this->db->group_by('invoices.divid, invoices.zillaid, uisc_infos.municipal, uisc_infos.municipalward, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else {
            return false;
        }
        $CI->db->select('
                            invoices.uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            invoices.divid,
                            divisions.divname,
                            invoices.zillaid,
                            zillas.zillaname,
                            uisc_infos.municipal,
                            municipals.municipalname,
                            uisc_infos.municipalward,
                            municipal_wards.wardname,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_income,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_invoices') . " invoices");
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . " divisions", 'divisions.divid = invoices.divid', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $CI->db->join($CI->config->item('table_municipals') . " municipals", 'municipals.zillaid = uisc_infos.zilla AND municipals.municipalid = uisc_infos.municipal', 'LEFT');
        $CI->db->join($CI->config->item('table_municipal_wards') . " municipal_wards", 'municipal_wards.zillaid = uisc_infos.zilla AND municipal_wards.municipalid = uisc_infos.municipal AND municipal_wards.wardid = uisc_infos.municipalward', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        //$CI->db->order_by('invoices.divid, invoices.zillaid, uisc_infos.municipal, uisc_infos.municipalward, invoices.invoice_date','ASC');
        $result = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }

    }


    public function get_city_corporation_report_upload_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date, $status)
    {

        $CI = &get_instance();
        if (!empty($division)) {
            $this->db->where('invoices.divid', $division);
            if (!empty($zilla)) {
                $this->db->where('invoices.zillaid', $zilla);
                if (!empty($municipal)) {
                    $this->db->where('uisc_infos.citycorporation', $city_corporation);
                    if (!empty($municipal_ward)) {
                        $this->db->where('uisc_infos.citycorporationward', $city_corporation_ward);
                    }
                }
            }
        }
        if ($status == 1) {
            $this->db->select('invoices.total_income');
        } else if ($status == 2) {
            $this->db->order_by('invoices.total_income', 'DESC');
            $this->db->group_by('invoices.divid, invoices.zillaid, uisc_infos.citycorporation, uisc_infos.citycorporationward, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else if ($status == 3) {
            $this->db->order_by('invoices.total_income', 'ASC');
            $this->db->group_by('invoices.divid, invoices.zillaid, uisc_infos.citycorporation, uisc_infos.citycorporationward, invoices.uisc_id');
            $this->db->select('SUM(invoices.total_income) total_income');
        } else {
            return false;
        }
        $CI->db->select('
                            invoices.uisc_id,
                            uisc_infos.uisc_type,
                            uisc_infos.user_group_id,
                            uisc_infos.uisc_name,
                            invoices.divid,
                            divisions.divname,
                            invoices.zillaid,
                            zillas.zillaname,
                            uisc_infos.citycorporation,
                            city_corporations.citycorporationname,
                            uisc_infos.citycorporationward,
                            city_corporation_wards.wardname,
                            invoices.invoice_id,
                            invoices.invoice_date,
                            invoices.total_income,
                            invoices.total_service,
                            invoices.total_men,
                            invoices.total_women
                        ');
        $CI->db->from($CI->config->item('table_invoices') . " invoices");
        $CI->db->join($CI->config->item('table_uisc_infos') . " uisc_infos", 'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $CI->db->join($CI->config->item('table_divisions') . " divisions", 'divisions.divid = invoices.divid', 'LEFT');
        $CI->db->join($CI->config->item('table_zillas') . " zillas", 'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $CI->db->join($CI->config->item('table_city_corporations') . " city_corporations", 'city_corporations.zillaid = uisc_infos.zilla AND city_corporations.citycorporationid = uisc_infos.citycorporation', 'LEFT');
        $CI->db->join($CI->config->item('table_city_corporation_wards') . " city_corporation_wards", 'city_corporation_wards.zillaid = uisc_infos.zilla AND city_corporation_wards.citycorporationid = uisc_infos.citycorporation AND city_corporation_wards.citycorporationwardid = uisc_infos.citycorporationward', 'LEFT');
        $CI->db->where('uisc_infos.uisc_type', $CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $CI->db->where('uisc_infos.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        $CI->db->where("invoices.invoice_date between '" . $from_date . "' AND '" . $to_date . "' ");
        $CI->db->order_by('invoices.divid, invoices.zillaid, uisc_infos.citycorporation, uisc_infos.citycorporationward, invoices.invoice_date', 'ASC');
        $result = $CI->db->get()->result_array();
        //echo $this->db->last_query();
        if (sizeof($result) > 0) {
            return $result;
        } else {
            return false;
        }

    }

    //////  END UPLOAD INCOME REPORT ////////////////

    public function get_municipal_by_div_id($divid)
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_municipals'));
        $CI->db->select(['rowid', 'zillaid']);
        $municipals = $CI->db->get()->result_array();

        $CI->db->from($CI->config->item('table_zillas'));
        $CI->db->select('zillaid');
        $CI->db->where('divid', $divid);
        $zillas = $CI->db->get()->result_array();

        $total_municipal = 0;
        foreach ($municipals as $municipal) {
            if (in_array($municipal['zillaid'], array_column($zillas, 'zillaid'))) {
                $total_municipal += 1;
            }
        }

        $data['total_zilla'] = count($zillas);
        $data['total_municipal'] = $total_municipal;

        return $data;
    }

    public function get_municipal_by_zilla_id($zillaid)
    {
        $CI = &get_instance();

        $CI->db->from($CI->config->item('table_municipals'));
        $CI->db->select(['count(rowid) total_municipal']);
        $CI->db->where('zillaid', $zillaid);
        $municipals = $CI->db->get()->result_array();

        $data['total_municipal'] = $municipals[0]['total_municipal'];

        return $data;
    }

}