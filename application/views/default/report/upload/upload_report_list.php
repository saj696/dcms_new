<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user=User_helper::get_user();
//echo date('d-m-Y','1440323287');

?>
<div id="system_content" class="system_content_margin">
    <div class="col-lg-4">
        <?php
        $CI->load_view("report/report_menus");
        ?>

    </div>
    <div class="col-lg-8">

        <div class="clearfix"></div>
        <form class="report_form" id="system_save_form" action="<?php echo $CI->get_encoded_url('report/upload/upload_report_view/index/list'); ?>" method="get">
            <div class="row widget">
                <div class="widget-header">
                    <div class="title">
                        <?php echo $title; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row show-grid ">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('DIGITAL_CENTER'); ?><span style="color:#FF0000">*</span></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="report_type" id="report_type" class="form-control">
                            <?php
                            $report_type=array
                            (
                                array("value"=>$this->config->item('ONLINE_UNION_GROUP_ID'), "text"=>$this->lang->line('UDC')),
                                array("value"=>$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'), "text"=>$this->lang->line('CDC')),
                                array("value"=>$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'), "text"=>$this->lang->line('PDC')),
                            );
                            $CI->load_view('dropdown',array('drop_down_options'=>$report_type));
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row" id="go_location" style="display: none">

                </div>

                <!--<div class="row show-grid ">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php /*echo $CI->lang->line('STATUS'); */?><span style="color:#FF0000">*</span></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="status" id="status" class="form-control">
                            <?php
/*                            $report_type=array
                            (
                                array("value"=>"100", "text"=>$this->lang->line('ALL_DATA_100')),
                                array("value"=>"60", "text"=>$this->lang->line('REGULAR_41_100')),
                                array("value"=>"40", "text"=>$this->lang->line('IRREGULAR_1_40')),
                                array("value"=>"0", "text"=>$this->lang->line('CLOSED_0_0')),
                            );
                            $CI->load_view('dropdown',array('drop_down_options'=>$report_type));
                            */?>
                        </select>
                    </div>
                </div>-->
                <input type="hidden" name="status" value="100">
                <div class="row show-grid ">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('MONTH'); ?><span style="color:#FF0000">*</span></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="month" id="month" class="form-control">
                            <option selected="" value=""><?= $CI->lang->line('SELECT') ?></option>
                            <?php
                            foreach($CI->config->item('month') as $key=>$item)
                            {
                                ?>
                                <option value="<?= $key ?>"><?= $item ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row show-grid ">
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('YEAR'); ?><span style="color:#FF0000">*</span></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <select name="year" id="year" class="form-control">
                            <?php
                            $CI->load_view('dropdown',array('drop_down_options'=>$CI->config->item('approval_year')));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row show-grid">
                    <div class="col-xs-4">

                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <input type="submit" class="btn btn-primary" value="<?php echo $CI->lang->line('SEARCH'); ?>">
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>

    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        $( ".report_date" ).datepicker({dateFormat : display_date_format});
        $(document).on("change","#report_type",function()
        {

            $("#go_location").html('');
            var report_type_id=$(this).val();
            var report_go_url='';
            if(report_type_id=="<?php echo $this->config->item('ONLINE_UNION_GROUP_ID');?>")
            {
                report_go_url="<?php echo $CI->get_encoded_url('report/upload/Upload_report_union_list/index'); ?>";
            }
            else if(report_type_id=="<?php echo $this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID');?>")
            {
                report_go_url="<?php echo $CI->get_encoded_url('report/upload/Upload_report_city_corporation_list/index'); ?>";
            }
            else if(report_type_id=="<?php echo $this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID');?>")
            {
                report_go_url="<?php echo $CI->get_encoded_url('report/upload/Upload_report_municipal_list/index'); ?>";
            }
            else
            {
                report_go_url='';
            }
            if(report_type_id>0 && report_go_url!='')
            {
                $("#go_location").show();

                $.ajax({
                    url: report_go_url,
                    type: 'POST',
                    dataType: "JSON",
                    data:{report_type_id:report_type_id},
                    success: function (data, status)
                    {

                    },
                    error: function (xhr, desc, err)
                    {
                        console.log("error");

                    }
                });
            }
            else
            {
                $("#go_location").hide();
                $("#go_location").html('');

            }
        });

    });
</script>