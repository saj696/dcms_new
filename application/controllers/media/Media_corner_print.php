<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_corner_print extends Root_Controller
{
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        //$this->permissions=Menu_helper::get_permission('media/Media_corner');
        $this->controller_url='media/Media_corner_print';
        $this->load->model("media/Media_corner_print_model");
    }

    public function index($action='edit',$id=0)
    {
        $this->current_action=$action;

        if($action=='edit')
        {
            $this->system_edit();
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        else
        {
            $this->system_edit();
        }
    }

    private function system_edit()
    {
        $user = User_helper::get_user();

        $this->current_action = 'edit';
        $ajax['status'] = true;
        $data = array();

        $data['title']=$this->lang->line("PRINT_CORNER");
        $prints=$this->Media_corner_print_model->get_media_prints();
        $arranged_array = array();
        foreach ($prints as $key => $print) {
            $arranged_array[$print['print_year']][$key]['file_name'] = $print['file_name'];
            $arranged_array[$print['print_year']][$key]['media_title'] = $print['media_title'];
            $arranged_array[$print['print_year']][$key]['external_link'] = $print['external_link'];
        }

        $data['arranged_array']=$arranged_array;

        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("media/media_corner/media_print_add_edit",$data,true));

        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }

        $ajax['system_page_url']=$this->get_encoded_url('media/media_corner_print/index/view/');
        $this->jsonReturn($ajax);
    }

    public function get_result()
    {
        $data['title']=$this->lang->line("PRINT_CORNER");
        $title=$this->input->post('title');
        $prints=$this->Media_corner_print_model->get_media_search_result($title);
        $arranged_array = array();
        foreach ($prints as $key => $print) {
            $arranged_array[$print['print_year']][$key]['file_name'] = $print['file_name'];
            $arranged_array[$print['print_year']][$key]['media_title'] = $print['media_title'];
            $arranged_array[$print['print_year']][$key]['external_link'] = $print['external_link'];
        }

        $data['arranged_array']=$arranged_array;
        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("media/media_corner/media_print_add_edit",$data,true));

        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }

        $ajax['system_page_url']=$this->get_encoded_url('media/media_corner_print/index/view/');
        $this->jsonReturn($ajax);


    }

}
