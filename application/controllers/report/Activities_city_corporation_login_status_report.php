<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activities_city_corporation_login_status_report extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/uno_activities_login_status_model");
    }

    public function index($task="search",$id=0)
    {
        if($task=="list")
        {
            $this->report_list();
        }
        else if($task=="pdf")
        {
            $this->report_list("pdf");
        }
        else
        {
            $this->search();
        }
    }
    private function report_list($format="")
    {
        if($format!="pdf")
        {
            $data['title']=$this->lang->line("REPORT_CITY_CORPORATION_ACTIVITIES_LOGIN_STATUS_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $city_corporation=$this->input->get('city_corporation');
            $city_corporation_ward=$this->input->get('city_corporation_ward');
            $month=$this->input->get('month');
            $year=$this->input->get('year');
            $data['month']=$month;
            $data['year']=$year;
            $data['report']=$this->uno_activities_login_status_model->get_uisc_registration_city_corporation_info($division, $zilla, $city_corporation, $city_corporation_ward, $month, $year);
            $this->load->view('default/report/activities_city_corporation_login_status_report',$data);
        }
        else
        {
            $data['title']=$this->lang->line("REPORT_CITY_CORPORATION_ACTIVITIES_LOGIN_STATUS_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $city_corporation=$this->input->get('city_corporation');
            $city_corporation_ward=$this->input->get('city_corporation_ward');
            $month=$this->input->get('month');
            $year=$this->input->get('year');
            $data['month']=$month;
            $data['year']=$year;
            $data['report']=$this->uno_activities_login_status_model->get_uisc_registration_city_corporation_info($division, $zilla, $city_corporation, $city_corporation_ward, $month, $year);
            $html=$this->load->view('default/report/uno_activities_login_status_report',$data,true);
            //echo $html;
            System_helper::get_pdf($html);
        }
    }

}