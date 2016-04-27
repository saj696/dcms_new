<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_update_status_report extends Root_Controller
{

    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;

    function __construct()
    {
        parent::__construct();
        $this->message = '';
        $this->permissions=Menu_helper::get_permission('report/profile_update_status/Profile_update_status_report');
       // $this->controller_url='report/profile_update_status/Profile_update_status_report';
        //$this->load->model("report/Profile_update_status_report_model");
        $this->lang->load('report_lang');
    }

    public function index()
    {
        $user = User_helper::get_user();

        $ajax['status'] = true;
        $data['title'] = $this->lang->line("PROFILE_UPDATE_STATUS_REPORT");

        $ajax['system_content'][] = array("id" => "#system_wrapper_top_menu", "html" => $this->load_view("top_menu", "", true));
        $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("report/profile_update_status/profile_update_status_report", $data, true));
        $ajax['system_page_url'] = $this->get_encoded_url('report/profile_update_status/profile_update_status_report');
        $this->jsonReturn($ajax);
    }


}
