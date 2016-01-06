<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_direction extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //$this->lang->load('my');
        //$this->load->model("user/Service_template_model");
    }

    public function center()
    {
        $this->load->helper('download');

        $data = file_get_contents(base_url().'download/' . 'center_registration_manual.pdf');
        $name = 'সেন্টার রেজিষ্ট্রেশন ম্যানুয়াল.pdf';
        force_download($name, $data);
    }

    public function entrepreneur()
    {
        $this->load->helper('download');

        $data = file_get_contents(base_url().'download/' . 'entrepreneur_registration_manual.pdf');
        $name = 'উদ্যোক্তা রেজিষ্ট্রেশন ম্যানুয়াল.pdf';
        force_download($name, $data);
    }

    public function profile_update()
    {
        $this->load->helper('download');

        $data = file_get_contents(base_url().'download/' . 'profile_update_manual.pdf');
        $name = 'প্রোফাইল আপডেট.pdf';
        force_download($name, $data);
    }

    public function approval()
    {
        $this->load->helper('download');

        $data = file_get_contents(base_url().'download/' . 'approval_manual.pdf');
        $name = 'রেজিষ্ট্রেশন অনুমোদনের পদ্ধতি.pdf';
        force_download($name, $data);
    }
}
