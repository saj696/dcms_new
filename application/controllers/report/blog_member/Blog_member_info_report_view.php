<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_member_info_report_view extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/blog_member_info_report_model");
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

            if($this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {

                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_UNION_TITLE");
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_union($division, $zilla, $upazila, $union);
                $this->load->view('default/report/blog_member/blog_member_info_union_report',$data);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_CITY_CORPORATION_TITLE");
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward);
                $this->load->view('default/report/blog_member/blog_member_info_city_corporation_report',$data);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_MUNICIPAL_TITLE");
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_municipal($division, $zilla, $municipal, $municipal_ward);
                $this->load->view('default/report/blog_member/blog_member_info_municipal_report',$data);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $data['report']='';
                $this->load->view('default/report/blog_member/blog_member_info_report_view',$data);
            }
        }
        else
        {
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $data['report_type']=$this->input->get('report_type');

            if($this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_UNION_TITLE");
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_union($division, $zilla, $upazila, $union);
                $html = $this->load->view('default/report/blog_member/blog_member_info_union_report',$data, true);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_CITY_CORPORATION_TITLE");
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward);
                $html = $this->load->view('default/report/blog_member/blog_member_info_city_corporation_report',$data, true);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_BLOG_MEMBER_INFO_MUNICIPAL_TITLE");
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                $data['report']=$this->blog_member_info_report_model->get_blog_member_info_municipal($division, $zilla, $municipal, $municipal_ward);
                $html = $this->load->view('default/report/blog_member/blog_member_info_municipal_report',$data, true);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $data['report']='';
                $html = $this->load->view('default/report/blog_member/blog_member_info_report_view',$data, true);
            }
            System_helper::get_pdf($html);
        }
    }

}