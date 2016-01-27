<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;

    function __construct()
    {
        parent::__construct();
        $this->message = '';
        $this->permissions = Menu_helper::get_permission('basic_setup/Services');
        $this->controller_url = 'basic_setup/Services';
        $this->load->model("basic_setup/Service_model");
        //$this->lang->load('path'); //website_lang
    }

    public function index($action = 'list', $id = 0)
    {
        $this->current_action = $action;

        if ($action == 'list') {
            $this->dcms_list();
        } elseif ($action == 'add') {
            $this->dcms_add();
        } elseif ($action == 'edit') {
            $this->dcms_edit($id);
        } elseif ($action == 'save') {
            $this->dcms_save();
        } else {
            $this->current_action = 'list';
            $this->dcms_list();
        }
    }

    private function dcms_list()
    {
        if ($this->permissions['list']) {
            $this->current_action = 'list';
            $ajax['status'] = true;

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("basic_setup/services/list", '', true)); //approval/entrepreneur_approval/dcms_list

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }

            $ajax['system_page_url'] = $this->get_encoded_url('basic_setup/services/index/list'); //approval/Entrepreneur_approval
            $ajax['system_page_title'] = $this->lang->line("SERVICES");
            $this->jsonReturn($ajax);
        } else {
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_add()
    {
        if ($this->permissions['add']) {
            $this->current_action = 'add';
            $ajax['status'] = true;
            $data = array();
            $data['title'] = "ADD_SERVICE";

            $data['service']['name'] = "";
            $data['service']['description'] = "";
            $data['service']['service_url'] = "";
            $data['service']['status'] = 1;

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("basic_setup/services/add_edit", $data, true)); //approval/entrepreneur_approval/dcms_search

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }

            $ajax['system_page_url'] = $this->get_encoded_url('basic_setup/services/index/add'); //approval/entrepreneur_approval/index/add
            $this->jsonReturn($ajax);
        } else {
            $ajax['status'] = false;
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_edit($id)
    {
        if ($this->permissions['edit']) {
            $this->current_action = 'edit';
            $ajax['status'] = true;
            $data = array();
            $data['title'] = "EDIT_SERVICE";

            $data['service'] = Query_helper::get_info($this->config->item('table_api_services'), '*', ['id =' . $id], 1);

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][] = array("id" => "#system_wrapper", "html" => $this->load_view("basic_setup/services/add_edit", $data, true)); //approval/entrepreneur_approval/dcms_search

            if ($this->message) {
                $ajax['system_message'] = $this->message;
            }

            $ajax['system_page_url'] = $this->get_encoded_url('basic_setup/services/index/edit/' . $id); //approval/entrepreneur_approval/index/add
            $this->jsonReturn($ajax);
        } else {
            $ajax['status'] = false;
            $ajax['system_message'] = $this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_save()
    {
        $time = time();
        $user = User_helper::get_user();
        $id = $this->input->post("id");
        if (!$this->check_validation()) {
            $ajax['status'] = false;
            $ajax['system_message'] = $this->message;
            $this->jsonReturn($ajax);
        } else {
            if ($id > 0) {
                $data = $this->input->post('service');
                $data['update_by'] = $user->id;
                $data['update_date'] = time();
                $directory='images/service_logo';
                $uploaded = System_helper::upload_file($directory,5120,'jpg|png');
                if($uploaded)
                {
                    $data['service_logo']=$uploaded['service_logo']['info']['file_name'];
                }
                $id = Query_helper::update($this->config->item('table_api_services'), $data, ['id =' . $id]);

                if ($id) {
                    $this->message = $this->lang->line("MSG_CREATE_SUCCESS");
                    $save_and_new = $this->input->post('system_save_new_status');
                    if ($save_and_new == 1) {
                        $this->dcms_add();
                    } else {
                        $this->dcms_list();
                    }
                } else {
                    $ajax['status'] = false;
                    $ajax['system_message'] = $this->lang->line("MSG_CREATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            } else {
                $data = $this->input->post('service');
                $data['create_by'] = $user->id;
                $data['create_date'] = time();
                $directory='images/service_logo';
                $uploaded = System_helper::upload_file($directory,5120,'jpg|png');
                if($uploaded)
                {
                    $data['service_logo']=$uploaded['service_logo']['info']['file_name'];
                }
                $id = Query_helper::add($this->config->item('table_api_services'), $data);
                if ($id) {
                    $this->message = $this->lang->line("MSG_CREATE_SUCCESS");
                    $save_and_new = $this->input->post('system_save_new_status');
                    if ($save_and_new == 1) {
                        $this->dcms_add();
                    } else {
                        $this->dcms_list();
                    }
                } else {
                    $ajax['status'] = false;
                    $ajax['system_message'] = $this->lang->line("MSG_CREATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
        }
    }

    private function check_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('service[name]', $this->lang->line('SERVICE_NAME'), 'required');
        $this->form_validation->set_rules('service[service_url]', $this->lang->line('SERVICE_URL'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->message = validation_errors();
            return false;
        }
        return true;
    }

    public function get_list()
    {
        $services = $this->Service_model->get_list();
        $this->jsonReturn($services);
    }


}
