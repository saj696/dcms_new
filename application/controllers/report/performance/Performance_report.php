<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Performance_report extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->message='';
        $this->permissions=Menu_helper::get_permission('report/performance/performance_report');
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/performance_report_model");

    }

    public function index($task="list",$id=0)
    {
        if($task=="list")
        {
            $this->dcms_index();
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

    private function dcms_index()
    {

        $user=User_helper::get_user();

        $ajax['status']=true;
        $data['title']=$this->lang->line("PERFORMANCE_REPORT_TITLE");

        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("report/performance/performance_report_list",$data,true));
        $ajax['system_page_url']=$this->get_encoded_url('report/performance/performance_report');
        $this->jsonReturn($ajax);
    }

}