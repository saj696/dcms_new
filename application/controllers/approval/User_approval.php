<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_approval extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('approval/User_approval');
        $this->controller_url='approval/User_approval';
        $this->load->model("approval/User_approval_model");
        $this->lang->load('website_lang');
    }

    public function index($action='add',$id=0)
    {
        $this->current_action=$action;

        if($action=='list')
        {
            $this->dcms_list();
        }
        elseif($action=='add')
        {
            $this->dcms_add();
        }
        elseif($action=='edit')
        {
            $this->dcms_edit($id);
        }
        elseif($action=='save')
        {
            $this->dcms_save();
        }
        else
        {
            $this->current_action='list';
            $this->dcms_list();
        }
    }

    private function dcms_list()
    {
        if($this->permissions['list'])
        {
            $this->current_action='list';
            $ajax['status']=true;

            $session_data['approval'] = $this->input->post();
            $this->session->set_userdata($session_data);

            $ajax['system_content'][]=array("id"=>"#load_list","html"=>$this->load_view("approval/user_approval/dcms_list",'',true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('approval/User_approval');
            $ajax['system_page_title']=$this->lang->line("USER_APPROVAL");
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_add()
    {
        if($this->permissions['add'])
        {
            $this->current_action='add';
            $ajax['status']=true;
            $data=array();

            $data['divisions'] = $this->User_approval_model->get_divisions_by_user();
            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("approval/user_approval/dcms_search",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('approval/user_approval/index/add');
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_edit($id)
    {
        $detail_info = $this->User_approval_model->fetch_uisc_detail_info($id);
        $uisc_id = $this->User_approval_model->get_uisc_id_for_user($id);
        $detail_info['equips'] = $this->User_approval_model->fetch_uisc_equipments($id);
        $data['uisc_detail'] = $detail_info;

        if($this->permissions['edit'])
        {
            if($data['uisc_detail'])
            {
                $ajax['status']=true;
                $ajax['system_content'][]=array("id"=>"#modal_data","html"=>$this->load_view("approval/user_approval/dcms_edit",$data,true));
                $this->jsonReturn($ajax);
            }
            else
            {
                $ajax['status']=true;
                $ajax['system_content'][]=array("id"=>"#modal_data","html"=>'',array(),true);
                $this->jsonReturn($ajax);
            }
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function dcms_save()
    {
        $user = User_helper::get_user();
        $id = $this->input->post("id");
        $status = $this->input->post("approval_status");

        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $user_data = Array('status'=>$status);
            $user_data['update_by'] = $user->id;
            $user_data['update_date'] = time();

            if($id>0)
            {
                $this->db->trans_start();  //DB Transaction Handle START

                Query_helper::update($this->config->item('table_users'),$user_data,array("id = ".$id));
                $entrepreneur = Query_helper::get_info($this->config->item('table_entrepreneur_infos'),array('entrepreneur_email'), array('user_id = '.$id), 1);
                $user = Query_helper::get_info($this->config->item('table_users'),array('username'), array('id = '.$id), 1);

                $this->db->trans_complete();   //DB Transaction Handle END

                if($this->db->trans_status() === TRUE)
                {
                    $ajax['status']=true;

                    if($status==1)
                    {
                        $subject = $this->lang->line('ADMIN_ENTREPRENEUR_APPROVED_SUBJECT_TITLE');
                        $msg="  প্রিয় উদ্যোক্তা আপনার রেজিষ্ট্রেশন অনুমোদন করা হয়েছে।
                            আপনার ব্যবহারকারী  নামঃ ".$user['username']."  এবং  পাসওয়ার্ডঃ  ".$user['username'];
                        $from_email=$this->config->item('from_mail_address');
                        $to_email=$entrepreneur['entrepreneur_email'];
                        $cc_email=$this->config->item('cc_mail_address_maraj');

                        User_helper::mail_send($from_email,$to_email, $cc_email,'',$subject,$msg);
                        $ajax['system_message']=$this->lang->line("MSG_SUCCESSFULLY_APPROVED");
                    }
                    else
                    {
                        $ajax['system_message']=$this->lang->line("MSG_SUCCESSFULLY_DENIED");
                    }

                    $this->jsonReturn($ajax);
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->lang->line("MSG_CREATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
        }
    }

    private function check_validation()
    {
        $division_id = $this->input->post("division");
        $zilla_id=$this->input->post("zilla");
        $upazilla_id=$this->input->post("upazilla");
        $union_id=$this->input->post("union");
        $city_corporation_id=$this->input->post("citycorporation");
        $city_corporation_word_id=$this->input->post("citycorporationward");
        $municipal_id=$this->input->post("municipal");
        $municipal_word_id=$this->input->post("municipalward");
        $uisc_name_id=$this->input->post("uisc_id");

        $this->load->library('form_validation');

        $this->form_validation->set_rules('uisc_id',$this->lang->line('UISC_NAME_REQUIRED'),'required', array('required' => $this->lang->line('UISC_NAME_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_type',$this->lang->line('ENTREPRENEUR_TYPE_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_TYPE_REQUIRED')));
        $this->form_validation->set_rules('division',$this->lang->line('DIVISION_REQUIRED'),'required', array('required' => $this->lang->line('DIVISION_REQUIRED')));
        $this->form_validation->set_rules('zilla',$this->lang->line('ZILLA_REQUIRED'),'required', array('required' => $this->lang->line('ZILLA_REQUIRED')));
        $this->form_validation->set_rules('uisc_name',$this->lang->line('UISC_NAME_REQUIRED'),'required', array('required' => $this->lang->line('UISC_NAME_REQUIRED')));

        if(!$this->User_approval_model->check_division($division_id))
        {
            $valid=false;
            $this->message.=$this->lang->line('VALID_DIVISION_REQUIRED').'<br>';
        }
        if(!$this->User_approval_model->check_zilla($division_id, $zilla_id))
        {
            $valid=false;
            $this->message.=$this->lang->line('VALID_DISTRICT_REQUIRED').'<br>';
        }

        if($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
        {

            $this->form_validation->set_rules('upazilla',$this->lang->line('UPAZILLA_REQUIRED'),'required', array('required' => $this->lang->line('UPAZILLA_REQUIRED')));
            $this->form_validation->set_rules('union',$this->lang->line('UNION_REQUIRED'),'required', array('required' => $this->lang->line('UNION_REQUIRED')));

            if(!$this->User_approval_model->check_upazilla($zilla_id, $upazilla_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_UPAZILLA_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_union($zilla_id, $upazilla_id, $union_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_UNION_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_dcms_udc($zilla_id, $upazilla_id, $union_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }
        elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $this->form_validation->set_rules('citycorporation',$this->lang->line('CITYCORPORATION_REQUIRED'),'required', array('required' => $this->lang->line('CITYCORPORATION_REQUIRED')));
            $this->form_validation->set_rules('citycorporationward',$this->lang->line('CITYCORPORATIONWARD_REQUIRED'),'required', array('required' => $this->lang->line('CITYCORPORATIONWARD_REQUIRED')));

            if(!$this->User_approval_model->check_city_corporation($zilla_id, $city_corporation_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_CITY_CORPORATION_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_city_corporation_word($zilla_id, $city_corporation_id, $city_corporation_word_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_CITY_CORPORATION_WORD_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_dcms_cdc($zilla_id, $city_corporation_id, $city_corporation_word_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }
        elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
        {
            $this->form_validation->set_rules('municipal',$this->lang->line('MUNICIPAL_REQUIRED'),'required', array('required' => $this->lang->line('MUNICIPAL_REQUIRED')));
            $this->form_validation->set_rules('municipalward',$this->lang->line('MUNICIPALWARD_REQUIRED'),'required', array('required' => $this->lang->line('MUNICIPALWARD_REQUIRED')));

            if(!$this->User_approval_model->check_municipal($zilla_id, $municipal_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_MUNICIPAL_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_municipal_word($zilla_id, $municipal_id, $municipal_word_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_MUNICIPAL_WORD_REQUIRED').'<br>';
            }
            if(!$this->User_approval_model->check_dcms_pdc($zilla_id, $municipal_id, $municipal_word_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }


        if($this->input->post('id') && $this->input->post('id')>0)
        {
            $valid = true;
        }
        else
        {
            $valid=false;
            $this->message.=$this->lang->line('APPROVAL_NOT_POSSIBLE').'<br>';
        }

        return $valid;
    }

    public function get_uiscs()
    {
        $session_data = $this->session->userdata('approval');
        $uiscs = array();

        if($this->permissions['list'])
        {
            $entrepreneur_type = isset($session_data['entrepreneur_type'])?$session_data['entrepreneur_type']:0;
            $division = isset($session_data['division'])?$session_data['division']:0;
            $zilla = isset($session_data['zilla'])?$session_data['zilla']:0;
            $upazilla = isset($session_data['upazilla'])?$session_data['upazilla']:0;
            $municipal = isset($session_data['municipal'])?$session_data['municipal']:0;
            $municipalward = isset($session_data['municipalward'])?$session_data['municipalward']:0;
            $citycorporation = isset($session_data['citycorporation'])?$session_data['citycorporation']:0;
            $citycorporationward = isset($session_data['citycorporationward'])?$session_data['citycorporationward']:0;
            $union = isset($session_data['union'])?$session_data['union']:0;
            $year = isset($session_data['year'])?$session_data['year']:0;
            $month = isset($session_data['month'])?$session_data['month']:0;
            $date = isset($session_data['date'])?$session_data['date']:0;
            $status = isset($session_data['status'])?$session_data['status']:'';
        }

        $uiscs = $this->User_approval_model->get_approval_uisc_detail($entrepreneur_type, $division, $zilla, $upazilla, $municipal, $municipalward, $citycorporation, $citycorporationward, $union, $year, $month, $date, $status);
        $this->session->unset_userdata('approval'); // unset session approval data.
        $this->jsonReturn($uiscs);
    }

    public function get_zilla()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $division_id=$this->input->post('division_id');

        if($user_group_id == $this->config->item('DISTRICT_GROUP_ID') || $user_group_id == $this->config->item('UPAZILLA_GROUP_ID') || $user_group_id == $this->config->item('UNION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_WORD_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_WORD_GROUP_ID') || $user_group_id == $this->config->item('UISC_GROUP_ID'))
        {
            $zillas = Query_helper::get_info($this->config->item('table_zillas'),array('zillaid value', 'zillaname text'), array('visible = 1', 'divid = '.$division_id, 'zillaid = '.$user->zilla));
        }
        else
        {
            $zillas = Query_helper::get_info($this->config->item('table_zillas'),array('zillaid value', 'zillaname text'), array('visible = 1', 'divid = '.$division_id));
        }

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_zilla_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$zillas),true));
        $this->jsonReturn($ajax);
    }

    public function get_upazila()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;
        $zilla_id=$this->input->post('zilla_id');

        if($user_group_id == $this->config->item('UPAZILLA_GROUP_ID') || $user_group_id == $this->config->item('UNION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_WORD_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_WORD_GROUP_ID') || $user_group_id == $this->config->item('UISC_GROUP_ID'))
        {
            $upazilas=Query_helper::get_info($this->config->item('table_upazilas'),array('upazilaid value', 'upazilaname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'upazilaid = '.$user->upazila));
        }
        else
        {
            $upazilas=Query_helper::get_info($this->config->item('table_upazilas'),array('upazilaid value', 'upazilaname text'), array('visible = 1', 'zillaid = '.$zilla_id));
        }

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_upazila_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$upazilas),true));
        $this->jsonReturn($ajax);
    }

    public function get_union()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $zilla_id=$this->input->post('zilla_id');
        $upazila_id=$this->input->post('upazila_id');
        $unions=Query_helper::get_info($this->config->item('table_unions'),array('unionid value', 'unionname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'upazilaid='.$upazila_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_unioun_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$unions),true));
        $this->jsonReturn($ajax);
    }

    public function get_city_corporation()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $division_id=$this->input->post('division_id');
        $zilla_id=$this->input->post('zilla_id');

        if($user_group_id == $this->config->item('UPAZILLA_GROUP_ID') || $user_group_id == $this->config->item('UNION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_WORD_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_WORD_GROUP_ID') || $user_group_id == $this->config->item('UISC_GROUP_ID'))
        {
            $city_corporations=Query_helper::get_info($this->config->item('table_city_corporations'),array('citycorporationid value', 'citycorporationname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'divid='.$division_id, 'citycorporationid = '.$user->citycorporation));
        }
        else
        {
            $city_corporations=Query_helper::get_info($this->config->item('table_city_corporations'),array('citycorporationid value', 'citycorporationname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'divid='.$division_id));
        }

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_citycorporation_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$city_corporations),true));
        $this->jsonReturn($ajax);
    }

    public function get_city_corporation_word()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $division_id=$this->input->post('division_id');
        $zilla_id=$this->input->post('zilla_id');
        $city_corporation_id=$this->input->post('city_corporation_id');
        $city_corporation_words=Query_helper::get_info($this->config->item('table_city_corporation_wards'),array('citycorporationwardid value', 'wardname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'divid='.$division_id, 'citycorporationid = '.$city_corporation_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_city_corporation_ward_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$city_corporation_words),true));
        $this->jsonReturn($ajax);
    }

    public function get_municipal()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $zilla_id=$this->input->post('zilla_id');

        if($user_group_id == $this->config->item('UPAZILLA_GROUP_ID') || $user_group_id == $this->config->item('UNION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_GROUP_ID') || $user_group_id == $this->config->item('CITY_CORPORATION_WORD_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_GROUP_ID') || $user_group_id == $this->config->item('MUNICIPAL_WORD_GROUP_ID') || $user_group_id == $this->config->item('UISC_GROUP_ID'))
        {
            $municipals=Query_helper::get_info($this->config->item('table_municipals'),array('municipalid value', 'municipalname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'municipalid = '.$user->municipal));
        }
        else
        {
            $municipals=Query_helper::get_info($this->config->item('table_municipals'),array('municipalid value', 'municipalname text'), array('visible = 1', 'zillaid = '.$zilla_id));
        }

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_municipal_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$municipals),true));
        $this->jsonReturn($ajax);
    }

    public function get_municipal_ward()
    {
        $user = User_helper::get_user();
        $user_group_id = $user->user_group_id;

        $zilla_id=$this->input->post('zilla_id');
        $municipal_id=$this->input->post('municipal_id');
        $municipal_wards=Query_helper::get_info($this->config->item('table_municipal_wards'),array('wardid value', 'wardname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'municipalid = '.$municipal_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_municipal_ward_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$municipal_wards),true));
        $this->jsonReturn($ajax);
    }
}
