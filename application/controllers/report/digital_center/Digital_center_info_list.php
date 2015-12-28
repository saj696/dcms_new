<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Digital_center_info_list extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('report/digital_center/digital_center_info_list');
        //$this->controller_url='report/upload_report_model';
        $this->lang->load("report", $this->get_language());
        //$this->load->model("basic_setup/digital_center/digital_center_info_list_model");
    }

    public function index()
    {
        $user=User_helper::get_user();

        $ajax['status']=true;
        $data['title']=$this->lang->line("REPORT_DIGITAL_CENTER_INFO_TITLE");

        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("report/digital_center/digital_center_info_list",$data,true));
        $ajax['system_page_url']=$this->get_encoded_url('report/digital_center/digital_center_info_list');
        $this->jsonReturn($ajax);
    }
}
