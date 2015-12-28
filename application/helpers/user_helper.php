<?php

class User_helper
{
    public static $logged_user = null;
    function __construct($user)
    {
        $CI = & get_instance();
        foreach ($user as $key => $value)
        {
            $this->$key = $value;
        }
        $this->template_name='default';
        $template = $CI->db->get_where($CI->config->item('table_template'), array('id' => $this->template_id,'status'=>1))->row();
        if($template)
        {
            $this->template_name=$template->name;
        }
        $this->language_name='english';
        $this->language_code='en';
        $language = $CI->db->get_where($CI->config->item('table_language'), array('id' => $this->language_id,'status'=>1))->row();
        if($language)
        {
            $this->language_name=$language->name;
            $this->language_code=$language->language_code;
        }
        $user_group_info=$CI->db->get_where($CI->config->item('table_user_group'), array('id' => $this->user_group_id))->row();
        $this->user_group_level=$user_group_info->level;
    }

    public static function login($username, $password)
    {

        $CI = & get_instance();
        $user = $CI->db->get_where($CI->config->item('table_users'), array('username' => $username, 'password' => md5(md5($password)),'status'=>1))->row();
        if ($user)
        {
            $CI->session->set_userdata("system_user_id", $user->id);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }



    public static function get_user()
    {
        $CI = & get_instance();
        if (User_helper::$logged_user)
        {
            return User_helper::$logged_user;
        }
        else
        {
            if($CI->session->has_userdata("system_user_id"))
            {
                $CI->db->from($CI->config->item('table_users').' users');
                $CI->db->where('id',$CI->session->userdata("system_user_id"));
                $CI->db->where('status',1);
                $user = $CI->db->get()->row();
                if ($user)
                {
                    /*foreach ($user as $key => $value)
                    {
                        $this->$key = $value;
                    }*/
                    User_helper::$logged_user = new User_helper($user);
                    return User_helper::$logged_user;
                }
                else
                {
                    return null;
                }

            }
            else
            {
                return null;
            }

        }
    }
    public static function get_task($position=null,$action='list')
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_task').' task');
        $CI->db->select('task.id,task.component_id,task.module_id,task.controller,task.icon task_icon');
        $CI->db->select('task.name_'.$CI->get_language_code().' task_name');
        $CI->db->select('c.name_'.$CI->get_language_code().' component_name , c.icon component_icon');
        $CI->db->select('m.name_'.$CI->get_language_code().' module_name, m.icon module_icon');

        $CI->db->select('ugr.id role_id,ugr.user_group_id');
        $CI->db->join($CI->config->item('table_user_group_role').' ugr','ugr.task_id = task.id',"INNER");
        $CI->db->join($CI->config->item('table_component').' c','c.id = task.component_id',"INNER");
        $CI->db->join($CI->config->item('table_module').' m','m.id = task.module_id',"INNER");
        $CI->db->where('ugr.user_group_id',$user->user_group_id);
        $CI->db->where('c.id !=',$CI->config->item('report_component_id'));

        $CI->db->where('task.status',1);
        $CI->db->where('m.status',1);
        $CI->db->where('c.status',1);
        if($position)
        {
            $CI->db->where('task.'.$position,1);
        }
        if($action)
        {
            $CI->db->where('ugr.'.$action,1);
        }
        $CI->db->order_by('c.ordering ASC');
        $CI->db->order_by('m.ordering ASC');
        $CI->db->order_by('task.ordering ASC');
        $tasks=$CI->db->get()->result_array();
        return $tasks;

    }
    public static function get_task_module($position=null,$action='list')
    {
        $tasks=User_helper::get_task($position,$action);
        $modules=array();
        foreach($tasks as $task)
        {
            $modules[$task['module_id']]['component_id']=$task['component_id'];
            $modules[$task['module_id']]['component_name']=$task['component_name'];
            $modules[$task['module_id']]['module_name']=$task['module_name'];
            $modules[$task['module_id']]['id']=$task['module_id'];
            $modules[$task['module_id']]['module_icon']=$task['module_icon'];
            $modules[$task['module_id']]['component_icon']=$task['component_icon'];
            $modules[$task['module_id']]['tasks'][]=$task;
        }
        return $modules;
    }
    public static function get_task_module_component($position=null,$action='list')
    {
        $modules=User_helper::get_task_module($position,$action);
        $components=array();
        foreach($modules as $module)
        {
            $components[$module['component_id']]['id']=$module['component_id'];
            $components[$module['component_id']]['component_name']=$module['component_name'];
            $components[$module['component_id']]['component_icon']=$module['component_icon'];
            $components[$module['component_id']]['modules'][]=$module;
        }
        return $components;
    }

