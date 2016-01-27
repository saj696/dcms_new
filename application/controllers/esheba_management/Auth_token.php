<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_token extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->helper('string');

    }

    public function index($service_id)
    {
        $user=User_helper::get_user();
        $time=time();
        $service_info=Query_helper::get_info($this->config->item('table_api_services'),'*',array('status =1','id ='.$service_id),1);
        if($service_info)
        {
            $data['auth_token']=random_string('unique').$time;
            $data['user_id']=$user->id;
            $data['service_id']=$service_id;
            $data['time']=$time;
            $data['status']=1;
            $id=Query_helper::add($this->config->item('table_api_auth_token'),$data);
            if($id)
            {
                redirect($service_info['service_url'].$data['auth_token'], 'refresh');
            }else
            {
                echo "Unable to save data";
            }

        }
        else
        {
            echo "invalid service";
        }

    }
}
