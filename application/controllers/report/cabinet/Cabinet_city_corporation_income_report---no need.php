<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabinet_city_corporation_income_report extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/cabinet_report_model");
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
            $data['title']=$this->lang->line("REPORT_CABINET_CITY_CORPORATION_INCOME_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $city_corporation=$this->input->get('city_corporation');
            $city_corporation_ward=$this->input->get('city_corporation_ward');
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['report']=$this->cabinet_report_model->get_cabinet_city_corporation_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date);
            $this->load->view('default/report/cabinet/cabinet_city_corporation_income_report',$data);
        }
        else
        {
            $data['title']=$this->lang->line("REPORT_CABINET_CITY_CORPORATION_INCOME_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $city_corporation=$this->input->get('city_corporation');
            $city_corporation_ward=$this->input->get('city_corporation_ward');
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['report']=$this->cabinet_report_model->get_cabinet_city_corporation_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date);
            $html=$this->load->view('default/report/cabinet/cabinet_city_corporation_income_report',$data,true);
            //echo $html;
            System_helper::get_pdf($html);
        }
    }

}