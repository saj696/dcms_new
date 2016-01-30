<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_update_status_report_view extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->message = '';
        //$this->controller_url='report/upload_report_model';
        $this->load->model("report/Profile_update_status_report_model");
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
    }

    public function index($task = "search", $id = 0)
    {
        if ($task == "list") {
            $this->report_list();
        } else if ($task == "pdf") {
            $this->report_list("pdf");
        } else {
            $this->search();
        }
    }


    private function report_list($format = "")
    {
        $inputs = $this->input->get();
        $results = $this->Profile_update_status_report_model->get_all_user_info($inputs);

        $user_info = [];
        foreach ($results as $result) {
            if (!empty($result['entrepreneur_id'])) {
                if (empty($result['entrepreneur_type']) && empty($result['entrepreneur_name']) && empty($result['entrepreneur_father_name']) && empty($result['entrepreneur_mother_name']) && empty($result['entrepreneur_mobile']) && empty($result['entrepreneur_email']) && empty($result['entrepreneur_sex']) && empty($result['entrepreneur_address']) && empty($result['entrepreneur_nid'])) {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['education_id'])) {
                if (empty($result['latest_education']) && empty($result['passing_year'])) {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['training_id'])) {
                if (empty($result['course_name']) && empty($result['institute_name']) && empty($result['timespan'])) {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['investment_id'])) {
                if (empty($result['self_investment']) && empty($result['invest_debt']) && empty($result['invested_money']) && $result['invest_sector'] == '') {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['center_location_id'])) {
                if (empty($result['center_type'])) {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (empty($result['uisc_resources_id'])) {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['device_info_id'])) {
                if (empty($result['connection_type']) && empty($result['modem']) && empty($result['ip_address'])) {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

            if (!empty($result['electricity_id'])) {
                if ($result['electricity'] == "" && $result['solar'] == "" && $result['ips'] == "") {
                    array_push($user_info, $result);
                    continue;
                }
            } else {
                array_push($user_info, $result);
                continue;
            }

        }

        $data['user_info'] = $user_info;
        /*echo "<pre>";
        print_r($data);
        echo "</pre>";
        die;*/
        if ($format != "pdf") {
            if($inputs['report_type']==1)
            {
                $data['title'] = $this->lang->line("REPORT_UNION_USER_PROFILE_UPDATE_STATUS");
                $this->load->view('default/report/profile_update_status/report_union', $data);
            }elseif($inputs['report_type']==2)
            {
                $data['title'] = $this->lang->line("REPORT_CITYCORPORATION_USER_PROFILE_UPDATE_STATUS");
                $this->load->view('default/report/profile_update_status/report_citycorporation', $data);
            }elseif($inputs['report_type']==3)
            {
                $data['title'] = $this->lang->line("REPORT_MUNICIPAL_USER_PROFILE_UPDATE_STATUS");
                $this->load->view('default/report/profile_update_status/report_municipal', $data);
            }

        } else {
            $html="";
            if($inputs['report_type']==1)
            {
                $data['title'] = $this->lang->line("REPORT_UNION_USER_PROFILE_UPDATE_STATUS");
                $html = $this->load->view('default/report/profile_update_status/report_union', $data,true);
            }elseif($inputs['report_type']==2)
            {
                $data['title'] = $this->lang->line("REPORT_CITYCORPORATION_USER_PROFILE_UPDATE_STATUS");
                $html = $this->load->view('default/report/profile_update_status/report_citycorporation', $data,true);
            }elseif($inputs['report_type']==3)
            {
                $data['title'] = $this->lang->line("REPORT_MUNICIPAL_USER_PROFILE_UPDATE_STATUS");
                $html = $this->load->view('default/report/profile_update_status/report_municipal', $data,true);
            }
            echo $html;
            System_helper::get_pdf($html);
        }
    }

}
