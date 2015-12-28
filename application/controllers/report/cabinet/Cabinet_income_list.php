<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabinet_income_list extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('report/cabinet/cabinet_income_list');
        //$this->controller_url='report/upload_report_model';
        $this->lang->load("report", $this->get_language());
        //$this->load->model("basic_setup/cabinet/cabinet_income_list_model");
    }

    public function index()
    {
        $user=User_helper::get_user();

        $ajax['status']=true;
        $data['title']=$this->lang->line("REPORT_CABINET_INCOME_TITLE");

        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("report/cabinet/cabinet_income_list",$data,true));
        $ajax['system_page_url']=$this->get_encoded_url('report/cabinet/cabinet_income_list');
        $this->jsonReturn($ajax);
    }
}
