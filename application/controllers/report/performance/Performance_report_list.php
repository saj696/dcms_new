<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Performance_report_list extends CI_Controller
{
    public $permissions;

    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/performance_report_model");
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
            $report_type = $this->input->get('report_type');
            $division = $this->input->get('division');
            $zilla = $this->input->get('zilla');
            $status = $this->input->get('status');
            $data['month']=$month=$this->input->get('month');
            $data['year']=$year=$this->input->get('year');
            $from_date=$data['from_date']=$year.'-'.$month.'-01';
            $to_date=$data['to_date']=date('Y-m-t',strtotime($year.'-'.$month));

            if ($report_type == 1) {
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');
                if($status==1)
                {
                    $data['title']="আয়ের ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==2)
                {
                    $data['title']="ই-সেবা সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==3)
                {
                    $data['title']="রিপোর্ট আপলোড সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }
                $data['reports'] = $this->performance_report_model->get_union_performance_report($division, $zilla, $upazila, $union,$status, $from_date, $to_date);
                $this->load->view('default/report/performance/performance_union_report', $data);
            }elseif($report_type==2)
            {
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                if($status==1)
                {
                    $data['title']="আয়ের ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==2)
                {
                    $data['title']="ই-সেবা সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==3)
                {
                    $data['title']="রিপোর্ট আপলোড সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }
                $data['reports'] = $this->performance_report_model->get_city_corporation_performance_report($division, $zilla, $city_corporation, $city_corporation_ward,$status, $from_date, $to_date);
                $this->load->view('default/report/performance/performance_city_corporation_report', $data);
            }elseif($report_type==3)
            {
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                if($status==1)
                {
                    $data['title']="আয়ের ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==2)
                {
                    $data['title']="ই-সেবা সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }elseif($status==3)
                {
                    $data['title']="রিপোর্ট আপলোড সংখ্যার ভিত্তিতে উদ্যোক্তা বৃন্দের পারফরম্যান্স সংক্রান্ত প্রতিবেদন";
                }
                $data['reports'] = $this->performance_report_model->get_municipal_performance_report($division, $zilla, $municipal, $municipal_ward ,$status, $from_date, $to_date);
                $this->load->view('default/report/performance/performance_municipal_report', $data);
            }



        } else {
            $data['title'] = $this->lang->line("REPORT_UPLOAD_REPORT_UNION_TITLE");
            $division = $this->input->get('division');
            $zilla = $this->input->get('zilla');
            $upazila = $this->input->get('upazila');
            $union = $this->input->get('union');
            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['report'] = $this->upload_report_model->get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date);
            $html = $this->load->view('default/report/upload/upload_report_union_report', $data, true);
            //echo $html;
            System_helper::get_pdf($html);
        }
    }

}