    public static function get_uisc_info()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.id', $user->uisc_id);
        $uisc = $CI->db->get()->row();
        return $uisc;
    }
    public static function get_report_tasks()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $CI->db->from($CI->config->item('table_task').' task');
        $CI->db->select('task.id,task.component_id,task.module_id,task.controller,task.icon task_icon');
        $CI->db->select('task.name_'.$CI->get_language_code().' task_name');
        $CI->db->select('c.name_'.$CI->get_language_code().' component_name , c.icon component_icon');
        $CI->db->select('m.name_'.$CI->get_language_code().' module_name, m.icon module_icon');

        $CI->db->select('ugr.id role_id,ugr.user_group_id');
        $CI->db->join($CI->config->item('table_user_group_role').' ugr','ugr.task_id = task.id',"INNER");
        $CI->db->join($CI->config->item('table_component').' c','c.id = task.component_id',"INNER");
        $CI->db->join($CI->config->item('table_module').' m','m.id = task.module_id',"INNER");
        $CI->db->where('ugr.user_group_id',$user->user_group_id);
        $CI->db->where('c.id =',$CI->config->item('report_component_id'));

        $CI->db->where('task.status',1);
        $CI->db->where('m.status',1);
        $CI->db->where('c.status',1);
        $CI->db->where('ugr.view',1);
        $CI->db->order_by('c.ordering ASC');
        $CI->db->order_by('m.ordering ASC');
        $CI->db->order_by('task.ordering ASC');
        $tasks=$CI->db->get()->result_array();
        return $tasks;

    }
    public static function get_reports_task_module()
    {
        $tasks=User_helper::get_report_tasks();
        $modules=array();
        foreach($tasks as $task)
        {
            $modules[$task['module_id']]['component_id']=$task['component_id'];
            $modules[$task['module_id']]['component_name']=$task['component_name'];
            $modules[$task['module_id']]['module_name']=$task['module_name'];
            $modules[$task['module_id']]['id']=$task['module_id'];
            $modules[$task['module_id']]['module_icon']=$task['module_icon'];
            $modules[$task['module_id']]['component_icon']=$task['component_icon'];
            $modules[$task['module_id']]['tasks'][]=$task;
        }
        return $modules;
    }

    public static function complete_user_profile_check()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        $user_info=array();
        //        ///// USER INFO
        //        $CI->db->from($CI->config->item('table_users').' core_01_users');
        //        $CI->db->where('core_01_users.id', $user->id);
        //        $CI->db->where('core_01_users.uisc_id', $user->uisc_id);
        //        $user_info['user_info'] = $CI->db->get()->row();
        //        if(sizeof($user_info['user_info'])>0)
        //        {
        //            if($user_info['user_info'])
        //            {
        //
        //            }
        //        }
        //        else
        //        {
        //            return false;
        //        }
        //        ///// UISC INFO
        //        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        //        $CI->db->where('uisc_infos.id', $user->uisc_id);
        //        $user_info['uisc_info'] = $CI->db->get()->row();
        //        if(sizeof($user_info['uisc_info'])>0)
        //        {
        //            if($user_info['uisc_info'][''])
        //            {
        //
        //            }
        //        }
        //        else
        //        {
        //            return false;
        //        }
        //        ///// CHAIRMEN INFO
        //        $CI->db->from($CI->config->item('table_entrepreneur_chairmen_info').' entrepreneur_chairmen_info');
        //        $CI->db->where('entrepreneur_chairmen_info.uisc_id', $user->uisc_id);
        //        $user_info['chairmen_info'] = $CI->db->get()->row();
        //
        //        ///// SECRETARY INFO
        //        $CI->db->from($CI->config->item('table_secretary_infos').' secretary_infos');
        //        $CI->db->where('secretary_infos.uisc_id', $user->uisc_id);
        //        $user_info['secretary_info'] = $CI->db->get()->row();

        ///// ENTREPRENEUR INFO
        $CI->db->from($CI->config->item('table_entrepreneur_infos').' entrepreneur_infos');
        //$CI->db->where('entrepreneur_infos.user_id', $user->id);
        $CI->db->where('entrepreneur_infos.uisc_id', $user->uisc_id);
        $user_info['entrepreneur_info'] = $CI->db->get()->row();
        if(sizeof($user_info['entrepreneur_info'])>0)
        {
            if(empty($user_info['entrepreneur_info']->entrepreneur_type) && empty($user_info['entrepreneur_info']->entrepreneur_name) && empty($user_info['entrepreneur_info']->entrepreneur_father_name) && empty($user_info['entrepreneur_info']->entrepreneur_mother_name) && empty($user_info['entrepreneur_info']->entrepreneur_mobile) && empty($user_info['entrepreneur_info']->entrepreneur_email) && empty($user_info['entrepreneur_info']->entrepreneur_sex) && empty($user_info['entrepreneur_info']->entrepreneur_address) && empty($user_info['entrepreneur_info']->entrepreneur_nid))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        ///// EDUCATION INFO
        $CI->db->from($CI->config->item('table_entrepreneur_education').' entrepreneur_education_info');
        $CI->db->where('entrepreneur_education_info.user_id', $user->id);
        $CI->db->where('entrepreneur_education_info.uisc_id', $user->uisc_id);
        $user_info['education_info'] = $CI->db->get()->row();
        //echo $CI->db->last_query();
        if(sizeof($user_info['education_info'])>0)
        {
            if(empty($user_info['education_info']->latest_education) && empty($user_info['education_info']->passing_year))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        ///// TRAINING INFO
        $CI->db->from($CI->config->item('table_training').' entrepreneur_training_info');
        $CI->db->where('entrepreneur_training_info.user_id', $user->id);
        $CI->db->where('entrepreneur_training_info.uisc_id', $user->uisc_id);
        $user_info['training_info'] = $CI->db->get()->row();
        if(sizeof($user_info['training_info'])>0)
        {
            if(empty($user_info['training_info']->course_name) && empty($user_info['training_info']->institute_name) && empty($user_info['training_info']->timespan))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        ///// INVESTMENT INFO
        $CI->db->from($CI->config->item('table_investment').' entrepreneur_investment_info');
        $CI->db->where('entrepreneur_investment_info.user_id', $user->id);
        $CI->db->where('entrepreneur_investment_info.uisc_id', $user->uisc_id);
        $user_info['investment_info'] = $CI->db->get()->row();
        if(sizeof($user_info['investment_info'])>0)
        {
            if(empty($user_info['investment_info']->self_investment) && empty($user_info['investment_info']->invest_debt) && empty($user_info['investment_info']->invested_money) && empty($user_info['investment_info']->invest_sector))
            {
                return false;
            }
        }
        else
        {
            return false;
        }

        ///// CENTER LOCATION INFO
        $CI->db->from($CI->config->item('table_center_location').' entrepreneur_center_location_info');
        $CI->db->where('entrepreneur_center_location_info.uisc_id', $user->uisc_id);
        $user_info['center_location_info'] = $CI->db->get()->row();
        if(sizeof($user_info['center_location_info'])>0)
        {
            if(empty($user_info['center_location_info']->center_type))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        ///// RESOURCES INFO
        $CI->db->from($CI->config->item('table_uisc_resources').' uisc_resources');
        $CI->db->where('uisc_resources.uisc_id', $user->uisc_id);
        $user_info['resources_info'] = $CI->db->get()->row();
        if(sizeof($user_info['resources_info'])<0)
        {
            return false;
        }


        ///// DEVICE INFO
        $CI->db->from($CI->config->item('table_device_infos').' device_infos');
        $CI->db->where('device_infos.uisc_id', $user->uisc_id);
        $user_info['device_info'] = $CI->db->get()->row();
        if(sizeof($user_info['device_info'])>0)
        {
            if(empty($user_info['device_info']->connection_type) && empty($user_info['device_info']->modem) && empty($user_info['device_info']->ip_address))
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        ///// DEVICE INFO
        $CI->db->from($CI->config->item('table_electricity').' entrepreneur_electricity_info');
        $CI->db->where('entrepreneur_electricity_info.uisc_id', $user->uisc_id);
        $user_info['electricity_info'] = $CI->db->get()->row();
        if(sizeof($user_info['electricity_info'])>0)
        {
            if($user_info['electricity_info']->electricity=="" && $user_info['electricity_info']->solar=="" && $user_info['electricity_info']->ips=="")
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        return $user_info;
    }


    public static function mail_send($from = null, $recipient, $cc = NULL, $bcc = NULL, $subject = NULL, $message = NULL)
    {
        $ci = & get_instance();
        if(!empty($recipient))
        {
            $ci->load->library('email');
            $ci->email->set_mailtype("html");
            //        $config['protocol'] = 'sendmail';
            //        $config['mailpath'] = '/usr/sbin/sendmail';
            //        $config['charset'] = 'UTF-8';
            //        $config['wordwrap'] = TRUE;
            //        $ci->email->initialize($config);

            $ci->email->to($recipient);
            if(!empty($from))
            {
                $ci->email->from($from);
            }
            if (!empty($cc))
            {
                $ci->email->cc($cc);
            }
            if (!empty($bcc))
            {
                $ci->email->bcc($bcc);
            }
            $ci->email->subject($subject);
            $ci->email->message(wordwrap($message, 70));
            $ci->email->send();
            //        echo $ci->email->print_debugger();
            return $ci->email->print_debugger();
        }
        else
        {
            return $ci->email->print_debugger();
        }
    }

    /*public static function get_center_count()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();
        if($user->user_group_id==$CI->config->item('UISC_GROUP_ID'))
        {
            return 1;
        }

        $CI->db->from($CI->config->item('table_uisc_infos').' uisc_infos');
        $CI->db->where('uisc_infos.status', 1);
        if($user->user_group_id==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
        }
        else if($user->user_group_id==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
        }
        else if($user->user_group_id==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.upazilla', $user->upazilla);
        }
        else if($user->user_group_id==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.upazilla', $user->upazilla);
            $CI->db->where('uisc_infos.union', $user->union);
        }
        else if($user->user_group_id==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.citycorporation', $user->citycorporation);
        }
        else if($user->user_group_id==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.citycorporation', $user->citycorporation);
            $CI->db->where('uisc_infos.citycorporationward', $user->citycorporationward);
        }
        else if($user->user_group_id==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.municipal', $user->municipal);
        }
        else if($user->user_group_id==$CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
        {
            $CI->db->where('uisc_infos.division', $user->division);
            $CI->db->where('uisc_infos.zilla', $user->zilla);
            $CI->db->where('uisc_infos.municipal', $user->municipal);
            $CI->db->where('uisc_infos.municipalward', $user->municipalward);
        }
        return $CI->db->count_all_results();
    }*/

    /*public static function get_uisc_user_count($gender=0)
    {
        $CI = & get_instance();
        $user=User_helper::get_user();


        $CI->db->from($CI->config->item('core_01_users').' users');
        $CI->db->where('users.status', 1);
        $CI->db->where('users.user_group_id', $CI->config->item('UISC_GROUP_ID'));
        if($gender)
        {
            $CI->db->where('users.gender', $gender);
        }

        if($user->user_group_id==$CI->config->item('DIVISION_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
        }
        else if($user->user_group_id==$CI->config->item('DISTRICT_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
        }
        else if($user->user_group_id==$CI->config->item('UPAZILLA_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.upazilla', $user->upazilla);
        }
        else if($user->user_group_id==$CI->config->item('UNION_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.upazilla', $user->upazilla);
            $CI->db->where('users.union', $user->union);
        }
        else if($user->user_group_id==$CI->config->item('CITY_CORPORATION_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.citycorporation', $user->citycorporation);
        }
        else if($user->user_group_id==$CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.citycorporation', $user->citycorporation);
            $CI->db->where('users.citycorporationward', $user->citycorporationward);
        }
        else if($user->user_group_id==$CI->config->item('MUNICIPAL_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.municipal', $user->municipal);
        }
        else if($user->user_group_id==$CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
        {
            $CI->db->where('users.division', $user->division);
            $CI->db->where('users.zilla', $user->zilla);
            $CI->db->where('users.municipal', $user->municipal);
            $CI->db->where('users.municipalward', $user->municipalward);
        }
        return $CI->db->count_all_results();
    }*/
    /*public static function get_total_services()
    {
        $CI = & get_instance();
        $user=User_helper::get_user();

        $CI->db->from($CI->config->item('table_services').' services');
        $CI->db->where('services.status', 1);
        $total=$CI->db->count_all_results();
        //need to count proposed services
        return $total;
    }*/

}