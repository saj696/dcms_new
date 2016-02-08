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

            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $data['report_type']=$this->input->get('report_type');
            $status=$this->input->get('status');
            $data['month']=$month=$this->input->get('month');
            $data['year']=$year=$this->input->get('year');
            $from_date=$data['from_date']=$year.'-'.$month.'-01';
            $to_date=$data['to_date']=date('Y-m-t',strtotime($year.'-'.$month));
            $data['report_status']=$status;

            if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {

                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_UNION_TITLE");
                $data['upazila']=$upazila=$this->input->get('upazila');
                $union=$this->input->get('union');
                if(empty($data['upazila']))
                {
                    $data['upazilas']=Query_helper::get_info($this->config->item('table_upazilas'),'id',array('zillaid ='.$zilla));
                    $data['unions']=Query_helper::get_info($this->config->item('table_unions'),'rowid',array('zillaid ='.$zilla));
                }else
                {
                    $data['unions']=Query_helper::get_info($this->config->item('table_unions'),'rowid',array('zillaid ='.$zilla,'upazilaid ='.$data['upazila']));
                }

                $data['report']=$this->upload_report_model->get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_union_report',$data);
            }
            else if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_CITY_CORPORATION_TITLE");
                $data['city_corporation']=$city_corporation=$this->input->get('city_corporation');
                if(empty($city_corporation))
                {
                    $data['total_city_corporation']=count(Query_helper::get_info($this->config->item('table_city_corporations'),'rowid',array('zillaid ='.$zilla),1));
                    $data['total_city_corporation_ward']=count(Query_helper::get_info($this->config->item('table_city_corporation_wards'),'rowid',array('zillaid ='.$zilla),1));
                }
                $data['report']=$this->upload_report_model->get_city_corporation_report_upload_status($division, $zilla, $city_corporation, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_city_corporation_report',$data);
            }
            else if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
                $data['zilla']=$zilla;
                if(empty($zilla))
                {
                    $data['total']=$this->upload_report_model->get_municipal_by_div_id($division);
                }else
                {
                    $data['total']=$this->upload_report_model->get_municipal_by_zilla_id($zilla);
                }

                $data['report']=$this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $from_date, $to_date);
                $this->load->view('default/report/upload/upload_report_municipal_report',$data);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_TITLE");
                $data['report']='';
                $this->load->view('default/report/upload/upload_report_view',$data);
            }
        }
        else
        {
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $data['report_type']=$this->input->get('report_type');
            $status=$this->input->get('status');
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['report_status']=$status;

            if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_UNION_TITLE");
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');
                $data['report']=$this->upload_report_model->get_union_report_upload_status($division, $zilla, $upazila, $union, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_union_report',$data, true);
            }
            else if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_CITY_CORPORATION_TITLE");
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                $data['report']=$this->upload_report_model->get_city_corporation_report_upload_status($division, $zilla, $city_corporation, $city_corporation_ward, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_city_corporation_report',$data,true);
            }
            else if(!empty($status) && $this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_MUNICIPAL_TITLE");
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                $data['report']=$this->upload_report_model->get_municipal_report_upload_status($division, $zilla, $municipal, $municipal_ward, $from_date, $to_date);
                $html = $this->load->view('default/report/upload/upload_report_municipal_report',$data,true);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_UPLOAD_REPORT_TITLE");
                $data['report']='';
                $html = $this->load->view('default/report/upload/upload_report_view',$data, true);
            }
            System_helper::get_pdf($html);
        }
    }

}