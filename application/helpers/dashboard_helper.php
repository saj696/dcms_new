<?php
class Dashboard_helper
{
    // Center Count
    public static function get_center_count_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status', 1);
        $total=$CI->db->count_all_results();

        return $total;
    }
    public static function get_center_count_division($division_id)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('uisc_infos.division', $division_id);
        $total=$CI->db->count_all_results();
        return $total;
    }
    public static function get_center_count_zilla($zilla_id)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('uisc_infos.zilla', $zilla_id);
        $total=$CI->db->count_all_results();
        return $total;
    }
    public static function get_center_count_upazila($zilla_id,$upazilla_id)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('uisc_infos.zilla', $zilla_id);
        $CI->db->where('uisc_infos.upazilla', $upazilla_id);
        $total=$CI->db->count_all_results();
        return $total;
    }

    // User Count
    public static function get_uisc_user_count_all($gender=0)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.status', 1);
        $CI->db->where('users.user_group_level', $CI->config->item('UISC_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('users.gender', $gender);
        }
        $total=$CI->db->count_all_results();
        return $total;
    }
    public static function get_uisc_user_count_division($division_id,$gender=0)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.status', 1);
        $CI->db->where('users.user_group_level', $CI->config->item('DIVISION_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('users.gender', $gender);
        }
        $CI->db->where('users.division', $division_id);
        $total=$CI->db->count_all_results();
        return $total;
    }
    public static function get_uisc_user_count_zilla($zilla,$gender=0)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.status', 1);
        $CI->db->where('users.user_group_level', $CI->config->item('DISTRICT_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('users.gender', $gender);
        }
        $CI->db->where('users.zilla', $zilla);
        $total=$CI->db->count_all_results();
        return $total;
    }
    public static function get_uisc_user_count_upazila($zilla,$upazila,$gender=0)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->join($CI->config->item('table_entrepreneur_infos').' entrepreneur_infos','entrepreneur_infos.user_id = users.id', 'INNER');
        $CI->db->where('users.status', 1);
        //$CI->db->where('users.user_group_level', $CI->config->item('UPAZILLA_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('entrepreneur_infos.entrepreneur_sex', $gender);
        }
        $CI->db->where('users.upazila', $upazila);
        $CI->db->where('users.zilla', $zilla);
        $total=$CI->db->count_all_results();
        //echo $CI->db->last_query();
        return $total;
    }

    public static function get_division_services($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_services_uisc').' services_uisc' ,'services_uisc.uisc_id = uisc_infos.id','INNER' );
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('services_uisc.status', 1);
        $CI->db->where('uisc_infos.division', $division);
        $total = $CI->db->count_all_results();
        //TODO
        //need to count proposed services
        return $total;
    }
    public static function get_total_services_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_services_uisc').' services_uisc' ,'services_uisc.uisc_id = uisc_infos.id','INNER' );
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('services_uisc.status', 1);
        $CI->db->where('uisc_infos.zilla', $zilla);
        $total = $CI->db->count_all_results();
        //TODO
        //need to count proposed services
        return $total;
    }
    public static function get_total_services_upazilla($zilla,$upazilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_services_uisc').' services_uisc' ,'services_uisc.uisc_id = uisc_infos.id','INNER' );
        $CI->db->where('uisc_infos.status', 1);
        $CI->db->where('services_uisc.status', 1);
        $CI->db->where('uisc_infos.upazilla', $upazilla);
        $CI->db->where('uisc_infos.zilla', $zilla);
        $total = $CI->db->count_all_results();
        //TODO
        //need to count proposed services
        return $total;
    }


    // Invoice Count
    public static function get_total_invoices_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_invoices_division($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        $CI->db->where('divid',$division);
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_invoices_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        $CI->db->where('zillaid',$zilla);
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_invoices_upazila($zilla,$upazilla)
    {
        //        $CI = & get_instance();
        //        $CI->db->from($CI->config->item('table_invoices').' invoices');
        //        $CI->db->select_sum('total_income');
        //        $CI->db->where('upazilaid',$upazilla);
        //        $CI->db->where('zillaid',$zilla);
        //        $total = $CI->db->count_all_results();
        //        return $total;
    }


    // Income
    public static function get_total_invoice_income_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        $total_income = $CI->db->get()->result_array();
        return isset($total_income[0]['total_income']) ? $total_income[0]['total_income'] : 0 ;
    }
    public static function get_total_invoice_income_division($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        $CI->db->where('divid',$division);
        $total_income = $CI->db->get()->result_array();
        return isset($total_income[0]['total_income']) ? $total_income[0]['total_income'] : 0 ;
    }
    public static function get_total_invoice_income_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        $CI->db->where('zillaid',$zilla);
        $total_income = $CI->db->get()->result_array();
        return isset($total_income[0]['total_income']) ? $total_income[0]['total_income'] : 0 ;
    }
    public static function get_total_invoice_income_upazila($zilla,$upazilla)
    {
        //        $CI = & get_instance();
        //        $CI->db->from($CI->config->item('table_invoices').' invoices');
        //        $CI->db->select_sum('total_income');
        //        $CI->db->where('upazilaid',$upazilla);
        //        $CI->db->where('zillaid',$zilla);
        //        $total_income = $CI->db->get()->result_array();
        //        return isset($total_income[0]['total_income']) ? $total_income[0]['total_income'] : 0 ;
    }
    // Total inactive center
    public static function get_total_inactive_center_all()
    {
        $CI = & get_instance();
        $ystr_day = date('Y-m-d',strtotime("-1 day"));

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.uisc_id');
        $CI->db->where('invoices.invoice_date',$ystr_day);
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->select('uisc_infos.id,uisc_infos.uisc_name');
        $CI->db->where("`uisc_infos`.`id` NOT IN ($sub_query)", NULL, FALSE);
        $CI->db->group_by('uisc_infos.id');
        $query = $CI->db->get();
        return $query->num_rows();
    }
    public static function get_total_inactive_center_division($division)
    {
        $CI = & get_instance();
        $ystr_day = date('Y-m-d',strtotime("-1 day"));

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.uisc_id');
        $CI->db->where('invoices.invoice_date',$ystr_day);
        $CI->db->where('invoices.divid',$division);
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->select('uisc_infos.id,uisc_infos.uisc_name');
        $CI->db->where("`uisc_infos`.`id` NOT IN ($sub_query)", NULL, FALSE);
        $CI->db->where('uisc_infos.division',$division);
        $query = $CI->db->get();
        return $query->num_rows();
    }
    public static function get_total_inactive_center_zilla($zilla)
    {
        $CI = & get_instance();
        $ystr_day = date('Y-m-d',strtotime("-1 day"));

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.uisc_id');
        $CI->db->where('invoices.invoice_date',$ystr_day);
        $CI->db->where('invoices.zillaid',$zilla);
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->select('uisc_infos.id,uisc_infos.uisc_name');
        $CI->db->where("`uisc_infos`.`id` NOT IN ($sub_query)", NULL, FALSE);
        $CI->db->where('uisc_infos.zilla',$zilla);
        $query = $CI->db->get();
        return $query->num_rows();
    }
    public static function get_total_inactive_center_upazilla($zilla,$upazilla)
    {
        //        $CI = & get_instance();
        //        $ystr_day = date('Y-m-d',strtotime("-1 day"));
        //
        //        $CI->db->from($CI->config->item('table_invoices').' invoices');
        //        $CI->db->select('invoices.uisc_id');
        //        $CI->db->where('invoices.invoice_date',$ystr_day);
        //        $CI->db->where('invoices.upazilaid',$upazilla);
        //        $CI->db->where('invoices.zillaid',$zilla);
        //        $sub_query = $CI->db->get_compiled_select();
        //
        //        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        //        $CI->db->select('uisc_infos.id,uisc_infos.uisc_name');
        //        $CI->db->where("`uisc_infos`.`id` NOT IN ($sub_query)", NULL, FALSE);
        //        $CI->db->where('uisc_infos.upazilla',$upazilla);
        //        $CI->db->where('uisc_infos.zilla',$zilla);
        //        $query = $CI->db->get();
        //        return $query->num_rows();
    }


    // GET APPROVAL COUNT
    public static function get_total_approval_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.user_group_level',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('users.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_approval_division($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.user_group_level',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('users.division',$division);
        $CI->db->where('users.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_approval_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.user_group_level',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('users.zilla',$zilla);
        $CI->db->where('users.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_approval_upazilla($zilla,$upazilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->where('users.user_group_level',$CI->config->item('UISC_GROUP_ID'));
        $CI->db->where('users.upazila',$upazilla);
        $CI->db->where('users.zilla',$zilla);
        $CI->db->where('users.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }


    // GET NOTICE COUNT
    public static function get_total_notice_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_notice').' notice');
        $CI->db->where('notice.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();

        return $total;
    }
    public static function get_total_notice_division()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_notice_view').' notice_view');
        $CI->db->where('notice_view.viewer_user_group',$CI->config->item('DIVISION_GROUP_ID'));
        $CI->db->where('notice_view.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();

        return $total;
    }
    public static function get_total_notice_zilla()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_notice_view').' notice_view');
        $CI->db->where('notice_view.viewer_user_group',$CI->config->item('DISTRICT_GROUP_ID'));
        $CI->db->where('notice_view.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();

        return $total;
    }
    public static function get_total_notice_upazila()
    {
        //        $CI = & get_instance();
        //        $CI->db->from($CI->config->item('table_notice_view').' notice_view');
        //        $CI->db->where('notice_view.viewer_group_id',$CI->config->item('UPAZILLA_GROUP_ID'));
        //        $CI->db->where('notice_view.status',$CI->config->item('STATUS_ACTIVE'));
        //        $total = $CI->db->count_all_results();

        //        return $total;
    }


    // GET FAQs COUNT
    public static function get_total_faqs_all()
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_faqs').' faqs');
        $CI->db->where('faqs.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();

        return $total;
    }
    public static function get_total_faqs_division($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_faqs').' faqs' ,'faqs.uisc_id = uisc_infos.id','LEFT' );
        $CI->db->where('uisc_infos.division',$division);
        $CI->db->where('uisc_infos.status',$CI->config->item('STATUS_ACTIVE'));
        $CI->db->where('faqs.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_faqs_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_faqs').' faqs' ,'faqs.uisc_id = uisc_infos.id','LEFT' );
        $CI->db->where('uisc_infos.zilla',$zilla);
        $CI->db->where('uisc_infos.status',$CI->config->item('STATUS_ACTIVE'));
        $CI->db->where('faqs.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }
    public static function get_total_faqs_upazila($zilla,$upazilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_faqs').' faqs' ,'faqs.uisc_id = uisc_infos.id','LEFT' );
        $CI->db->where('uisc_infos.zilla',$zilla);
        $CI->db->where('uisc_infos.upazilla',$upazilla);
        $CI->db->where('uisc_infos.status',$CI->config->item('STATUS_ACTIVE'));
        $CI->db->where('faqs.status',$CI->config->item('STATUS_ACTIVE'));
        $total = $CI->db->count_all_results();
        return $total;
    }




    //total male & female Count For pie chart
    public static function get_total_male_female_user_all()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {

        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
            $CI->db->where('invoices.unionid',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.municipalid',$user->municipal);
        }

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_men');
        $CI->db->select_sum('total_women');
        $total = $CI->db->get()->result_array();
        if(isset($total[0]['total_men']))
        {
            $total_user = $total[0]['total_men'] + $total[0]['total_women'];
            $data['male']= round(($total[0]['total_men']*100)/$total_user, 2);
            $data['female']= round(($total[0]['total_women']*100)/$total_user, 2);
        }
        else
        {
            $data['male'] = 0;
            $data['female'] = 0;
        }
        return $data;
    }
    public static function get_total_male_female_user_division($division)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_men');
        $CI->db->select_sum('total_women');
        $CI->db->where('divid',$division);
        $total = $CI->db->get()->result_array();
        if(isset($total[0]['total_men']))
        {
            $total_user = $total[0]['total_men'] + $total[0]['total_women'];
            $data['male']= round(($total[0]['total_men']*100)/$total_user, 2);
            $data['female']= round(($total[0]['total_women']*100)/$total_user, 2);
        }
        else
        {
            $data['male'] = 0;
            $data['female'] = 0;
        }
        return $data;
    }
    public static function get_total_male_female_user_zilla($zilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_men');
        $CI->db->select_sum('total_women');
        $CI->db->where('zillaid',$zilla);
        $total = $CI->db->get()->result_array();
        if(isset($total[0]['total_men']))
        {
            $total_user = $total[0]['total_men'] + $total[0]['total_women'];
            $data['male']= round(($total[0]['total_men']*100)/$total_user, 2);
            $data['female']= round(($total[0]['total_women']*100)/$total_user, 2);
        }
        else
        {
            $data['male'] = 0;
            $data['female'] = 0;
        }
        return $data;
    }
    public static function get_total_male_female_user_upazila($zilla,$upazilla)
    {
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_men');
        $CI->db->select_sum('total_women');
        $CI->db->where('upazilaid',$upazilla);
        $CI->db->where('zillaid',$zilla);
        $total = $CI->db->get()->result_array();
        if(isset($total[0]['total_men']))
        {
            $total_user = $total[0]['total_men'] + $total[0]['total_women'];
            $data['male']= round(($total[0]['total_men']*100)/$total_user, 2);
            $data['female']= round(($total[0]['total_women']*100)/$total_user, 2);
        }
        else
        {
            $data['male'] = 0;
            $data['female'] = 0;
        }
        return $data;
    }


    // total income for highcharts

    public static function get_super_admin_of_invoices()
    {
        $week_start_date = date('Y-m-d',strtotime("-7 day"));
        $today = date('Y-m-d',time());
        $CI = & get_instance();
        $user = User_helper::get_user();

        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            $CI->db->select('invoices.divid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            //$CI->db->where('invoices.divid',$user->division);
            $CI->db->select('invoices.zillaid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid');
            $CI->db->where('invoices.divid',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->select('invoices.upazilaid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid, invoices.upazilaid');
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->select('invoices.unionid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid, invoices.upazilaid, invoices.unionid');
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->select('invoices.unionid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid, invoices.upazilaid, invoices.unionid');
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
            $CI->db->where('invoices.unionid',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->select('invoices.citycorporationid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid, invoices.citycorporationid');
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->select('invoices.municipalid element_name, SUM(invoice_details.income) element_value');
            $CI->db->group_by('invoices.divid, invoices.zillaid, invoices.municipalid');
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.municipalid',$user->municipal);
        }
        $CI->db->where('invoices.invoice_date >=',$week_start_date);
        $CI->db->where('invoices.invoice_date <=',$today);
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->join($CI->config->item('table_invoice_details').' invoice_details','invoice_details.invoice_id = invoices.invoice_id', 'INNER');
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        return $result;
    }

    public static function get_division_wise_income()
    {
        $week_start_date = date('Y-m-d',strtotime("-7 day"));
        $today = date('Y-m-d',time());
        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.divid,SUM(invoices.total_income) as income, ');
        $CI->db->where('invoices.invoice_date >=',$week_start_date);
        $CI->db->where('invoices.invoice_date <=',$today);
        $CI->db->group_by('invoices.divid');
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_divisions').' divisions');
        $CI->db->select('divisions.divname  name, invoices.income');
        $CI->db->join('('.$sub_query.') invoices','invoices.divid = divisions.divid','LEFT');
        $divisions = $CI->db->get()->result_array();
        return $divisions;
    }

    public static function get_district_wise_income($division_id)
    {
        $week_start_date = date('Y-m-d',strtotime("-7 day"));
        $today = date('Y-m-d',time());

        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.zillaid,SUM(invoices.total_income) as income, ');
        $CI->db->where('invoices.invoice_date >=',$week_start_date);
        $CI->db->where('invoices.invoice_date <=',$today);
        $CI->db->group_by('invoices.zillaid');
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_zillas').' zillas');
        $CI->db->select('zillas.zillaname  name, invoices.income');
        $CI->db->where('zillas.divid',$division_id);
        $CI->db->join('('.$sub_query.') invoices','invoices.zillaid = zillas.zillaid','LEFT');
        $districts = $CI->db->get()->result_array();

        return $districts;
    }
    public static function get_upazilla_wise_income($zilla_id)
    {
        $week_start_date = date('Y-m-d',strtotime("-7 day"));
        $today = date('Y-m-d',time());
        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.upazilaid,SUM(invoices.total_income) as income, ');
        $CI->db->where('invoices.invoice_date >=',$week_start_date);
        $CI->db->where('invoices.invoice_date <=',$today);
        $CI->db->group_by('invoices.upazilaid');
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_upazilas').' upazilas');
        $CI->db->select('upazilas.upazilaname  name, invoices.income');
        $CI->db->where('upazilas.zillaid',$zilla_id);
        $CI->db->join('('.$sub_query.') invoices','invoices.upazilaid = upazilas.upazilaid','LEFT');
        $upazilas = $CI->db->get()->result_array();
        return $upazilas;
    }
    public static function get_union_wise_income($zilla_id,$upazilla_id)
    {
        $week_start_date = date('Y-m-d',strtotime("-7 day"));
        $today = date('Y-m-d',time());

        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select('invoices.unionid,SUM(invoices.total_income) as income, ');
        $CI->db->where('invoices.invoice_date >=',$week_start_date);
        $CI->db->where('invoices.invoice_date <=',$today);
        $CI->db->group_by('invoices.unionid');
        $sub_query = $CI->db->get_compiled_select();

        $CI->db->from($CI->config->item('table_unions').' unions');
        $CI->db->select('unions.unionname  name, invoices.income');
        $CI->db->where('unions.upazilaid',$upazilla_id);
        $CI->db->where('unions.zillaid',$zilla_id);
        $CI->db->join('('.$sub_query.') invoices','invoices.unionid = unions.unionid','LEFT');
        $unions = $CI->db->get()->result_array();

        return $unions;
    }

    // UISC CHART
    public static function  get_uisc_weekly_income($user)
    {
        $CI = & get_instance();
        for($i=1; $i<=7; $i++)
        {
            $day= date('Y-m-d',strtotime("-$i day"));

            $CI->db->from($CI->config->item('table_invoices'));
            $CI->db->select('total_income');
            /*$CI->db->where('zillaid',$user->zilla);
            $CI->db->where('upazilaid',$user->upazila);
            $CI->db->where('unionid',$user->unioun);*/
            $CI->db->where('invoices.uisc_id', $user->uisc_id);
            $CI->db->where('invoice_date',$day);
            $query = $CI->db->get();
            $data = $query->row();

            $days[$i]['day']= date('d-m-Y',strtotime("-$i day"));
            $days[$i]['income']= isset($data->total_income) ? $data->total_income : 0;
        }
     return $days;
    }
    public static function get_max_income_uisc($zilla, $upazilla, $union)
    {
        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices'));
        $CI->db->select_max('total_income');
        $CI->db->where('zillaid',$zilla);
        $CI->db->where('upazilaid',$upazilla);
        $CI->db->where('unionid',$union);
        $data = $CI->db->get()->result_array();
        return isset($data[0]['total_income']) ? $data[0]['total_income'] : 0;
    }
    public static function get_min_income_uisc($zilla, $upazilla, $union)
    {
        $CI = & get_instance();

        $CI->db->from($CI->config->item('table_invoices'));
        $CI->db->select_min('total_income');
        $CI->db->where('zillaid',$zilla);
        $CI->db->where('upazilaid',$upazilla);
        $CI->db->where('unionid',$union);
        $data = $CI->db->get()->result_array();
        return isset($data[0]['total_income']) ? $data[0]['total_income'] : 0;
    }
    public static function get_investment_uisc($uisc_id,$user_id)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_investment').' invest');
        $CI->db->select('invest.*');
        $CI->db->where('invest.uisc_id', $uisc_id);
        $CI->db->where('invest.user_id', $user_id);
        $data = $CI->db->get()->row_array();

        return isset($data['invested_money']) ? $data['invested_money'] : 0;
    }
    public static function get_electricity_info_uisc($uisc_id,$user_id)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_electricity').' electricity');
        $CI->db->select('electricity.electricity');
        $CI->db->where('electricity.uisc_id', $uisc_id);
        $CI->db->where('electricity.user_id', $user_id);
        $results = $CI->db->get()->row_array();

        return $results;
    }
    public static function get_loacation_info_uisc($uisc_id,$user_id)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_center_location').' location');
        $CI->db->select('location.*');
        $CI->db->where('location.uisc_id', $uisc_id);
        $CI->db->where('location.user_id', $user_id);
        $results = $CI->db->get()->row_array();
        return $results;
    }

    /////// START DASHBOARD FUNCTION
    public static function get_number_of_uisc_user_dashboard($gender=null)
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_users').' users');
        $CI->db->join($CI->config->item('table_entrepreneur_infos').' entrepreneur_infos','entrepreneur_infos.user_id = users.id', 'INNER');
        $CI->db->where('users.status', $CI->config->item('STATUS_ACTIVE'));
        //$CI->db->where('users.user_group_level', $CI->config->item('UPAZILLA_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('entrepreneur_infos.entrepreneur_sex', $gender);
        }

        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.upazila',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.upazila',$user->upazila);
            $CI->db->where('users.unioun',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.citycorporation',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.citycorporation',$user->citycorporation);
            $CI->db->where('users.citycorporationward',$user->citycorporationward);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.municipal',$user->municipal);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
        {
            $CI->db->where('users.division',$user->division);
            $CI->db->where('users.zilla',$user->zilla);
            $CI->db->where('users.municipal',$user->municipal);
            $CI->db->where('users.municipalward',$user->municipalward);
        }
        else
        {
            //$CI->db->where('','');
        }
        $total=$CI->db->count_all_results();
        //echo $CI->db->last_query();
        return $total;
    }

    // Service Count
    public static function get_number_of_uisc_service()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_services').' services');
        $CI->db->where('services.status', 1);
        $total=$CI->db->count_all_results();
        //echo $CI->db->last_query();
        //TODO
        //need to count proposed services
        return $total;
    }

    public static function get_total_invoice_income()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->select_sum('total_income');
        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilla',$user->upazila);
            $CI->db->where('invoices.union',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.municipalid',$user->municipal);
        }

        $total_income = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        return isset($total_income[0]['total_income']) ? $total_income[0]['total_income'] : 0 ;
    }

    public static function get_number_of_center($status)
    {

        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status',$status);

        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.upazilla',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.upazilla',$user->upazila);
            $CI->db->where('uisc_infos.union',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.citycorporation',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.citycorporation',$user->citycorporation);
            $CI->db->where('uisc_infos.citycorporationward',$user->citycorporationward);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.municipal',$user->municipal);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.municipal',$user->municipal);
            $CI->db->where('uisc_infos.municipalward',$user->municipalward);
        }
        else
        {
            //$CI->db->where('','');
        }

        $query = $CI->db->get();
        $result=$query->num_rows();
        //echo $CI->db->last_query();
        return $result;
    }

    public static function get_number_of_notice($status)
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_notice_view').' notice_view');
        $CI->db->where('notice_view.status',$status);
        $CI->db->where('notice_view.viewer_user_group',$user->user_group_level);
        $total = $CI->db->count_all_results();
        //echo $CI->db->last_query();
        return $total?$total:0;
    }

    public static function get_number_of_faqs($status, $faqs_status)
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->join($CI->config->item('table_faqs').' faqs' ,'faqs.uisc_id = uisc_infos.id','LEFT' );
        $CI->db->where('uisc_infos.status',$status);
        $CI->db->where('faqs.status',$faqs_status);

        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.upazilla',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.upazilla',$user->upazila);
            $CI->db->where('uisc_infos.union',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.citycorporation',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.citycorporation',$user->citycorporation);
            $CI->db->where('uisc_infos.citycorporationward',$user->citycorporationward);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.municipal',$user->municipal);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division',$user->division);
            $CI->db->where('uisc_infos.zilla',$user->zilla);
            $CI->db->where('uisc_infos.municipal',$user->municipal);
            $CI->db->where('uisc_infos.municipalward',$user->municipalward);
        }
        else
        {
            //$CI->db->where('','');
        }

        $total = $CI->db->count_all_results();
        return $total;
    }

    public static function get_yesterday_to_digital_center()
    {
        $yesterday_date = date('Y-m-d',strtotime("-1 day"));
        $user=User_helper::get_user();
        $CI = & get_instance();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        $CI->db->join($CI->config->item('table_uisc_infos').' uisc_infos' ,'uisc_infos.id = invoices.uisc_id','INNER' );
        $CI->db->where('invoices.invoice_date',$yesterday_date);
        $CI->db->order_by('SUM(invoices.total_income)','DESC');
        $CI->db->limit(1,0);
        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilla',$user->upazila);
            $CI->db->where('invoices.union',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.municipalid',$user->municipal);
        }
        $result = $CI->db->get()->result_array();
        //echo $CI->db->last_query();
        return $result[0]['uisc_name']?$result[0]['uisc_name']:$CI->lang->line('DATA_NOT_FOUND');
    }

    public static function get_number_of_invoices()
    {
        $CI = & get_instance();
        $user = User_helper::get_user();
        $CI->db->from($CI->config->item('table_invoices').' invoices');
        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            //$CI->db->where('','');
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilaid',$user->upazila);
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.upazilla',$user->upazila);
            $CI->db->where('invoices.union',$user->unioun);
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.municipalid',$user->municipal);
        }
        $total = $CI->db->count_all_results();
        return $total;
    }

    public static function get_entrepreneur_info($uisc_id,$user_id)
    {
        $CI =& get_instance();

        $CI->db->from($CI->config->item('table_entrepreneur_infos').' entrepreneur');
        $CI->db->select('entrepreneur.*');
        $CI->db->where('entrepreneur.uisc_id', $uisc_id);
        $CI->db->where('entrepreneur.user_id', $user_id);
        $result = $CI->db->get()->row_array();

        return $result;
    }

    public static function get_div_zilla_upazilla($element_id)
    {
        $CI = & get_instance();
        $user=User_helper::get_user();

        if($user->user_group_level==$CI->config->item('SUPER_ADMIN_GROUP_ID') || $user->user_group_level==$CI->config->item('A_TO_I_GROUP_ID') || $user->user_group_level==$CI->config->item('DONOR_GROUP_ID') || $user->user_group_level==$CI->config->item('MINISTRY_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_divisions'),array('divname name'), array('divid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        elseif($user->user_group_level==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_zillas'),array('zillaname name'), array('divid = '.$user->division, 'zillaid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        elseif($user->user_group_level==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_upazilas'),array('upazilaname name'), array('zillaid = '.$user->zilla, 'upazilaid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        elseif($user->user_group_level==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_unions'),array('unionname name'), array('zillaid = '.$user->zilla, 'upazilaid = '.$user->upazila, 'unionid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        elseif($user->user_group_level==$CI->config->item('UNION_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_unions'),array('unionname name'), array('zillaid = '.$user->zilla, 'upazilaid = '.$user->upazila, 'unionid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        elseif($user->user_group_level==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_city_corporations'),array('citycorporationname name'), array('zillaid = '.$user->zilla, 'citycorporationid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
            $CI->db->where('invoices.divid',$user->division);
            $CI->db->where('invoices.zillaid',$user->zilla);
            $CI->db->where('invoices.citycorporationid',$user->citycorporation);
        }
        elseif($user->user_group_level==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $element = Query_helper::get_info($CI->config->item('table_municipals'),array('municipalname name'), array('zillaid = '.$user->zilla, 'municipalid = '.$element_id));
            if(isset($element[0]['name'])){$name=  $element[0]['name'];}else{$name=  '';};
        }
        else
        {
            $name='';
        }
        return $name?$name:'';
    }

}