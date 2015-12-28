<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_registration extends Root_Controller
{
    public $message;
    public $controller_url;
    public $current_action;
    function __construct()
    {
        parent::__construct();
        $this->message='';
        $this->controller_url='website/User_registration';
        $this->load->model("website/User_registration_model");
        $this->lang->load('website_lang');
    }

    public function index($action='add',$id=0)
    {
        $this->current_action=$action;

        if($action=='add')
        {
            $this->dcms_add();
        }
        elseif($action=='save')
        {
            $this->dcms_save();
        }
        else
        {
            $this->current_action='add';
            $this->dcms_add();
        }
    }

    private function dcms_add()
    {

        $this->current_action='add';
        $ajax['status']=true;
        $data=array();
        $data['title']=$this->lang->line("USER_REGISTRATION");

        $data['questions'] = Query_helper::get_info($this->config->item('table_questions'),array('id value','question text'),array('status = 1'));
        $data['resources'] = Query_helper::get_info($this->config->item('table_resources'),array('res_id value','res_name text'),array('visible = 1'));

        $ajax['system_content'][]=array("id"=>"#system_wrapper","html"=>$this->load_view("website/user_registration/dcms_add_edit",$data,true));
        $ajax['system_content'][]=array("id"=>"#system_wrapper_top_menu","html"=>$this->load_view("top_menu","",true));

        if($this->message)
        {
            $ajax['system_message']=$this->message;
        }

        $ajax['system_page_url']=$this->get_encoded_url('website/user_registration/index/add');
        $this->jsonReturn($ajax);
    }

    private function dcms_save()
    {
        $time = time();
        $user_data = array();
        $secretary_data = array();
        $entrepreneur_data = array();
        $device_data = array();
        $resource_data = array();
        $investment_data = array();
        $training_data = array();
        $electricity_data = array();
        $location_data = array();
        $academic_data = array();

        if(!$this->check_validation())
        {
            $ajax['status']=false;
            $ajax['system_message']=$this->message;
            $this->jsonReturn($ajax);
        }
        else
        {
            $user_data['uisc_type'] = $this->input->post('entrepreneur_type');
            $user_data['user_group_id'] = $this->config->item('UISC_GROUP_ID');
            $user_data['uisc_id'] = $this->input->post('uisc_name');
            $user_data['division'] = $this->input->post('division');
            $user_data['zilla'] = $this->input->post('zilla');
            $user_data['status'] = 0;
            $user_data['name_bn'] = $this->input->post('entrepreneur_name');

            if($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {
                $user_data['upazila'] = $this->input->post('upazilla');
                $user_data['unioun'] = $this->input->post('union');

                $uisc_serial = $this->User_registration_model->get_uisc_serial($this->input->post('uisc_name'));
                $user_serial = $this->User_registration_model->get_user_serial($this->input->post('uisc_name'));

                $user_data['username'] = $user_data['zilla'].'-'.$user_data['upazila'].'-'.$user_data['unioun'].'-'.str_pad($uisc_serial, 2, "0", STR_PAD_LEFT).'-'.str_pad($user_serial, 2, "0", STR_PAD_LEFT);
                $user_data['password'] = md5(md5($user_data['username']));
            }
            elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $user_data['citycorporation'] = $this->input->post('citycorporation');
                $user_data['citycorporationward'] = $this->input->post('citycorporationward');

                $uisc_serial = $this->User_registration_model->get_uisc_serial($this->input->post('uisc_name'));
                $user_serial = $this->User_registration_model->get_user_serial($this->input->post('uisc_name'));

                $user_data['username'] = $user_data['zilla'].'-'.$user_data['citycorporation'].'-'.$user_data['citycorporationward'].'-'.str_pad($uisc_serial, 2, "0", STR_PAD_LEFT).'-'.str_pad($user_serial, 2, "0", STR_PAD_LEFT);
                $user_data['password'] = md5(md5($user_data['username']));
            }
            elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $user_data['municipal'] = $this->input->post('municipal');
                $user_data['municipalward'] = $this->input->post('municipalward');

                $uisc_serial = $this->User_registration_model->get_uisc_serial($this->input->post('uisc_name'));
                $user_serial = $this->User_registration_model->get_user_serial($this->input->post('uisc_name'));

                $user_data['username'] = $user_data['zilla'].'-'.$user_data['municipal'].'-'.$user_data['municipalward'].'-'.str_pad($uisc_serial, 2, "0", STR_PAD_LEFT).'-'.str_pad($user_serial, 2, "0", STR_PAD_LEFT);
                $user_data['password'] = md5(md5($user_data['username']));
            }

            $user_data['email'] = $this->input->post('uisc_email');
            $user_data['mobile'] = $this->input->post('uisc_mobile_no');
            $user_data['ques_id'] = $this->input->post('ques_id');
            $user_data['ques_ans'] = $this->input->post('ques_ans');

            $dir = $this->config->item("dcms_upload");
            $uploaded = System_helper::upload_file($dir['entrepreneur'],10240,'gif|jpg|png');

            if(array_key_exists('profile_image',$uploaded))
            {
                if($uploaded['profile_image']['status'])
                {
                    $user_data['picture_name'] = $uploaded['profile_image']['info']['file_name'];
                }
                else
                {
                    $ajax['status']=false;
                    $ajax['system_message']=$this->message.=$uploaded['profile_image']['message'].'<br>';
                    $this->jsonReturn($ajax);
                }
            }

            $user_data['create_by']='000000';
            $user_data['create_date']=$time;

            $entrepreneur_data['user_id'] = $user_data['username'];
            $entrepreneur_data['entrepreneur_type'] = $this->input->post('entrepreneur_exp_type');
            $entrepreneur_data['entrepreneur_name'] = $this->input->post('entrepreneur_name');
            $entrepreneur_data['entrepreneur_father_name'] = $this->input->post('entrepreneur_father_name');
            $entrepreneur_data['entrepreneur_mother_name'] = $this->input->post('entrepreneur_mother_name');
            $entrepreneur_data['entrepreneur_qualification'] = $this->input->post('entrepreneur_qualification');
            $entrepreneur_data['entrepreneur_mobile'] = $this->input->post('entrepreneur_mobile');
            $entrepreneur_data['entrepreneur_email'] = $this->input->post('entrepreneur_email');
            $entrepreneur_data['entrepreneur_sex'] = $this->input->post('entrepreneur_sex');
            $entrepreneur_data['entrepreneur_address'] = $this->input->post('entrepreneur_address');

            $entrepreneur_data['entrepreneur_nid'] = $this->input->post('entrepreneur_nid');
            $entrepreneur_data['entrepreneur_bank_name'] = $this->input->post('entrepreneur_bank_name');
            $entrepreneur_data['entrepreneur_bank_account_no'] = $this->input->post('entrepreneur_bank_account_no');
            $entrepreneur_data['entrepreneur_bank_holder_name'] = $this->input->post('entrepreneur_bank_holder_name');
            $entrepreneur_data['entrepreneur_blog_member'] = $this->input->post('entrepreneur_blog_member');
            $entrepreneur_data['entrepreneur_fb_group_member'] = $this->input->post('entrepreneur_fb_group_member');

            $device_data['connection_type'] = $this->input->post('connection_type');
            $device_data['ip_address'] = $this->input->post('ip_address');
            $device_data['modem'] = $this->input->post('modem');

            $investment_data['self_investment'] = System_helper::Get_Bng_to_Eng(trim($this->input->post('self_investment')));
            $investment_data['invest_debt'] = System_helper::Get_Bng_to_Eng(trim($this->input->post('invest_debt')));
            $investment_data['invested_money'] = (System_helper::Get_Bng_to_Eng(trim($this->input->post('self_investment')))+trim(System_helper::Get_Bng_to_Eng($this->input->post('invest_debt'))));//System_helper::Get_Bng_to_Eng($this->input->post('invested_money'));
            $investment_data['invest_sector'] = $this->input->post('invest_sector');

            $electricity_data['electricity'] = $this->input->post('electricity');
            $electricity_data['solar'] = $this->input->post('solar');
            $electricity_data['ips'] = $this->input->post('ips');

            $location_data['center_type'] = $this->input->post('center_location');

            $academic_data['latest_education'] = $this->input->post('latest_education');
            $academic_data['passing_year'] = $this->input->post('passing_year');

            $coursePost = $this->input->post('training_course');
            $institutePost = $this->input->post('training_institute');
            $timePost = $this->input->post('training_time');

            $resPost = $this->input->post('res_id');
            $res_detailPost = $this->input->post('res_detail');
            $quantityPost = $this->input->post('quantity');
            $statusPost = $this->input->post('status');

            $this->db->trans_start();  //DB Transaction Handle START
            $user_id = Query_helper::add($this->config->item('table_users'),$user_data);

            $entrepreneur_data['uisc_id'] = $this->input->post('uisc_name');
            $entrepreneur_data['user_id'] = $user_id;
            $entrepreneur_data['create_by']='000000';
            $entrepreneur_data['create_date']=$time;
            Query_helper::add($this->config->item('table_entrepreneur_infos'),$entrepreneur_data);

            $device_data['uisc_id'] = $this->input->post('uisc_name');
            $device_data['user_id'] = $user_id;
            $device_data['create_by']='000000';
            $device_data['create_date']=$time;
            Query_helper::add($this->config->item('table_device_infos'),$device_data);

            $investment_data['uisc_id'] = $this->input->post('uisc_name');
            $investment_data['user_id'] = $user_id;
            $investment_data['create_by']='000000';
            $investment_data['create_date']=$time;
            Query_helper::add($this->config->item('table_investment'),$investment_data);

            $electricity_data['uisc_id'] = $this->input->post('uisc_name');
            $electricity_data['user_id'] = $user_id;
            $electricity_data['create_by']='000000';
            $electricity_data['create_date']=$time;
            Query_helper::add($this->config->item('table_electricity'),$electricity_data);

            $location_data['uisc_id'] = $this->input->post('uisc_name');
            $location_data['user_id'] = $user_id;
            $location_data['create_by']='000000';
            $location_data['create_date']=$time;
            Query_helper::add($this->config->item('table_center_location'),$location_data);

            $academic_data['uisc_id'] = $this->input->post('uisc_name');
            $academic_data['user_id'] = $user_id;
            $academic_data['create_by']='000000';
            $academic_data['create_date']=$time;
            Query_helper::add($this->config->item('table_entrepreneur_education'),$academic_data);

            if(sizeof($resPost)>0 && is_array($resPost))
            {
                for($i=0; $i<sizeof($resPost); $i++)
                {
                    $resource_data['uisc_id'] = $this->input->post('uisc_name');
                    $resource_data['user_id'] = $user_id;
                    $resource_data['res_id'] = $resPost[$i];
                    $resource_data['res_detail'] = $res_detailPost[$i];
                    $resource_data['quantity'] = $quantityPost[$i];
                    $resource_data['status'] = $statusPost[$i];
                    $resource_data['create_by']='000000';
                    $resource_data['create_date']=$time;
                    Query_helper::add($this->config->item('table_uisc_resources'),$resource_data);
                }
            }

            if(sizeof($coursePost)>0 && is_array($coursePost))
            {
                for($i=0; $i<sizeof($coursePost); $i++)
                {
                    $training_data['uisc_id'] = $this->input->post('uisc_name');
                    $training_data['user_id'] = $user_id;
                    $training_data['course_name'] = $coursePost[$i];
                    $training_data['institute_name'] = $institutePost[$i];
                    $training_data['timespan'] = $timePost[$i];
                    $training_data['create_by']='000000';
                    $training_data['create_date']=$time;
                    Query_helper::add($this->config->item('table_training'),$training_data);
                }
            }

            $this->db->trans_complete();   //DB Transaction Handle END

            if ($this->db->trans_status() === TRUE)
            {
                $this->message=$this->lang->line("MSG_CREATE_SUCCESS");
                $this->dcms_add();
            }
            else
            {
                $ajax['status']=false;
                $ajax['system_message']=$this->lang->line("MSG_CREATE_FAIL");
                $this->jsonReturn($ajax);
            }

        }
    }




    private function check_validation()
    {
        $valid = true;

        $division_id = $this->input->post("division");
        $zilla_id=$this->input->post("zilla");
        $upazilla_id=$this->input->post("upazilla");
        $union_id=$this->input->post("union");
        $city_corporation_id=$this->input->post("citycorporation");
        $city_corporation_word_id=$this->input->post("citycorporationward");
        $municipal_id=$this->input->post("municipal");
        $municipal_word_id=$this->input->post("municipalward");
        $uisc_name_id=$this->input->post("uisc_name");

        $this->load->library('form_validation');
        //////////// ডিজিটাল সেন্টার সম্পর্কিত তথ্য
        $this->form_validation->set_rules('entrepreneur_type',$this->lang->line('ENTREPRENEUR_TYPE_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_TYPE_REQUIRED')));
        $this->form_validation->set_rules('division',$this->lang->line('DIVISION_REQUIRED'),'required', array('required' => $this->lang->line('DIVISION_REQUIRED')));
        $this->form_validation->set_rules('zilla',$this->lang->line('ZILLA_REQUIRED'),'required', array('required' => $this->lang->line('ZILLA_REQUIRED')));
        $this->form_validation->set_rules('uisc_name',$this->lang->line('UISC_NAME_REQUIRED'),'required', array('required' => $this->lang->line('UISC_NAME_REQUIRED')));

        if(!$this->User_registration_model->check_division($division_id))
        {
            $valid=false;
            $this->message.=$this->lang->line('VALID_DIVISION_REQUIRED').'<br>';
        }
        if(!$this->User_registration_model->check_zilla($division_id, $zilla_id))
        {
            $valid=false;
            $this->message.=$this->lang->line('VALID_DISTRICT_REQUIRED').'<br>';
        }

        if($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
        {

            $this->form_validation->set_rules('upazilla',$this->lang->line('UPAZILLA_REQUIRED'),'required', array('required' => $this->lang->line('UPAZILLA_REQUIRED')));
            $this->form_validation->set_rules('union',$this->lang->line('UNION_REQUIRED'),'required', array('required' => $this->lang->line('UNION_REQUIRED')));

            if(!$this->User_registration_model->check_upazilla($zilla_id, $upazilla_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_UPAZILLA_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_union($zilla_id, $upazilla_id, $union_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_UNION_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_dcms_udc($zilla_id, $upazilla_id, $union_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }
        elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $this->form_validation->set_rules('citycorporation',$this->lang->line('CITYCORPORATION_REQUIRED'),'required', array('required' => $this->lang->line('CITYCORPORATION_REQUIRED')));
            $this->form_validation->set_rules('citycorporationward',$this->lang->line('CITYCORPORATIONWARD_REQUIRED'),'required', array('required' => $this->lang->line('CITYCORPORATIONWARD_REQUIRED')));

            if(!$this->User_registration_model->check_city_corporation($zilla_id, $city_corporation_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_CITY_CORPORATION_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_city_corporation_word($zilla_id, $city_corporation_id, $city_corporation_word_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_CITY_CORPORATION_WORD_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_dcms_cdc($zilla_id, $city_corporation_id, $city_corporation_word_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }
        elseif($this->input->post('entrepreneur_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
        {
            $this->form_validation->set_rules('municipal',$this->lang->line('MUNICIPAL_REQUIRED'),'required', array('required' => $this->lang->line('MUNICIPAL_REQUIRED')));
            $this->form_validation->set_rules('municipalward',$this->lang->line('MUNICIPALWARD_REQUIRED'),'required', array('required' => $this->lang->line('MUNICIPALWARD_REQUIRED')));

            if(!$this->User_registration_model->check_municipal($zilla_id, $municipal_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_MUNICIPAL_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_municipal_word($zilla_id, $municipal_id, $municipal_word_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('VALID_MUNICIPAL_WORD_REQUIRED').'<br>';
            }
            if(!$this->User_registration_model->check_dcms_pdc($zilla_id, $municipal_id, $municipal_word_id, $uisc_name_id))
            {
                $valid=false;
                $this->message.=$this->lang->line('UISC_NAME_REQUIRED').'<br>';
            }
        }

        $this->form_validation->set_rules('uisc_mobile_no',$this->lang->line('UISC_MOBILE_NO_REQUIRED'),'required|min_length[4]|regex_match[/^01[0-9]{9}$/]', array('required' => $this->lang->line('UISC_MOBILE_NO_REQUIRED')));
        $this->form_validation->set_rules('uisc_email',$this->lang->line('UISC_EMAIL_REQUIRED'),'trim|required|valid_email', array('required' => $this->lang->line('UISC_EMAIL_REQUIRED')));
        $this->form_validation->set_rules('uisc_address',$this->lang->line('UISC_ADDRESS_REQUIRED'),'required', array('required' => $this->lang->line('UISC_ADDRESS_REQUIRED')));


        /////// উদ্যোক্তা সম্পর্কিত তথ্য
        $this->form_validation->set_rules('entrepreneur_exp_type',$this->lang->line('ENTREPRENEUR_EXP_TYPE_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_EXP_TYPE_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_name',$this->lang->line('ENTREPRENEUR_NAME_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_NAME_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_mother_name',$this->lang->line('ENTREPRENEUR_MOTHER_NAME_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_MOTHER_NAME_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_father_name',$this->lang->line('ENTREPRENEUR_FATHER_NAME_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_FATHER_NAME_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_mobile',$this->lang->line('ENTREPRENEUR_MOBILE_REQUIRED'),'required|min_length[4]|regex_match[/^01[0-9]{9}$/]', array('required' => $this->lang->line('ENTREPRENEUR_MOBILE_REQUIRED').' লিখুন '));
        $this->form_validation->set_rules('entrepreneur_email',$this->lang->line('ENTREPRENEUR_EMAIL_REQUIRED'),'trim|required|valid_email', array('required' => $this->lang->line('ENTREPRENEUR_EMAIL_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_sex',$this->lang->line('ENTREPRENEUR_SEX_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_SEX_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_address',$this->lang->line('ENTREPRENEUR_ADDRESS_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_ADDRESS_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_nid', $this->lang->line('ENTREPRENEUR_NID_REQUIRED'), 'required|numeric', array('required' => $this->lang->line('ENTREPRENEUR_NID_REQUIRED').' লিখুন '));//{11} for 11 digits number
        $this->form_validation->set_rules('entrepreneur_blog_member',$this->lang->line('BLOG_MEMBER_REQUIRED'),'required', array('required' => $this->lang->line('BLOG_MEMBER_REQUIRED')));
        $this->form_validation->set_rules('entrepreneur_fb_group_member',$this->lang->line('FB_GROUP_MEMBER_REQUIRED'),'required', array('required' => $this->lang->line('FB_GROUP_MEMBER_REQUIRED')));
        $this->form_validation->set_rules('ques_id',$this->lang->line('QUESTION_REQUIRED'),'required', array('required' => $this->lang->line('QUESTION_REQUIRED')));
        $this->form_validation->set_rules('ques_ans',$this->lang->line('ANSWER_REQUIRED'),'required', array('required' => $this->lang->line('ANSWER_REQUIRED')));
        if (empty($_FILES['profile_image']['name']))
        {
            $this->form_validation->set_rules("profile_image",$this->lang->line('ENTREPRENEUR_PROFILE_PHOTO_REQUIRED'),'required', array('required' => $this->lang->line('ENTREPRENEUR_PROFILE_PHOTO_REQUIRED')));
        }

        //////////// শিক্ষাগত যোগ্যতা সম্পর্কিত তথ্য
        $this->form_validation->set_rules('latest_education',$this->lang->line('LATEST_EDUCATION_REQUIRED'),'required', array('required' => $this->lang->line('LATEST_EDUCATION_REQUIRED')));
        $this->form_validation->set_rules('passing_year',$this->lang->line('PASSING_YEAR_REQUIRED'),'required', array('required' => $this->lang->line('PASSING_YEAR_REQUIRED')));

        ////// উদ্যোক্তাদের প্রশিক্ষন সংক্রান্ত তথ্য
        $this->form_validation->set_rules('training_course[]',$this->lang->line('TRAINING_COURSE_REQUIRED'),'required', array('required' => $this->lang->line('TRAINING_COURSE_REQUIRED')));
        $this->form_validation->set_rules('training_institute[]',$this->lang->line('TRAINING_COURSE_REQUIRED'),'required', array('required' => $this->lang->line('TRAINING_COURSE_REQUIRED')));
        $this->form_validation->set_rules('training_time[]',$this->lang->line('TRAINING_COURSE_REQUIRED'),'required', array('required' => $this->lang->line('TRAINING_COURSE_REQUIRED')));

        //// বিনিয়োগ সম্পর্কিত তথ্য
        $this->form_validation->set_rules('self_investment', $this->lang->line('SELF_INVESTMENT_REQUIRED'), 'required|numeric', array('required' => $this->lang->line('SELF_INVESTMENT_REQUIRED').' লিখুন '));//{11} for 11 digits number
        $this->form_validation->set_rules('invest_debt', $this->lang->line('DEBIT_INVESTMENT_REQUIRED'), 'required|numeric', array('required' => $this->lang->line('DEBIT_INVESTMENT_REQUIRED').' লিখুন '));//{11} for 11 digits number
        $this->form_validation->set_rules('invested_money', $this->lang->line('TOTAL_INVESTMENT_REQUIRED'), 'required|numeric', array('required' => $this->lang->line('TOTAL_INVESTMENT_REQUIRED').' লিখুন '));//{11} for 11 digits number
        $this->form_validation->set_rules('invest_sector',$this->lang->line('INVESTMENT_HEAD_REQUIRED'),'required', array('required' => $this->lang->line('INVESTMENT_HEAD_REQUIRED')));

        ///// সেন্টারের লোকেশন সংক্রান্ত তথ্য
        $this->form_validation->set_rules('center_location',$this->lang->line('CENTER_LOCATION_REQUIRED'),'required', array('required' => $this->lang->line('CENTER_LOCATION_REQUIRED')));

        ///// উপকরন
        $this->form_validation->set_rules('res_id[]',$this->lang->line('RESOURCE_NAME_REQUIRED'),'required', array('required' => $this->lang->line('RESOURCE_NAME_REQUIRED')));
        $this->form_validation->set_rules('res_detail[]',$this->lang->line('RESOURCE_NAME_REQUIRED'),'required', array('required' => $this->lang->line('RESOURCE_NAME_REQUIRED')));
        $this->form_validation->set_rules('quantity[]',$this->lang->line('RESOURCE_NAME_REQUIRED'),'required', array('required' => $this->lang->line('RESOURCE_NAME_REQUIRED')));
        $this->form_validation->set_rules('status[]',$this->lang->line('RESOURCE_NAME_REQUIRED'),'required', array('required' => $this->lang->line('RESOURCE_NAME_REQUIRED')));

        ///// ডিভাইস সম্পর্কিত তথ্যসমূহ
        $this->form_validation->set_rules('connection_type',$this->lang->line('CONNECTION_TYPE_REQUIRED'),'required', array('required' => $this->lang->line('CONNECTION_TYPE_REQUIRED')));
        $this->form_validation->set_rules('modem',$this->lang->line('MODEM_REQUIRED'),'required', array('required' => $this->lang->line('MODEM_REQUIRED')));
        //$this->form_validation->set_rules('ip_address',$this->lang->line('IP_ADDRESS_REQUIRED'),'required', array('required' => $this->lang->line('IP_ADDRESS_REQUIRED')));

        //// বিদ্যুৎ সংক্রান্ত তথ্য
        $this->form_validation->set_rules('electricity',$this->lang->line('ELECTRICITY_REQUIRED'),'required', array('required' => $this->lang->line('ELECTRICITY_REQUIRED')));
        $this->form_validation->set_rules('solar',$this->lang->line('SOLAR_REQUIRED'),'required', array('required' => $this->lang->line('SOLAR_REQUIRED')));
        $this->form_validation->set_rules('ips',$this->lang->line('IPS_REQUIRED'),'required', array('required' => $this->lang->line('IPS_REQUIRED')));

        if($this->form_validation->run() == FALSE)
        {
            $this->message=validation_errors();
            $valid = false;
        }

        return $valid;

    }

    public function get_zilla()
    {
        $division_id=$this->input->post('division_id');
        $zillas=Query_helper::get_info($this->config->item('table_zillas'),array('zillaid value', 'zillaname text'), array('visible = 1', 'divid = '.$division_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_zilla_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$zillas),true));
        $this->jsonReturn($ajax);
    }

    public function get_upazila()
    {
        $zilla_id=$this->input->post('zilla_id');
        $upazilas=Query_helper::get_info($this->config->item('table_upazilas'),array('upazilaid value', 'upazilaname text'), array('visible = 1', 'zillaid = '.$zilla_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_upazila_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$upazilas),true));
        $this->jsonReturn($ajax);
    }

    public function get_union()
    {
        $zilla_id=$this->input->post('zilla_id');
        $upazila_id=$this->input->post('upazila_id');
        $unions=Query_helper::get_info($this->config->item('table_unions'),array('unionid value', 'unionname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'upazilaid='.$upazila_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_unioun_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$unions),true));
        $this->jsonReturn($ajax);
    }

    public function get_city_corporation()
    {
        $division_id=$this->input->post('division_id');
        $zilla_id=$this->input->post('zilla_id');
        $city_corporations=Query_helper::get_info($this->config->item('table_city_corporations'),array('citycorporationid value', 'citycorporationname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'divid='.$division_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_citycorporation_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$city_corporations),true));
        $this->jsonReturn($ajax);
    }

    public function get_city_corporation_word()
    {
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
        $zilla_id=$this->input->post('zilla_id');
        $municipals=Query_helper::get_info($this->config->item('table_municipals'),array('municipalid value', 'municipalname text'), array('visible = 1', 'zillaid = '.$zilla_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_municipal_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$municipals),true));
        $this->jsonReturn($ajax);
    }

    public function get_municipal_ward()
    {
        $zilla_id=$this->input->post('zilla_id');
        $municipal_id=$this->input->post('municipal_id');
        $municipal_wards=Query_helper::get_info($this->config->item('table_municipal_wards'),array('wardid value', 'wardname text'), array('visible = 1', 'zillaid = '.$zilla_id, 'municipalid = '.$municipal_id));
        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#user_municipal_ward_id","html"=>$this->load_view("dropdown",array('drop_down_options'=>$municipal_wards),true));
        $this->jsonReturn($ajax);
    }

    public function getUnionServiceCenter()
    {
        $division_id = $this->input->post('division_id');
        $zilla_id = $this->input->post('zilla_id');
        $upazilla_id = $this->input->post('upazilla_id');
        $union_id = $this->input->post('union_id');

        $uisc = $this->User_registration_model->getUnionServiceCenter($division_id, $zilla_id, $upazilla_id, $union_id);

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#uisc_name","html"=>$this->load_view("dropdown",array('drop_down_options'=>$uisc),true));
        $this->jsonReturn($ajax);
    }

    public function getCityServiceCenter()
    {
        $division_id = $this->input->post('division_id');
        $zilla_id = $this->input->post('zilla_id');
        $citycorporation_id = $this->input->post('citycorporation_id');
        $city_corporation_ward_id = $this->input->post('city_corporation_ward_id');

        $uisc = $this->User_registration_model->getCityServiceCenter($division_id, $zilla_id, $citycorporation_id, $city_corporation_ward_id);

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#uisc_name","html"=>$this->load_view("dropdown",array('drop_down_options'=>$uisc),true));
        $this->jsonReturn($ajax);
    }

    public function getMunicipalServiceCenter()
    {
        $division_id = $this->input->post('division_id');
        $zilla_id = $this->input->post('zilla_id');
        $municipal_id = $this->input->post('municipal_id');
        $municipal_ward_id = $this->input->post('municipal_ward_id');

        $uisc = $this->User_registration_model->getMunicipalServiceCenter($division_id, $zilla_id, $municipal_id, $municipal_ward_id);

        $ajax['status']=true;
        $ajax['system_content'][]=array("id"=>"#uisc_name","html"=>$this->load_view("dropdown",array('drop_down_options'=>$uisc),true));
        $this->jsonReturn($ajax);
    }

}
