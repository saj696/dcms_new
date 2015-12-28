<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_view extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('profile/Profile_view');
        $this->controller_url='profile/Profile_view';
        $this->load->model("profile/Profile_view_model");
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
        if($this->permissions['edit'])
        {
            $user = User_helper::get_user();
            $id = $user->id;
            $uisc_id = $user->uisc_id;
            $this->current_action = 'edit';
            $ajax['status'] = true;
            $data = array();

            $data['title']=$this->lang->line("EDIT_PROFILE");

            $data['uisc_detail']=$this->Profile_view_model->get_uisc_info($id, $uisc_id);
            $data['secretary']=$this->Profile_view_model->get_secretary_info($id, $uisc_id);

            $data['chairmen_info']=Query_helper::get_info($this->config->item('table_entrepreneur_chairmen_info'),'*',array('uisc_id ='.$uisc_id),1);
            $data['entrepreneur_info']=Query_helper::get_info($this->config->item('table_entrepreneur_infos'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);
            $data['education_info']=Query_helper::get_info($this->config->item('table_entrepreneur_education'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);
            $data['training_info']=Query_helper::get_info($this->config->item('table_training'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),0);
            $data['investment_info']=Query_helper::get_info($this->config->item('table_investment'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);
            $data['location_info']=Query_helper::get_info($this->config->item('table_center_location'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);
            $data['resources_info']=Query_helper::get_info($this->config->item('table_uisc_resources'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),0);
            $data['device_info']=Query_helper::get_info($this->config->item('table_device_infos'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);
            $data['electricity_info']=Query_helper::get_info($this->config->item('table_electricity'),'*',array('user_id ='.$id, 'uisc_id ='.$uisc_id),1);

            $data['resources']=$this->Profile_view_model->get_resource_info($id, $uisc_id);

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("profile/profile_view/system_add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('profile/profile_view/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

}
