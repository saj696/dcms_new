<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_create extends Root_Controller
{
    public $permissions;
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        //
        parent::__construct();
        $this->message='';
        $this->permissions=Menu_helper::get_permission('notice_management/notice_create');
        $this->controller_url='notice_management/notice_create';
        $this->load->model("notice_management/notice_create_model");
        $this->lang->load("notice_management", $this->get_language());
    }

    public function index($action='list',$id=0)
    {
        $this->current_action=$action;

        if($action=='list')
        {
            $this->system_list();
        }
        elseif($action=='add')
        {
            $this->system_add();
        }
        elseif($action=='batch_edit')
        {
            $this->system_batch_edit();
        }
        elseif($action=='edit')
        {
            $this->system_edit($id);
        }
        elseif($action=='save')
        {
            $this->system_save();
        }
        elseif($action=='batch_details')
        {
            $this->system_batch_details();
        }
        elseif($action=='batch_delete')
        {
            $this->system_batch_delete();
        }
        else
        {
            $this->system_list();
        }
    }

    private function system_list()
    {
        if($this->permissions['list'])
        {
            $this->current_action='list';
            $ajax['status']=true;
            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("notice_management/notice_create/list","",true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('notice_management/notice_create');
            $ajax['system_page_title']=$this->lang->line("NOTICE_CREATE_TITLE");
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_add()
    {
        if($this->permissions['add'])
        {
            $this->current_action='add';
            $ajax['status']=true;
            $data=array();
            $user = User_helper::get_user();
            $data['title']=$this->lang->line("NOTICE_CREATE_TITLE");

            $data['NoticeInfo'] = array
            (
                'id'=>'',
                'notice_title'=>'',
                'notice_details'=>'',
                'upload_file'=>'',
                'viewer_group_id'=>'',
                'status'=>$this->config->item('STATUS_ACTIVE')
            );

            $data['notice_viewers']=array('');
            $data['user_groups']=$this->notice_create_model->get_user_groups();

            if(($user->user_group_level==$this->config->item('SUPER_ADMIN_GROUP_ID'))||($user->user_group_level==$this->config->item('A_TO_I_GROUP_ID'))||($user->user_group_level==$this->config->item('DONOR_GROUP_ID'))||($user->user_group_level==$this->config->item('MINISTRY_GROUP_ID')))
            {
                $data['divisions']=Query_helper::get_info($this->config->item('table_divisions'),array('divid value', 'divname text'), array());
            }
            else
            {
                $data['divisions']=Query_helper::get_info($this->config->item('table_divisions'),array('divid value', 'divname text'), array('divid ='.$user->division));
            }

            $data['zillas']=Query_helper::get_info($this->config->item('table_zillas'),array('zillaid value', 'zillaname text'), array('visible = 1'));
            $data['upazilas']=Query_helper::get_info($this->config->item('table_upazilas'),array('upazilaid value', 'upazilaname text'), array('visible = 1'));
            $data['unions']=Query_helper::get_info($this->config->item('table_unions'),array('unionid value', 'unionname text'), array('visible = 1'));
            $data['municipals']=Query_helper::get_info($this->config->item('table_municipals'),array('municipalid value', 'municipalname text'), array('visible = 1'));
            $data['municipal_wards']=Query_helper::get_info($this->config->item('table_municipal_wards'),array('wardid value', 'wardname text'), array('visible = 1'));
            $data['city_corporations']=Query_helper::get_info($this->config->item('table_city_corporations'),array('citycorporationid value', 'citycorporationname text'), array('visible = 1'));
            $data['city_corporation_words']=Query_helper::get_info($this->config->item('table_city_corporation_wards'),array('citycorporationwardid value', 'wardname text'), array('visible = 1'));

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("notice_management/notice_create/add_edit",$data,true));

            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }

            $ajax['system_page_url']=$this->get_encoded_url('notice_management/notice_create/index/add');
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_edit($id)
    {
        if($this->permissions['edit'])
        {
            $user = User_helper::get_user();
            $this->current_action='edit';
            $ajax['status']=true;
            $data=array();
            $data['title']=$this->lang->line("NOTICE_CREATE_TITLE");
            $data['user_groups']=$this->notice_create_model->get_user_groups();

            $data['NoticeInfo']=$this->notice_create_model->get_notice_detail($id);

            $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));
            $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("notice_management/notice_create/add_edit",$data,true));
            if($this->message)
            {
                $ajax['system_message']=$this->message;
            }
            $ajax['system_page_url']=$this->get_encoded_url('notice_management/notice_create/index/edit/'.$id);
            $this->jsonReturn($ajax);
        }
        else
        {
            $ajax['status']=true;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function system_save()
    {
        //print_r($this->input->post());exit;
        $user=User_helper::get_user();
        $id = $this->input->post("id");
        if($id>0)
        {
            if(!$this->permissions['edit'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }
        else
        {
            if(!$this->permissions['add'])
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
                $this->jsonReturn($ajax);
                die();
            }
        }

        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $notice_detail = $this->input->post('notice_detail');
            $notice_detail_general = array();
            $notice_detail_specific = array();

            $dir = $this->config->item("dcms_upload");
            $uploaded = System_helper::upload_file($dir['notice'],5120,'gif|jpg|png|pdf');

            if(array_key_exists('upload_file',$uploaded))
            {
                if($uploaded['upload_file']['status'])
                {
                    $notice_detail['upload_file'] = $uploaded['upload_file']['info']['file_name'];
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['desk_message']=$this->message.=$uploaded['upload_file']['message'].'<br>';
                    $this->jsonReturn($ajax);
                }
            }

            if($id>0)
            {
                unset($notice_detail['id']);

                $this->db->trans_start();  //DB Transaction Handle START

                $notice_detail['update_by'] = $user->id;
                $notice_detail['update_date'] = time();

                Query_helper::update($this->config->item('table_notice'),$notice_detail,array("id = ".$id));

                if($notice_detail['notice_type']==1)
                {
                    $general_user_groups = $this->input->post('general_user_group');
                    // Initial Update
                    $this->notice_create_model->initial_notice_update($id);

                    $existing_general_viewers = $this->notice_create_model->existing_viewer_groups($id);
                    foreach($general_user_groups as $general_user_group)
                    {
                        if(in_array($general_user_group, $existing_general_viewers))
                        {
                            $notice_detail_general['status']=$this->config->item('STATUS_ACTIVE');
                            Query_helper::update($this->config->item('table_notice_view'),$notice_detail_general,array("notice_id = ".$id, "viewer_user_group =".$general_user_group));
                        }
                        else
                        {
                            $notice_detail_general['viewer_user_group']=$general_user_group;
                            $notice_detail_general['sender_user_group']=$user->user_group_id;
                            $notice_detail_general['notice_id']=$id;
                            $notice_detail_general['status']=$notice_detail['status'];
                            Query_helper::add($this->config->item('table_notice_view'),$notice_detail_general);
                        }
                    }
                }
                elseif($notice_detail['notice_type']==2)
                {
                    $sup_group_post = $this->input->post('sub_group');

                    if(sizeof($sup_group_post)>0)
                    {
                        // Initial Update
                        $this->notice_create_model->initial_notice_update($id);
                        $existing_specific_viewers = $this->notice_create_model->existing_viewer_groups($id);
                        foreach($sup_group_post as $sup_group)
                        {
                            if(in_array($sup_group, $existing_specific_viewers))
                            {
                                $notice_detail_specific['status']=$this->config->item('STATUS_ACTIVE');
                                Query_helper::update($this->config->item('table_notice_view'),$notice_detail_specific,array("notice_id = ".$id, "viewer_user_group=".$sup_group));
                            }
                            else
                            {
                                $notice_detail_specific['viewer_user_group'] = $sup_group;
                                $notice_detail_specific['sender_user_group']=$user->user_group_id;
                                $notice_detail_specific['notice_id']=$id;
                                $notice_detail_specific['division']=$this->input->post('division');
                                $notice_detail_specific['zilla']=$this->input->post('zilla');
                                $notice_detail_specific['upazila']=$this->input->post('upazila');
                                $notice_detail_specific['unioun']=$this->input->post('union');
                                $notice_detail_specific['citycorporation']=$this->input->post('city_corporation');
                                $notice_detail_specific['citycorporationward']=$this->input->post('city_corporation_ward');
                                $notice_detail_specific['municipal']=$this->input->post('municipal');
                                $notice_detail_specific['municipalward']=$this->input->post('municipal_ward');
                                $notice_detail_specific['uisc_id']=$this->input->post('digital_center');
                                $notice_detail_specific['status']=$notice_detail['status'];
                                Query_helper::add($this->config->item('table_notice_view'),$notice_detail_specific);
                            }
                        }
                    }
                    else
                    {
                        $notice_detail_specific['viewer_user_group'] = $this->input->post('specific_user_level');
                        $notice_detail_specific['sender_user_group']=$user->user_group_id;
                        $notice_detail_specific['notice_id']=$id;
                        $notice_detail_specific['division']=$this->input->post('division');
                        $notice_detail_specific['zilla']=$this->input->post('zilla');
                        $notice_detail_specific['upazila']=$this->input->post('upazila');
                        $notice_detail_specific['unioun']=$this->input->post('union');
                        $notice_detail_specific['citycorporation']=$this->input->post('city_corporation');
                        $notice_detail_specific['citycorporationward']=$this->input->post('city_corporation_ward');
                        $notice_detail_specific['municipal']=$this->input->post('municipal');
                        $notice_detail_specific['municipalward']=$this->input->post('municipal_ward');
                        $notice_detail_specific['uisc_id']=$this->input->post('digital_center');
                        $notice_detail_specific['status']=$notice_detail['status'];
                        Query_helper::update($this->config->item('table_notice_view'),$notice_detail_specific,array("notice_id = ".$id));
                    }
                }

                $this->db->trans_complete();   //DB Transaction Handle END

                if ($this->db->trans_status() === TRUE)
                {
                    $this->message=$this->lang->line("MSG_UPDATE_SUCCESS");
                    $save_and_new=$this->input->post('system_save_new_status');
                    if($save_and_new==1)
                    {
                        $this->system_add();
                    }
                    else
                    {
                        $this->system_list();
                    }
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->lang->line("MSG_UPDATE_FAIL");
                    $this->jsonReturn($ajax);
                }
            }
            else
            {
                $notice_detail['create_by']=$user->id;
                $notice_detail['create_date']=time();

                $this->db->trans_start();  //DB Transaction Handle START

                $notice_id=Query_helper::add($this->config->item('table_notice'),$notice_detail);

                if($notice_detail['notice_type']==1)
                {
                    $general_user_groups = $this->input->post('general_user_group');
                    foreach($general_user_groups as $general_user_group)
                    {
                        $notice_detail_general['viewer_user_group']=$general_user_group;
                        $notice_detail_general['sender_user_group']=$user->user_group_id;
                        $notice_detail_general['notice_id']=$notice_id;
                        $notice_detail_general['status']=$notice_detail['status'];
                        Query_helper::add($this->config->item('table_notice_view'),$notice_detail_general);
                    }
                }
                elseif($notice_detail['notice_type']==2)
                {
                    $sup_group_post = $this->input->post('sub_group');
                    if(sizeof($sup_group_post)>0)
                    {
                        foreach($sup_group_post as $sup_group)
                        {
                            $notice_detail_specific['viewer_user_group'] = $sup_group;
                            $notice_detail_specific['sender_user_group']=$user->user_group_id;
                            $notice_detail_specific['notice_id']=$notice_id;
                            $notice_detail_specific['division']=$this->input->post('division');
                            $notice_detail_specific['zilla']=$this->input->post('zilla');
                            $notice_detail_specific['upazila']=$this->input->post('upazila');
                            $notice_detail_specific['unioun']=$this->input->post('union');
                            $notice_detail_specific['citycorporation']=$this->input->post('city_corporation');
                            $notice_detail_specific['citycorporationward']=$this->input->post('city_corporation_ward');
                            $notice_detail_specific['municipal']=$this->input->post('municipal');
                            $notice_detail_specific['municipalward']=$this->input->post('municipal_ward');
                            $notice_detail_specific['uisc_id']=$this->input->post('digital_center');
                            $notice_detail_specific['status']=$notice_detail['status'];
                            Query_helper::add($this->config->item('table_notice_view'),$notice_detail_specific);
                        }
                    }
                    else
                    {
                        $notice_detail_specific['viewer_user_group'] = $this->input->post('specific_user_level');
                        $notice_detail_specific['sender_user_group']=$user->user_group_id;
                        $notice_detail_specific['notice_id']=$notice_id;
                        $notice_detail_specific['division']=$this->input->post('division');
                        $notice_detail_specific['zilla']=$this->input->post('zilla');
                        $notice_detail_specific['upazila']=$this->input->post('upazila');
                        $notice_detail_specific['unioun']=$this->input->post('union');
                        $notice_detail_specific['citycorporation']=$this->input->post('city_corporation');
                        $notice_detail_specific['citycorporationward']=$this->input->post('city_corporation_ward');
                        $notice_detail_specific['municipal']=$this->input->post('municipal');
                        $notice_detail_specific['municipalward']=$this->input->post('municipal_ward');
                        $notice_detail_specific['uisc_id']=$this->input->post('digital_center');
                        $notice_detail_specific['status']=$notice_detail['status'];
                        Query_helper::add($this->config->item('table_notice_view'),$notice_detail_specific);
                    }
                }

                $this->db->trans_complete();   //DB Transaction Handle END

                if ($this->db->trans_status() === TRUE)
                {
                    $this->message=$this->lang->line("MSG_CREATE_SUCCESS");
                    $save_and_new=$this->input->post('system_save_new_status');
                    if($save_and_new==1)
                    {
                        $this->system_add();
                    }
                    else
                    {
                        $this->system_list();
                    }
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

    private function system_batch_edit()
    {
        $selected_ids=$this->input->post('selected_ids');
        $this->system_edit($selected_ids[0]);
    }

    private function system_batch_delete()
    {
        if($this->permissions['delete'])
        {
            $user=User_helper::get_user();
            $selected_ids=$this->input->post('selected_ids');
            $this->db->trans_start();  //DB Transaction Handle START
            foreach($selected_ids as $id)
            {
                Query_helper::update($this->config->item('table_services'),array('status'=>99,'update_by'=>$user->id,'update_date'=>time()),array("id = ".$id));
            }
            $this->db->trans_complete();   //DB Transaction Handle END

            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_DELETE_SUCCESS");
                $this->system_list();
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_DELETE_FAIL");
                $this->jsonReturn($ajax);
            }
        }
        else
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->lang->line("YOU_DONT_HAVE_ACCESS");
            $this->jsonReturn($ajax);
        }
    }

    private function check_validation()
    {
        $valid = true;
        $notice_detail = $this->input->post('notice_detail');

        if(!Validation_helper::validate_int($notice_detail['notice_type']))
        {
            $valid=false;
            $this->message.=$this->lang->line('SELECT_A_NOTICE_TYPE').'<br>';
        }
        if(!isset($notice_detail['notice_title']) && strlen($notice_detail['notice_title'])<1)
        {
            $valid=false;
            $this->message.=$this->lang->line('NOTICE_TITLE_REQUIRED').'<br>';
        }

        if($notice_detail['notice_type']==1)
        {
            $general_user_group = $this->input->post('general_user_group');
            if(sizeof($general_user_group)==0)
            {
                $valid=false;
                $this->message.=$this->lang->line('SELECT_A_RECEIVER_GROUP').'<br>';
            }
        }
        elseif($notice_detail['notice_type']==2)
        {
            $specific_user_level = $this->input->post('specific_user_level');

            if(!Validation_helper::validate_int($specific_user_level))
            {
                $valid=false;
                $this->message.=$this->lang->line('SELECT_A_SPECIFIC_USER_GROUP').'<br>';
            }
            if($specific_user_level==$this->config->item('DIVISION_GROUP_ID') && !Validation_helper::validate_int($this->input->post('division')))
            {
                $valid=false;
                $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
            }
            if($specific_user_level==$this->config->item('DISTRICT_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('UPAZILLA_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('upazila')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_UPAZILLA').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('UNION_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('upazila')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_UPAZILLA').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('union')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_UNION').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('CITY_CORPORATION_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('city_corporation')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_CITY_CORPORATION').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('city_corporation')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_CITY_CORPORATION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('city_corporation_ward')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_CITY_CORPORATION_WARD').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('MUNICIPAL_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('municipal')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_MUNICIPAL').'<br>';
                }
            }
            if($specific_user_level==$this->config->item('MUNICIPAL_WORD_GROUP_ID'))
            {
                if(!Validation_helper::validate_int($this->input->post('division')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('zilla')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('municipal')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_MUNICIPAL').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('municipal_ward')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_MUNICIPAL_WARD').'<br>';
                }
            }

            if($specific_user_level==$this->config->item('UISC_GROUP_ID'))
            {
                $center_type = $this->input->post('center_type');
                if(!Validation_helper::validate_int($center_type))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_CENTER_TYPE').'<br>';
                }
                if(!Validation_helper::validate_int($this->input->post('digital_center')))
                {
                    $valid=false;
                    $this->message.=$this->lang->line('SELECT_DIGITAL_CENTER').'<br>';
                }

                if($center_type==$this->config->item('ONLINE_UNION_GROUP_ID'))
                {
                    if(!Validation_helper::validate_int($this->input->post('division')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('zilla')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('upazila')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_UPAZILLA').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('union')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_UNION').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('union')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_UNION').'<br>';
                    }
                }
                elseif($center_type==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
                {
                    if(!Validation_helper::validate_int($this->input->post('division')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('zilla')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('city_corporation')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_CITY_CORPORATION').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('city_corporation_ward')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_CITY_CORPORATION_WARD').'<br>';
                    }
                }
                elseif($center_type==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
                {
                    if(!Validation_helper::validate_int($this->input->post('division')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DIVISION').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('zilla')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_DISTRICT').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('municipal')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_MUNICIPAL').'<br>';
                    }
                    if(!Validation_helper::validate_int($this->input->post('municipal_ward')))
                    {
                        $valid=false;
                        $this->message.=$this->lang->line('SELECT_MUNICIPAL_WARD').'<br>';
                    }
                }
            }
        }

        return $valid;
    }

    public function get_sub_group()
    {
        $user_level = $this->input->post('user_level');
        $data['sub_groups'] = $this->notice_create_model->get_sub_groups($user_level);

        if(sizeof($data['sub_groups'])>0)
        {
            $ajax['system_content'][]=array("id"=>"#sub_group","html"=>$this->load_view("notice_management/notice_create/sub_group",$data,true));
        }
        else
        {
            $ajax['system_content'][]=array("id"=>"#sub_group","html"=>'',"",true);
        }

        $ajax['status']=true;
        $this->jsonReturn($ajax);
    }

    public function get_list()
    {
        $divisions = array();
        if($this->permissions['list'])
        {
            $divisions = $this->notice_create_model->get_record_list();
        }
        $this->jsonReturn($divisions);
    }
}
