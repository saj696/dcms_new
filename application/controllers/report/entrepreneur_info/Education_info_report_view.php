<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Education_info_report_view extends CI_Controller
{
    public $permissions;
    function __construct()
    {
        parent::__construct();
        //TODO
        //check security and loged user
        $this->lang->load("report", $this->config->item('GET_LANGUAGE'));
        $this->lang->load("my", $this->config->item('GET_LANGUAGE'));
        $this->load->model("report/entrepreneur_info_report_model");
    }

    public function index($task="search",$id=0)
    {
        if($task=="list")
        {
            $this->report_list();
        }
        else if($task=="pdf")
        {
            $this->report_list("pdf");
        }
        else
        {
            $this->search();
        }
    }
    private function report_list($format="")
    {
        if($format!="pdf")
        {

            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $data['report_type']=$this->input->get('report_type');
            //$status=$this->input->get('status');
            //            $from_date=$this->input->get('from_date');
            //            $to_date=$this->input->get('to_date');
            //            $data['from_date']=$from_date;
            //            $data['to_date']=$to_date;
            //$data['report_status']=$status;

            if($this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {

                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');

                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('UPAZILLA_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_upazilla_level($division, $zilla);
                        if(!empty($upazila))
                        {
                            $data['element_caption']=$this->lang->line('UNION_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_union_level($division, $zilla, $upazila);
                            if(!empty($union))
                            {
                                $data['element_caption']=$this->lang->line('UNION_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_union_level($division, $zilla, $upazila, $union);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_division_level();
                }
                $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                //$data['report']=$this->entrepreneur_info_report_model->get_entrepreneur_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward);
                //$this->load->view('default/report/entrepreneur_info/education_info_city_corporation_report',$data);
                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('CITY_CORPORATION_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_level($division, $zilla);
                        if(!empty($city_corporation))
                        {
                            $data['element_caption']=$this->lang->line('CITY_CORPORATION_WARD_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_ward_level($division, $zilla, $city_corporation);
                            if(!empty($city_corporation_ward))
                            {
                                $data['element_caption']=$this->lang->line('CITY_CORPORATION_WARD_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_ward_level($division, $zilla, $city_corporation, $city_corporation_ward);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_division_level();
                }
                $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                //$data['report']=$this->entrepreneur_info_report_model->get_entrepreneur_info_municipal($division, $zilla, $municipal, $municipal_ward);
                //$this->load->view('default/report/entrepreneur_info/education_info_municipal_report',$data);
                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('MUNICIPAL_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_level($division, $zilla);
                        if(!empty($municipal))
                        {
                            $data['element_caption']=$this->lang->line('MUNICIPAL_WARD_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_ward_level($division, $zilla, $municipal);
                            if(!empty($municipal_ward))
                            {
                                $data['element_caption']=$this->lang->line('MUNICIPAL_WARD_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_ward_level($division, $zilla, $municipal, $municipal_ward);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_division_level();
                }
                $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $data['report']='';

            }
        }
        else
        {
            $division=$this->input->get('division');
            $zilla=$this->input->get('zilla');
            $data['report_type']=$this->input->get('report_type');
            //$status=$this->input->get('status');
            //            $from_date=$this->input->get('from_date');
            //            $to_date=$this->input->get('to_date');
            //            $data['from_date']=$from_date;
            //            $data['to_date']=$to_date;
            //$data['report_status']=$status;

            if($this->input->get('report_type')==$this->config->item('ONLINE_UNION_GROUP_ID'))
            {

                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $upazila=$this->input->get('upazila');
                $union=$this->input->get('union');

                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('UPAZILLA_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_upazilla_level($division, $zilla);
                        if(!empty($upazila))
                        {
                            $data['element_caption']=$this->lang->line('UNION_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_union_level($division, $zilla, $upazila);
                            if(!empty($union))
                            {
                                $data['element_caption']=$this->lang->line('UNION_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_union_level($division, $zilla, $upazila, $union);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_division_level();
                }
                $html = $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data, true);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $city_corporation=$this->input->get('city_corporation');
                $city_corporation_ward=$this->input->get('city_corporation_ward');
                //$data['report']=$this->entrepreneur_info_report_model->get_entrepreneur_info_city_corporation($division, $zilla, $city_corporation, $city_corporation_ward);
                //$this->load->view('default/report/entrepreneur_info/education_info_city_corporation_report',$data);
                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('CITY_CORPORATION_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_level($division, $zilla);
                        if(!empty($city_corporation))
                        {
                            $data['element_caption']=$this->lang->line('CITY_CORPORATION_WARD_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_ward_level($division, $zilla, $city_corporation);
                            if(!empty($city_corporation_ward))
                            {
                                $data['element_caption']=$this->lang->line('CITY_CORPORATION_WARD_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_ward_level($division, $zilla, $city_corporation, $city_corporation_ward);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_city_corporation_division_level();
                }
                $html = $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data, true);
            }
            else if($this->input->get('report_type')==$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'))
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $municipal=$this->input->get('municipal');
                $municipal_ward=$this->input->get('municipal_ward');
                //$data['report']=$this->entrepreneur_info_report_model->get_entrepreneur_info_municipal($division, $zilla, $municipal, $municipal_ward);
                //$this->load->view('default/report/entrepreneur_info/education_info_municipal_report',$data);
                if(!empty($division))
                {
                    $data['element_caption']=$this->lang->line('ZILLA_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_zilla_level($division);
                    if(!empty($zilla))
                    {
                        $data['element_caption']=$this->lang->line('MUNICIPAL_NAME');
                        $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_level($division, $zilla);
                        if(!empty($municipal))
                        {
                            $data['element_caption']=$this->lang->line('MUNICIPAL_WARD_NAME');
                            $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_ward_level($division, $zilla, $municipal);
                            if(!empty($municipal_ward))
                            {
                                $data['element_caption']=$this->lang->line('MUNICIPAL_WARD_NAME');
                                $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_ward_level($division, $zilla, $municipal, $municipal_ward);
                            }
                        }
                    }
                }
                else
                {
                    $data['element_caption']=$this->lang->line('DIVISION_NAME');
                    $data['report']=$this->entrepreneur_info_report_model->get_education_info_municipal_division_level();
                }
                $html = $this->load->view('default/report/entrepreneur_info/education_info_union_report',$data, true);
            }
            else
            {
                $data['title']=$this->lang->line("REPORT_ENTREPRENEUR_INFO_TITLE");
                $data['report']='';

            }
            System_helper::get_pdf($html);
        }
    }

}