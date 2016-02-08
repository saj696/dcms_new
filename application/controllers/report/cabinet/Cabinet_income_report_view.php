<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabinet_income_report_view extends CI_Controller
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


            $data['report_type'] = $report_type = $this->input->get('report_type');
            $data['from_date'] = $from_date = $this->input->get('from_date');
            $data['to_date'] = $to_date = $this->input->get('to_date');

            if($report_type==1)
            {
                $data['title'] = $this->lang->line("REPORT_CABINET_UNION_INCOME_TITLE");
                $data['report'] = $this->cabinet_report_model->get_cabinet_union_income($from_date, $to_date);
                $this->load->view('default/report/cabinet/cabinet_union_income_report', $data);
            }elseif($report_type==2)
            {
                $data['title'] = $this->lang->line("REPORT_CABINET_CITY_CORPORATION_INCOME_TITLE");
                $data['report'] = $this->cabinet_report_model->get_cabinet_city_corporation_income($from_date, $to_date);
                $this->load->view('default/report/cabinet/cabinet_city_corporation_income_report', $data);
            }elseif($report_type==3)
            {
                $data['title'] = $this->lang->line("REPORT_CABINET_CITY_CORPORATION_INCOME_TITLE");
                $data['report'] = $this->cabinet_report_model->get_cabinet_municipal_income($from_date, $to_date);
                $this->load->view('default/report/cabinet/cabinet_municipal_income_report', $data);
            }


            //$division=$this->input->get('division');
            //$zilla=$this->input->get('zilla');
            //$data['report_type']=$this->input->get('report_type');
            //$status=$this->input->get('status');
            //            $from_date=$this->input->get('from_date');
            //            $to_date=$this->input->get('to_date');
            //            $data['from_date']=$from_date;
            //            $data['to_date']=$to_date;
            //            $data['report_status']=$status;


            //            if($this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            //            {
            //
            //                $data['title']=$this->lang->line("REPORT_CABINET_INCOME_TITLE");
            //                //$upazila=$this->input->get('upazila');
            //                //$union=$this->input->get('union');
            //                $data['report']=$this->cabinet_report_model->get_cabinet_union_income();
            //                $this->load->view('default/report/cabinet/cabinet_union_income_report',$data);
            //            }
            //            else if($this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            //            {
            //                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_CITY_CORPORATION_TITLE");
            //                $city_corporation=$this->input->get('city_corporation');
            //                $city_corporation_ward=$this->input->get('city_corporation_ward');
            //                $data['report']=$this->cabinet_report_model->get_cabinet_city_corporation_income($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date);
            //                $this->load->view('default/report/cabinet/cabinet_city_corporation_income_report',$data);
            //            }
            //            else if($this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            //            {
            //                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
            //                $municipal=$this->input->get('municipal');
            //                $municipal_ward=$this->input->get('municipal_ward');
            //                $data['report']=$this->cabinet_report_model->get_cabinet_municipal_income($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date);
            //                $this->load->view('default/report/cabinet/cabinet_municipal_income_report',$data);
            //            }
            //            else
            //            {
            //                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_TITLE");
            //                $data['report']='';
            //                $this->load->view('default/report/cabinet/cabinet_income_report_view',$data);
            //            }
        } else {

            $this->load->model("report/cabinet_report_model");
            $data['title'] = $this->lang->line("REPORT_CABINET_INCOME_TITLE");
            $division = $this->input->get('division');
            $zilla = $this->input->get('zilla');
            $upazila = $this->input->get('upazila');
            $union = $this->input->get('union');
            $data['report'] = $this->cabinet_report_model->get_cabinet_union_income($division, $zilla, $upazila, $union);
            $html = $this->load->view('default/report/cabinet/cabinet_union_income_report', $data, true);
            //echo $html;
            System_helper::get_pdf($html);
        }
    }

}