<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_report_list extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('report/services/services_info_list');
        //$this->controller_url='report/upload_report_model';
        $this->lang->load("report", $this->get_language());
        $this->load->model("report/services_report_list_model");
    }

    public function index()
    {
        $user=User_helper::get_user();

        $ajax['status']=true;
        $data['title']=$this->lang->line("SERVICE_BASED_REPORT");

        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $data['services']=$this->services_report_list_model->get_services();
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("report/services/services_report_list",$data,true));
        $ajax['system_page_url']=$this->get_encoded_url('report/services/services_report_list');
        $this->jsonReturn($ajax);
    }
}
