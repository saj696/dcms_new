<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class External_service extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;

    function __construct()
    {
        parent::__construct();
        $this->message = '';
        $this->permissions = Menu_helper::get_permission('esheba_management/External_service');
        $this->controller_url = 'esheba_management/external_service';
        //$this->load->model("esheba_management/External_service_model");

    }

    public function index($action = 'list', $id = 0)
    {
        $this->current_action = $action;

        if ($action == 'list') {
            $this->dcms_list();
        }  else {
            $this->current_action = 'list';
            $this->dcms_list();
        }
    }

    private function dcms_list()
    {
        if ($this->permissions['list']) {
            $this->current_action = 'list';
            $ajax['status'] = true;
            //$ajax['system_content'][] = array("id" => "#system_wrapper_top_menu", "html" => $this->load_view("top_menu", "", true));
            $data['services']=Query_helper::get_info($this->config->item('table_api_services'),'*',array('status =1'));
            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("esheba_management/external_service/list", $data, true)); //approval/entrepreneur_approval/dcms_list

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }

            $ajax['system_page_url'] = $this->get_encoded_url('esheba_management/services/index/list'); //approval/Entrepreneur_approval
            $ajax['system_page_title'] = $this->lang->line("SERVICES");
            $this->jsonReturn($ajax);
        } else {
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }




}
