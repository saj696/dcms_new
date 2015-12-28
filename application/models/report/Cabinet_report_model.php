<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabinet_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // all load model
    }

    //public function get_cabinet_union_income($division, $zilla, $upazila, $union)
    public function get_cabinet_union_income($from_date,$to_date)
    {
        $CI = & get_instance();
        //        if (!empty($division))
        //        {
        //            $this->db->where('divisions.divid',$division);
        //            if (!empty($zilla))
        //            {
        //                $this->db->where('zillas.zillaid',$zilla);
        //                if (!empty($upazila))
        //                {
        //                    $this->db->where('upa_zilas.upazilaid',$upazila);
        //                    if (!empty($union))
        //                    {
        //                        $this->db->where('unions.unionid',$union);
        //                    }
        //                }
        //            }
        //        }

        $f_date=strtotime($from_date);
        $t_date=strtotime($to_date);

        $result_array=array();
        $this->db->select
            ("
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                (
                SELECT COUNT(uisc_infos.id) FROM uisc_infos WHERE uisc_infos.`status`=1 AND uisc_infos.uisc_type=1 AND uisc_infos.division=divisions.divid AND uisc_infos.zilla=zillas.zillaid AND uisc_infos.create_date between '$f_date' AND '$t_date'
                ) total_udc,
                (
                SELECT COUNT(core_01_users.id) FROM core_01_users WHERE core_01_users.`status`=1 AND core_01_users.user_group_id=13 AND core_01_users.division=divisions.divid AND core_01_users.zilla=zillas.zillaid AND core_01_users.create_date between '$f_date' AND '$t_date'
                ) total_entrepreneur,
                (
                SELECT COUNT(invoices.invoice_id) FROM invoices WHERE invoices.divid=divisions.divid AND invoices.zillaid=zillas.zillaid AND invoices.invoice_date  BETWEEN '$from_date' AND '$to_date'
                ) total_report_upload,
                (
                SELECT SUM(invoices.total_income) FROM invoices WHERE invoices.divid=divisions.divid AND invoices.zillaid=zillas.zillaid AND invoices.invoice_date  BETWEEN '$from_date' AND '$to_date'
                ) total_income,
                (
                SELECT SUM(invoices.total_men + invoices.total_women  + invoices.total_disability + invoices.total_tribe) FROM invoices WHERE invoices.divid=divisions.divid AND invoices.zillaid=zillas.zillaid AND invoices.invoice_date  BETWEEN '$from_date' AND '$to_date'
                ) total_service_holder
            ", false);
        $this->db->from($CI->config->item('table_divisions')." divisions");
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = divisions.divid', 'LEFT');
        //$this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid','ASC');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            $result_array[$result[$i]['divid']]['division_id']=$result[$i]['divid'];
            $result_array[$result[$i]['divid']]['division_name']=$result[$i]['divname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_id']=$result[$i]['zillaid'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['zilla_name']=$result[$i]['zillaname'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['total_udc']=$result[$i]['total_udc'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['total_entrepreneur']=$result[$i]['total_entrepreneur'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['total_report_upload']=$result[$i]['total_report_upload'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['total_income']=$result[$i]['total_income'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['total_service_holder']=$result[$i]['total_service_holder'];

            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['upazilla_id']=$result[$i]['upazilaid'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['upazilla_name']=$result[$i]['upazilaname'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['union_id']=$result[$i]['unionid'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['union_name']=$result[$i]['unionname'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['total_udc']=$result[$i]['total_udc'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['total_entrepreneur']=$result[$i]['total_entrepreneur'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['total_report_upload']=$result[$i]['total_report_upload'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['total_income']=$result[$i]['total_income'];
            //            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['total_service_holder']=$result[$i]['total_service_holder'];
        }

        return $result_array;

    }

    public function get_cabinet_municipal_income($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date)
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
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                municipals.municipalid,
                municipals.municipalname,
                (
                SELECT count(municipal_wards.rowid) FROM ".$CI->config->item('table_municipal_wards')." municipal_wards WHERE municipal_wards.visible=1 AND municipal_wards.zillaid=zillas.zillaid AND municipal_wards.municipalid=municipals.municipalid
                ) as number_of_municipal,
                (
                SELECT count(uisc_infos.id) FROM uisc_infos WHERE uisc_infos.uisc_type='".$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID')."' AND uisc_infos.`status`='".$this->config->item('STATUS_ACTIVE')."' AND uisc_infos.division=divisions.divid AND uisc_infos.zilla=zillas.zillaid AND uisc_infos.municipal=municipals.municipalid
                ) as number_of_uisc
            ");
        $this->db->from($CI->config->item('table_divisions')." divisions");
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = divisions.divid', 'LEFT');
        $this->db->join($CI->config->item('table_municipals')." municipals",'municipals.zillaid = zillas.zillaid', 'LEFT');
        $this->db->where('zillas.visible',1);
        $this->db->where('municipals.visible',1);
        $this->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid','ASC');
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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['number_of_municipal']=$result[$i]['number_of_municipal'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['number_of_uisc']=$result[$i]['number_of_uisc'];

            $this->db->select
                ('
                    invoices.invoice_id,
                    invoices.uisc_id,
                    invoices.divid,
                    invoices.zillaid,
                    invoices.municipalid,
                    invoices.invoice_date,
                    SUM(invoices.total_income) total_income,
                    invoices.total_service,
                    invoices.total_men,
                    invoices.total_women
                ');
            $this->db->from($CI->config->item('table_invoices')." invoices");
            $this->db->where('invoices.divid', $result[$i]['divid']);
            $this->db->where('invoices.zillaid', $result[$i]['zillaid']);
            $this->db->where('invoices.municipalid', $result[$i]['municipalid']);
            $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
            $this->db->group_by('invoices.invoice_date');
            $invoice=$CI->db->get()->result_array();
            for($z=0; $z<sizeof($invoice); $z++)
            {
                $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['invoice'][]=array
                (
                    'invoice_date'=>$invoice[$z]['invoice_date'],
                    'invoice_amount'=>$invoice[$z]['total_income'],
                );
            }

        }

        return $result_array;

    }

    public function get_cabinet_city_corporation_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date)
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
                divisions.divid,
                divisions.divname,
                zillas.zillaid,
                zillas.zillaname,
                city_corporations.citycorporationid,
                city_corporations.citycorporationname,
                (
                SELECT count(city_corporation_wards.rowid) FROM ".$CI->config->item('table_city_corporation_wards')." city_corporation_wards WHERE city_corporation_wards.visible=1 AND city_corporation_wards.zillaid=zillas.zillaid AND city_corporation_wards.citycorporationid=city_corporations.citycorporationid
                ) as number_of_city_corporation,
                (
                SELECT count(uisc_infos.id) FROM ".$CI->config->item('table_uisc_infos')."  uisc_infos WHERE uisc_infos.uisc_type='".$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID')."' AND uisc_infos.`status`='".$this->config->item('STATUS_ACTIVE')."' AND uisc_infos.division=divisions.divid AND uisc_infos.zilla=zillas.zillaid AND uisc_infos.citycorporation=city_corporations.citycorporationid
                ) as number_of_uisc
            ");
        $this->db->from($CI->config->item('table_divisions')." divisions");
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = divisions.divid', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations')." city_corporations",'city_corporations.zillaid = zillas.zillaid', 'LEFT');
        $this->db->where('zillas.visible',1);
        $this->db->where('city_corporations.visible',1);
        $this->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid','ASC');
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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['number_of_city_corporation']=$result[$i]['number_of_city_corporation'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['number_of_uisc']=$result[$i]['number_of_uisc'];

            $this->db->select
                ('
                    invoices.invoice_id,
                    invoices.uisc_id,
                    invoices.divid,
                    invoices.zillaid,
                    invoices.citycorporationid,
                    invoices.invoice_date,
                    SUM(invoices.total_income) total_income,
                    invoices.total_service,
                    invoices.total_men,
                    invoices.total_women
                ');
            $this->db->from($CI->config->item('table_invoices')." invoices");
            $this->db->where('invoices.divid', $result[$i]['divid']);
            $this->db->where('invoices.zillaid', $result[$i]['zillaid']);
            $this->db->where('invoices.citycorporationid', $result[$i]['citycorporationid']);
            $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
            $this->db->group_by('invoices.invoice_date');
            $invoice=$CI->db->get()->result_array();
            for($z=0; $z<sizeof($invoice); $z++)
            {
                $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['invoice'][]=array
                (
                    'invoice_date'=>$invoice[$z]['invoice_date'],
                    'invoice_amount'=>$invoice[$z]['total_income'],
                );
            }

        }

        return $result_array;

    }
    //////  END CABINET INCOME  REPORT ////////////////

    //////  START CABINET SERVICE HOLDER INCOME REPORT //////////////

    public function get_cabinet_union_service_holder_income($division, $zilla, $upazila, $union, $from_date, $to_date, $status)
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
                SUM(invoices.total_income) total_income,
                SUM(invoices.total_service) total_service,
                SUM(invoices.total_men) total_men,
                SUM(invoices.total_women) total_women,
                SUM(invoices.total_tribe) total_tribe,
                SUM(invoices.total_disability) total_disability,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_men,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_men_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_women,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_women_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_disability,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_disability_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_tribe,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_tribe_income
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
        $this->db->group_by('divisions.divid, zillas.zillaid, upa_zilas.upazilaid, unions.unionid, invoices.uisc_id, invoices.invoice_date, invoices.invoice_id');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            if($status==$this->lang->line('MALE_VAL'))
            {
                $total_income=$result[$i]['details_total_men_income']?$result[$i]['details_total_men_income']:0;
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('FEMALE_VAL'))
            {
                $total_income=$result[$i]['details_total_women_income']?$result[$i]['details_total_women_income']:0;
                $total_men=0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('DISABILITY_VAL'))
            {
                $total_income=$result[$i]['details_total_disability_income']?$result[$i]['details_total_disability_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }
            elseif($status==$this->lang->line('TRIBE_VAL'))
            {
                $total_income=$result[$i]['details_total_tribe_income']?$result[$i]['details_total_tribe_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=0;
            }
            else
            {
                $total_income=($result[$i]['details_total_men_income']+$result[$i]['details_total_women_income']+$result[$i]['details_total_tribe_income']+$result[$i]['details_total_disability_income']);
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }

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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_men']=$total_men;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_women']=$total_women;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_tribe']=$total_tribe;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_disability']=$total_disability;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_income']=$total_income;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['upazilla'][$result[$i]['upazilaid']]['union'][$result[$i]['unionid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_service']=$result[$i]['total_service'];

        }

        return $result_array;

    }

    public function get_cabinet_municipal_service_holder_income($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date, $status)
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
                divisions.divname,
                zillas.zillaname,
                uisc_infos.uisc_name,
                uisc_infos.user_group_id,
                uisc_infos.uisc_type,
                invoices.invoice_date,
                SUM(invoices.total_income) total_income,
                SUM(invoices.total_service) total_service,
                SUM(invoices.total_men) total_men,
                SUM(invoices.total_women) total_women,
                SUM(invoices.total_tribe) total_tribe,
                SUM(invoices.total_disability) total_disability,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid, zillas.zillaid,
                municipals.municipalid,
                municipals.municipalname,
                municipal_wards.wardid,
                municipal_wards.wardname,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_men,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_men_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_women,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_women_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_disability,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_disability_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_tribe,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_tribe_income
            ", false);
        $this->db->from($CI->config->item('table_invoices')." invoices");
        $this->db->join($CI->config->item('table_uisc_infos')." uisc_infos",'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = invoices.divid', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $this->db->join($CI->config->item('table_municipals')." municipals",'municipals.zillaid = uisc_infos.zilla AND municipals.municipalid = uisc_infos.municipal', 'LEFT');
        $this->db->join($CI->config->item('table_municipal_wards')." municipal_wards",'municipal_wards.zillaid = uisc_infos.zilla AND municipal_wards.municipalid = uisc_infos.municipal AND municipal_wards.wardid = uisc_infos.municipalward', 'LEFT');
        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));
        $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid','ASC');
        $this->db->group_by('divisions.divid, zillas.zillaid, municipals.municipalid, municipal_wards.wardid, invoices.uisc_id, invoices.invoice_date, invoices.invoice_id');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            if($status==$this->lang->line('MALE_VAL'))
            {
                $total_income=$result[$i]['details_total_men_income']?$result[$i]['details_total_men_income']:0;
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('FEMALE_VAL'))
            {
                $total_income=$result[$i]['details_total_women_income']?$result[$i]['details_total_women_income']:0;
                $total_men=0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('DISABILITY_VAL'))
            {
                $total_income=$result[$i]['details_total_disability_income']?$result[$i]['details_total_disability_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }
            elseif($status==$this->lang->line('TRIBE_VAL'))
            {
                $total_income=$result[$i]['details_total_tribe_income']?$result[$i]['details_total_tribe_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=0;
            }
            else
            {
                $total_income=($result[$i]['details_total_men_income']+$result[$i]['details_total_women_income']+$result[$i]['details_total_tribe_income']+$result[$i]['details_total_disability_income']);
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }

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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['invoice_date']=$result[$i]['invoice_date'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_men']=$total_men;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_women']=$total_women;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_tribe']=$total_tribe;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_disability']=$total_disability;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_income']=$total_income;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['municipal'][$result[$i]['municipalid']]['municipal_ward'][$result[$i]['wardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_service']=$result[$i]['total_service'];

        }
        return $result_array;
    }

    public function get_cabinet_city_corporation_service_holder_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date, $status)
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
                divisions.divname,
                zillas.zillaname,
                uisc_infos.uisc_name,
                uisc_infos.user_group_id,
                uisc_infos.uisc_type,
                invoices.invoice_date,
                SUM(invoices.total_income) total_income,
                SUM(invoices.total_service) total_service,
                SUM(invoices.total_men) total_men,
                SUM(invoices.total_women) total_women,
                SUM(invoices.total_tribe) total_tribe,
                SUM(invoices.total_disability) total_disability,
                invoices.invoice_id,
                invoices.uisc_id,
                divisions.divid, zillas.zillaid,
                city_corporations.citycorporationid,
                city_corporations.citycorporationname,
                city_corporation_wards.citycorporationwardid,
                city_corporation_wards.wardname,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_men,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('MALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_men_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_women,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('FEMALE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_women_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_disability,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('DISABILITY_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_disability_income,
                (
                SELECT count(invoice_details.receiver_sex) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id, invoice_details.receiver_sex
                ) details_total_tribe,
                (
                SELECT sum(invoice_details.income) FROM ".$CI->config->item('table_invoice_details')." invoice_details WHERE invoice_details.invoice_id = invoices.invoice_id AND invoice_details.receiver_sex='".$this->lang->line('TRIBE_VAL')."' GROUP BY invoice_details.invoice_id
                ) details_total_tribe_income
            ", false);
        $this->db->from($CI->config->item('table_invoices')." invoices");
        $this->db->join($CI->config->item('table_uisc_infos')." uisc_infos",'uisc_infos.id = invoices.uisc_id', 'LEFT');
        $this->db->join($CI->config->item('table_divisions')." divisions",'divisions.divid = invoices.divid', 'LEFT');
        $this->db->join($CI->config->item('table_zillas')." zillas",'zillas.divid = invoices.divid AND zillas.zillaid = invoices.zillaid', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporations')." city_corporations",'city_corporations.zillaid = invoices.zillaid AND city_corporations.citycorporationid = invoices.citycorporationid', 'LEFT');
        $this->db->join($CI->config->item('table_city_corporation_wards')." city_corporation_wards",'city_corporation_wards.zillaid = city_corporations.zillaid AND city_corporation_wards.citycorporationid = city_corporations.citycorporationid AND uisc_infos.citycorporationward = city_corporation_wards.citycorporationwardid', 'LEFT');
        $this->db->where('uisc_infos.uisc_type',$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'));
        $this->db->where('uisc_infos.user_group_id',$this->config->item('UISC_GROUP_ID'));
        $this->db->where("invoices.invoice_date between '".$from_date."' AND '".$to_date."' ");
        $this->db->order_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, city_corporation_wards.citycorporationwardid','ASC');
        $this->db->group_by('divisions.divid, zillas.zillaid, city_corporations.citycorporationid, invoices.uisc_id, invoices.invoice_date, invoices.invoice_id');
        $result=$CI->db->get()->result_array();
        //echo $this->db->last_query();

        for($i=0; $i<sizeof($result); $i++)
        {
            if($status==$this->lang->line('MALE_VAL'))
            {
                $total_income=$result[$i]['details_total_men_income']?$result[$i]['details_total_men_income']:0;
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('FEMALE_VAL'))
            {
                $total_income=$result[$i]['details_total_women_income']?$result[$i]['details_total_women_income']:0;
                $total_men=0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=0;
                $total_disability=0;
            }
            elseif($status==$this->lang->line('DISABILITY_VAL'))
            {
                $total_income=$result[$i]['details_total_disability_income']?$result[$i]['details_total_disability_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }
            elseif($status==$this->lang->line('TRIBE_VAL'))
            {
                $total_income=$result[$i]['details_total_tribe_income']?$result[$i]['details_total_tribe_income']:0;
                $total_men=0;
                $total_women=0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=0;
            }
            else
            {
                $total_income=($result[$i]['details_total_men_income']+$result[$i]['details_total_women_income']+$result[$i]['details_total_tribe_income']+$result[$i]['details_total_disability_income']);
                $total_men=$result[$i]['details_total_men']?$result[$i]['details_total_men']:0;
                $total_women=$result[$i]['details_total_women']?$result[$i]['details_total_women']:0;
                $total_tribe=$result[$i]['details_total_tribe']?$result[$i]['details_total_tribe']:0;
                $total_disability=$result[$i]['details_total_disability']?$result[$i]['details_total_disability']:0;
            }

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
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['invoice_date']=$result[$i]['invoice_date'];
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_men']=$total_men;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_women']=$total_women;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_tribe']=$total_tribe;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_disability']=$total_disability;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_income']=$total_income;
            $result_array[$result[$i]['divid']]['zilla'][$result[$i]['zillaid']]['city_corporation'][$result[$i]['citycorporationid']]['city_corporation_ward'][$result[$i]['citycorporationwardid']]['uisc'][$result[$i]['uisc_id']]['invoice'][$result[$i]['invoice_date']]['total_service']=$result[$i]['total_service'];
        }
        return $result_array;
    }
    //////  END CABINET SERVICE HOLDER INCOME REPORT ////////////////

}