<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_report_view extends CI_Controller
{
    public $permissions;

    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/upload_report_model");

    }

    public function index($task = "search", $id = 0)
    {
        if ($task == "list") {
            $this->report_list();
        } else if ($task == "pdf") {
            $this->report_list("pdf");
        } else {
            $this->search();
        }
    }

    private function report_list($format = "")
    {
        if ($format != "pdf") {

            $division = $this->input->get('division');
            $data['zilla'] = $zilla = $this->input->get('zilla');
            $data['report_type'] = $this->input->get('report_type');
            $status = $this->input->get('status');
            $data['month'] = $month = $this->input->get('month');
            $data['year'] = $year = $this->input->get('year');
            $from_date = $data['from_date'] = $year . '-' . $month . '-01';
            $to_date = $data['to_date'] = date('Y-m-t', strtotime($year . '-' . $month));
            $data['report_status'] = $status;

            if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_UNION_GROUP_ID')) {

                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_UNION_TITLE");
                $data['upazila'] = $upazila = $this->input->get('upazila');
                $union = $this->input->get('union');
                $data['uisc_data'] = $this->upload_report_model->get_uisc($division, $zilla, $upazila, $union);
                $data['report'] = $this->upload_report_model->get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_union_report', $data);
            } else if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID')) {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_CITY_CORPORATION_TITLE");
                $data['city_corporation'] = $city_corporation = $this->input->get('city_corporation');
                $ward = $this->input->get('union');
                $data['uisc_data'] = $this->upload_report_model->get_uisc_for_cdc($division, $zilla, $city_corporation, $ward);
                $data['report'] = $this->upload_report_model->get_city_corporation_report_upload_status($division, $zilla, $city_corporation, $ward, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_city_corporation_report', $data);
            } else if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID')) {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
                $data['zilla'] = $zilla;
                $data['municipal']= $municipal = $city_corporation = $this->input->get('municipal');
                $ward = $this->input->get('municipal_ward');
                $data['uisc_data'] = $this->upload_report_model->get_uisc_for_pdc($division, $zilla, $municipal, $ward);

                $data['report'] = $this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $municipal,$ward, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_municipal_report', $data);
            } else {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_TITLE");
                $data['report'] = '';
                $this->load->view('default/report/upload/upload_report_view', $data);
            }
        } else {
            $division = $this->input->get('division');
            $zilla = $this->input->get('zilla');
            $data['report_type'] = $this->input->get('report_type');
            $status = $this->input->get('status');
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['report_status'] = $status;

            if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_UNION_GROUP_ID')) {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_UNION_TITLE");
                $upazila = $this->input->get('upazila');
                $union = $this->input->get('union');

                $data['report'] = $this->upload_report_model->get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_union_report', $data, true);
            } else if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID')) {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_CITY_CORPORATION_TITLE");
                $city_corporation = $this->input->get('city_corporation');
                $city_corporation_ward = $this->input->get('city_corporation_ward');
                $data['report'] = $this->upload_report_model->get_city_corporation_report_upload_status($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_city_corporation_report', $data, true);
            } else if (!empty($status) && $this->input->get('report_type') == $this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID')) {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
                $municipal = $this->input->get('municipal');
                $municipal_ward = $this->input->get('municipal_ward');
                $data['report'] = $this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_municipal_report', $data, true);
            } else {
                $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_TITLE");
                $data['report'] = '';
                $html = $this->load->view('default/report/upload/upload_report_view', $data, true);
            }
            System_helper::get_pdf($html);
        }
    }

}