<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_report_municipal_report extends CI_Controller
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
            $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $municipal=$this->input->get('municipal');
            $municipal_ward=$this->input->get('municipal_ward');
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['report']=$this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date);
            $this->load->view('default/report/upload/upload_report_municipal_report',$data);
        }
        else
        {
            $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $municipal=$this->input->get('municipal');
            $municipal_ward=$this->input->get('municipal_ward');
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['report']=$this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date);
            $html=$this->load->view('default/report/upload/upload_report_municipal_report',$data,true);
            //echo $html;
            System_helper::get_pdf($html);
        }
    }

}