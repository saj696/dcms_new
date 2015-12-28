<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    $CI=& get_instance();
//echo "<pre>";
//print_r($NoticeInfo);
//echo "</pre>";

if(is_array($NoticeInfo) && sizeof($NoticeInfo)>0)
{
    if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==1 && isset($NoticeInfo['detail']))
    {
        $general_group_array = array();
        foreach($NoticeInfo['detail'] as $general)
        {
            $general_group_array[] = $general['viewer_user_group'];
        }
    }
    if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==2 && isset($NoticeInfo['detail']))
    {
        $specific_child_group_array = array();

        foreach($NoticeInfo['detail'] as $specific)
        {
            if($specific['viewer_user_group']>13)
            {
                $specific_child_group_array[] = $specific['viewer_user_group'];
                $child_parent = $CI->notice_create_model->get_child_parent($specific['viewer_user_group']);
            }
            else
            {
                $specific_parent_group = $specific['viewer_user_group'];
            }

            $division = $specific['division'];
            $zilla = $specific['zilla'];
            $upazila = $specific['upazila'];
            $union = $specific['unioun'];
            $citycorporation = $specific['citycorporation'];
            $citycorporationward = $specific['citycorporationward'];
            $municipal = $specific['municipal'];
            $municipalward = $specific['municipalward'];
            $uisc_id = $specific['uisc_id'];
            $user = User_helper::get_user();
            if(($user->user_group_level==$this->config->item('SUPER_ADMIN_GROUP_ID'))||($user->user_group_level==$this->config->item('A_TO_I_GROUP_ID'))||($user->user_group_level==$this->config->item('DONOR_GROUP_ID'))||($user->user_group_level==$this->config->item('MINISTRY_GROUP_ID')))
            {
                $divisions=Query_helper::get_info($this->config->item('table_divisions'),array('divid value', 'divname text'), array());
            }
            else
            {
                $divisions=Query_helper::get_info($this->config->item('table_divisions'),array('divid value', 'divname text'), array('divid ='.$division));
            }

            $zillas=Query_helper::get_info($this->config->item('table_zillas'),array('zillaid value', 'zillaname text'), array('visible = 1', 'divid='.$division));
            $upazilas=Query_helper::get_info($this->config->item('table_upazilas'),array('upazilaid value', 'upazilaname text'), array('visible = 1', 'zillaid='.$zilla));
            $unions=Query_helper::get_info($this->config->item('table_unions'),array('unionid value', 'unionname text'), array('visible = 1', 'zillaid='.$zilla, 'upazilaid='.$upazila));
            $municipals=Query_helper::get_info($this->config->item('table_municipals'),array('municipalid value', 'municipalname text'), array('visible = 1', 'zillaid='.$zilla));
            $municipal_wards=Query_helper::get_info($this->config->item('table_municipal_wards'),array('wardid value', 'wardname text'), array('visible = 1', 'zillaid='.$zilla, 'municipalid='.$municipal));
            $city_corporations=Query_helper::get_info($this->config->item('table_city_corporations'),array('citycorporationid value', 'citycorporationname text'), array('visible = 1', 'zillaid='.$zilla));
            $city_corporation_words=Query_helper::get_info($this->config->item('table_city_corporation_wards'),array('citycorporationwardid value', 'wardname text'), array('visible = 1', 'zillaid='.$zilla, 'citycorporationid='.$citycorporation));
        }
    }
}
?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>

    <?php
    //print_r($NoticeInfo);
    ?>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('notice_management/notice_create/index/save'); ?>" method="post">
        <input type="hidden" name="id" value="<?php if(isset($NoticeInfo['id'])){echo $NoticeInfo['id'];}else{echo 0;}?>"/>
        <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
        <div class="row widget">
            <div class="widget-header">
                <div class="title">
                    <?php echo $title; ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NOTICE_TYPE'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="notice_detail[notice_type]" class="form-control validate[required] notice_type" <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']>0){echo 'disabled';}?>>
                        <option value=""><?php echo $CI->lang->line('SELECT');?></option>
                        <?php
                        $types = $CI->config->item('notice_type');
                        foreach($types as $val=>$name)
                        {
                            ?>
                            <option value="<?php echo $val;?>" <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==$val){echo 'selected';}?>><?php echo $name;?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']>0){?><input type="hidden" name="notice_detail[notice_type]" value="<?php echo $NoticeInfo['notice_type'];?>" /><?php }?>
                </div>
            </div>

            <div class="row show-grid general_notice" style="display: <?php if(isset($general_group_array) && sizeof($general_group_array)>0){echo 'show';}else{echo 'none';}?>;">
                <div class="col-xs-4"></div>
                <div class="col-sm-4 col-xs-8">
                    <table class="table table-responsive table-bordered" >
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="checkAll" id="" name="public_notice" value="1" />
                                    <?php echo $this->lang->line('SELECT_ALL');?>
                                </th>
                                <th><?php //echo $this->lang->line('NOTICE_SENDER_NAME');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(empty($user_groups))
                        {
                            ?>
                            <tr>
                                <th colspan="21"><?php echo $this->lang->line('DATA_NOT_FOUND');?></th>
                            </tr>
                        <?php
                        }
                        else
                        {
                            $i=0;
                            foreach($user_groups as $group)
                            {
                                ?>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="check_in" id="general_user_group[]" name="general_user_group[]" <?php if(isset($general_group_array) && in_array($group['id'], $general_group_array)){echo 'checked';}?> value="<?php echo $group['id'];?>" />
                                    </th>
                                    <th><?php echo $group['name'];?></th>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row show-grid specific_notice" style="display: <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==2){echo 'block';}else{echo 'none';}?>;">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('RECEIVER_USER_LEVEL'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="specific_user_level" class="form-control validate[required] specific_user_level" <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==2){echo 'disabled';}?>>
                        <option value=""><?php echo $CI->lang->line('SELECT');?></option>
                        <?php
                        foreach($user_groups as $user_group)
                        {
                            ?>
                            <option value="<?php echo $user_group['id'];?>" <?php if((isset($specific_parent_group) && $user_group['id']==$specific_parent_group) || (isset($child_parent) && $user_group['id']==$child_parent)){echo 'selected';}?>><?php echo $user_group['name'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <?php if(isset($NoticeInfo['notice_type']) && $NoticeInfo['notice_type']==2){?><input type="hidden" name="specific_user_level" value="<?php if(isset($specific_parent_group)){echo $specific_parent_group;}elseif(isset($child_parent)){echo $child_parent;}?>" /><?php }?>
                </div>
            </div>

            <div class="row show-grid" id="sub_group">
                <?php
                if(isset($child_parent))
                {
                    $sub_groups = $this->notice_create_model->get_sub_groups($child_parent);
                    ?>
                    <div class="col-xs-4">
                        <label class="control-label pull-right"><?php echo $CI->lang->line('RECEIVER_SUB_GROUP'); ?><span style="color:#FF0000">*</span></label>
                    </div>
                    <div class="col-sm-4 col-xs-8">
                        <table class="table table-bordered">
                            <?php
                            foreach($sub_groups as $sub_group)
                            {
                                ?>
                                <tr>
                                    <td style="width: 25px; text-align: center"><input type="checkbox" name="sub_group[]" <?php if(in_array($sub_group['id'], $specific_child_group_array)){echo 'checked';}?> value="<?php echo $sub_group['id']?>" /></td>
                                    <td><label class="control-label"><?php echo $sub_group['name'];?></label></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="row show-grid" style="display: <?php if(isset($uisc_id) && $uisc_id>0){echo 'show';}else{echo 'none';}?>;" id="center_type_div">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CENTER_TYPE'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="center_type" id="center_type" class="form-control" <?php if(isset($uisc_id) && $uisc_id>0){echo 'disabled';}?>>
                        <?php
                        $report_type=array
                        (
                            array("value"=>$this->config->item('ONLINE_UNION_GROUP_ID'), "text"=>$this->lang->line('UDC')),
                            array("value"=>$this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID'), "text"=>$this->lang->line('CDC')),
                            array("value"=>$this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID'), "text"=>$this->lang->line('PDC')),
                        );

                        if(isset($uisc_id) && $uisc_id>0)
                        {
                            if($upazila>0){$dc_select = $this->config->item('ONLINE_UNION_GROUP_ID');}
                            if($citycorporation>0){$dc_select = $this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID');}
                            if($municipal>0){$dc_select = $this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID');}
                            $CI->load_view('dropdown',array('drop_down_options'=>$report_type, 'drop_down_selected'=>$dc_select));
                        }
                        else
                        {
                            $CI->load_view('dropdown',array('drop_down_options'=>$report_type));
                        }
                        ?>
                    </select>
                    <?php if(isset($uisc_id) && $uisc_id>0){?><input type="hidden" name="center_type" value="<?php echo $dc_select;?>" /><?php }?>
                </div>
            </div>

            <div style="display: <?php if(isset($division) && $division>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid" id="division_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DIVISION_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="division" id="user_division_id" class="form-control" <?php if(isset($division) && $division>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$divisions, 'drop_down_selected'=>isset($division)?$division:''));
                        ?>
                    </select>
                    <?php if(isset($division) && $division>0){?><input type="hidden" name="division" value="<?php echo $division;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($zilla) && $zilla>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid" id="zilla_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DISTRICT_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="zilla" id="user_zilla_id" class="form-control" <?php if(isset($zilla) && $zilla>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$zillas, 'drop_down_selected'=>isset($zilla)?$zilla:''));
                        ?>
                    </select>
                    <?php if(isset($zilla) && $zilla>0){?><input type="hidden" name="zilla" value="<?php echo $zilla;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($upazila) && $upazila>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid" id="upazila_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('UPAZILLA_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="upazila" id="user_upazila_id" class="form-control" <?php if(isset($upazila) && $upazila>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$upazilas, 'drop_down_selected'=>isset($upazila)?$upazila:''));
                        ?>
                    </select>
                    <?php if(isset($upazila) && $upazila>0){?><input type="hidden" name="upazila" value="<?php echo $upazila;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($union) && $union>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid" id="union_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('UNION_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="union" id="user_unioun_id" class="form-control" <?php if(isset($union) && $union>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$unions, 'drop_down_selected'=>isset($union)?$union:''));
                        ?>
                    </select>
                    <?php if(isset($union) && $union>0){?><input type="hidden" name="union" value="<?php echo $union;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($citycorporation) && $citycorporation>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid " id="city_corporation_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CITY_CORPORATION_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="city_corporation" id="user_citycorporation_id" class="form-control" <?php if(isset($citycorporation) && $citycorporation>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$city_corporations, 'drop_down_selected'=>isset($citycorporation)?$citycorporation:''));
                        ?>
                    </select>
                    <?php if(isset($citycorporation) && $citycorporation>0){?><input type="hidden" name="city_corporation" value="<?php echo $citycorporation;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($citycorporationward) && $citycorporationward>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid " id="city_corporation_ward_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CITY_CORPORATION_WARD_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="city_corporation_ward" id="user_city_corporation_ward_id" class="form-control" <?php if(isset($citycorporationward) && $citycorporationward>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$city_corporation_words, 'drop_down_selected'=>isset($citycorporationward)?$citycorporationward:''));
                        ?>
                    </select>
                    <?php if(isset($citycorporationward) && $citycorporationward>0){?><input type="hidden" name="city_corporation_ward" value="<?php echo $citycorporationward;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($municipal) && $municipal>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid " id="municipal_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MUNICIPAL_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="municipal" id="user_municipal_id" class="form-control" <?php if(isset($municipal) && $municipal>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$municipals, 'drop_down_selected'=>isset($municipal)?$municipal:''));
                        ?>
                    </select>
                    <?php if(isset($municipal) && $municipal>0){?><input type="hidden" name="municipal" value="<?php echo $municipal;?>" /><?php }?>
                </div>
            </div>
            <div style="display: <?php if(isset($municipalward) && $municipalward>0){echo 'show';}else{echo 'none';}?>;" class="row show-grid " id="municipal_ward_option">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MUNICIPAL_WARD_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="municipal_ward" id="user_municipal_ward_id" class="form-control" <?php if(isset($municipalward) && $municipalward>0){echo 'disabled';}?>>
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$unions, 'drop_down_selected'=>isset($municipalward)?$municipalward:''));
                        ?>
                    </select>
                    <?php if(isset($municipalward) && $municipalward>0){?><input type="hidden" name="municipal_ward" value="<?php echo $municipalward;?>" /><?php }?>
                </div>
            </div>
            <div class="row show-grid" style="display: <?php if(isset($uisc_id) && $uisc_id>0){echo 'show';}else{echo 'none';}?>;" id="digital_center_div">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DIGITAL_CENTER'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="digital_center" id="digital_center" class="form-control" <?php if(isset($uisc_id) && $uisc_id>0){echo 'disabled';}?>>
                        <?php
                        if(isset($uisc_id) && $uisc_id>0)
                        {
                            if($upazila>0)
                            {
                                $center_type_udc = $this->config->item('ONLINE_UNION_GROUP_ID');
                                $udcs = Query_helper::get_info($this->config->item('table_uisc_infos'),array('id value', 'uisc_name text'), array('uisc_type = '.$center_type_udc, 'zilla = '.$zilla, 'upazilla = '.$upazila, 'union = '.$union));
                                $CI->load_view("dropdown",array('drop_down_options'=>$udcs, 'drop_down_selected'=>$uisc_id));
                            }
                            if($citycorporation>0)
                            {
                                $center_type_cdc = $this->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID');
                                $cdcs = Query_helper::get_info($this->config->item('table_uisc_infos'),array('id value', 'uisc_name text'), array('uisc_type = '.$center_type_cdc, 'zilla = '.$zilla, 'citycorporation = '.$citycorporation, 'citycorporationward = '.$citycorporationward));
                                $CI->load_view("dropdown",array('drop_down_options'=>$cdcs, 'drop_down_selected'=>$uisc_id));
                            }
                            if($municipal>0)
                            {
                                $center_type_pdc = $this->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID');
                                $pdcs = Query_helper::get_info($this->config->item('table_uisc_infos'),array('id value', 'uisc_name text'), array('uisc_type = '.$center_type_pdc, 'zilla = '.$zilla, 'municipal = '.$municipal, 'municipalward = '.$municipalward));
                                $CI->load_view("dropdown",array('drop_down_options'=>$pdcs, 'drop_down_selected'=>$uisc_id));
                            }
                            ?>
                            <input type="hidden" name="digital_center" value="<?php echo $uisc_id;?>" />
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NOTICE_TITLE'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="notice_detail[notice_title]" class="form-control" value="<?php if(isset($NoticeInfo['notice_title'])){echo $NoticeInfo['notice_title'];}?>" />
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NOTICE_DETAILS'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea name="notice_detail[notice_details]" class="form-control "><?php if(isset($NoticeInfo['notice_details'])){echo $NoticeInfo['notice_details'];}?></textarea>
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('FILE_UPLOAD'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="file" name="upload_file" class="" value="">
                    <?php
                    if(isset($NoticeInfo['upload_file']) && !empty($NoticeInfo['upload_file']))
                    {
                        ?>
                        <a style="color: green;" href="<?php echo base_url().'images/notice/'.$NoticeInfo['upload_file']?>" target="_blank">
                            <?php echo $CI->lang->line('DOWNLOAD'); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="notice_detail[status]" class="form-control" id="module_options">
                        <?php
                        $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('PUBLISHED'),'value'=>$this->config->item('STATUS_ACTIVE')),array('text'=>$CI->lang->line('UN_PUBLISHED'),'value'=>$this->config->item('STATUS_INACTIVE'))),'drop_down_selected'=>isset($NoticeInfo['status'])?$NoticeInfo['status']:$this->config->item('STATUS_ACTIVE')));
                        ?>
                    </select>
                </div>
            </div>

        </div>
    </form>
</div>
<script>
    $(document).ready(function ()
    {
        turn_off_triggers();
        $(document).on("click",'.checkAll',function()
        {
            if($(this).is(':checked'))
            {
                $('.check_in').prop('checked', true);
            }
            else
            {
                $('.check_in').prop('checked', false);
            }
        });

        $(document).on("change",'.notice_type',function()
        {
            if($(this).val()==1)
            {
                $(".general_notice").show();
                $(".specific_notice").hide();
                $("#sub_group").html('');
                $(".specific_user_level").val('');
            }
            else if($(this).val()==2)
            {
                $(".general_notice").hide();
                $(".specific_notice").show();
                $("#sub_group").html('');
                $(".specific_user_level").val('');
            }
            else
            {
                $(".general_notice").hide();
                $(".specific_notice").hide();
                $("#sub_group").html('');
                $(".specific_user_level").val('');
            }

            $("#division_option").hide();
            $("#user_division_id").val('');
            $("#zilla_option").hide();
            $("#user_zilla_id").val('');

            $("#upazila_option").hide();
            $("#user_upazila_id").val('');
            $("#union_option").hide();
            $("#user_unioun_id").val('');

            $("#city_corporation_option").hide();
            $("#user_citycorporation_id").val('');
            $("#city_corporation_ward_option").hide();
            $("#user_city_corporation_ward_id").val('');

            $("#municipal_option").hide();
            $("#user_municipal_id").val('');
            $("#municipal_ward_option").hide();
            $("#user_municipal_ward_id").val('');

            $("#center_type_div").hide();
            $("#center_type").val('');
        });

        $(document).on("change",'.specific_user_level',function()
        {
            $("#user_division_id").val('');
            $("#zilla_option").hide();
            $("#user_zilla_id").val('');

            $("#upazila_option").hide();
            $("#user_upazila_id").val('');
            $("#union_option").hide();
            $("#user_unioun_id").val('');

            $("#city_corporation_option").hide();
            $("#user_citycorporation_id").val('');
            $("#city_corporation_ward_option").hide();
            $("#user_city_corporation_ward_id").val('');

            $("#municipal_option").hide();
            $("#user_municipal_id").val('');
            $("#municipal_ward_option").hide();
            $("#user_municipal_ward_id").val('');

            $("#digital_center_div").hide();
            $("#digital_center").val("");

            var user_level = $(this).val();

            if(user_level==<?php echo $CI->config->item('UISC_GROUP_ID');?>)
            {
                $("#center_type_div").show();
            }
            else
            {
                $("#center_type_div").hide();
                $("#center_type").val('');
            }

            if(user_level>0)
            {
                if(user_level == <?php echo $CI->config->item('A_TO_I_GROUP_ID');?> || user_level == <?php echo $CI->config->item('DONOR_GROUP_ID');?> || user_level == <?php echo $CI->config->item('MINISTRY_GROUP_ID');?>)
                {
                    $("#division_option").hide();
                }
                else
                {
                    $("#division_option").show();
                }

                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('notice_management/Notice_create/get_sub_group'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{user_level:user_level},
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
                $("#sub_group").html('');
                $("#division_option").hide();
            }
        });

        $(document).on("change","#center_type",function()
        {
            $("#user_division_id").val('');
            $("#zilla_option").hide();
            $("#user_zilla_id").val('');

            $("#upazila_option").hide();
            $("#user_upazila_id").val('');
            $("#union_option").hide();
            $("#user_unioun_id").val('');

            $("#city_corporation_option").hide();
            $("#user_citycorporation_id").val('');
            $("#city_corporation_ward_option").hide();
            $("#user_city_corporation_ward_id").val('');

            $("#municipal_option").hide();
            $("#user_municipal_id").val('');
            $("#municipal_ward_option").hide();
            $("#user_municipal_ward_id").val('');

            $("#digital_center_div").hide();
            $("#digital_center").val("");
        });

        $(document).on("change","#user_division_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var division_user_level = <?php echo $CI->config->item('DIVISION_GROUP_ID');?>;

            $("#union_option").hide();
            $("#upazila_option").hide();
            $("#zilla_option").show();

            $("#user_unioun_id").val("");
            $("#user_upazila_id").val("");
            $("#user_zilla_id").val("");

            $("#city_corporation_ward_option").hide();
            $("#city_corporation_option").hide();
            $("#zilla_option").show();

            $("#user_unioun_id").val("");
            $("#user_upazila_id").val("");
            $("#user_zilla_id").val("");

            $("#municipal_ward_option").hide();
            $("#municipal_option").hide();
            $("#zilla_option").show();

            $("#user_unioun_id").val("");
            $("#user_upazila_id").val("");
            $("#user_zilla_id").val("");

            var division_id=$(this).val();
            if(division_id>0 && specific_user_level>division_user_level)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_zilla'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{division_id:division_id},
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
                $("#zilla_option").hide();
            }
        });

        $(document).on("change","#user_zilla_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var center_type = $("#center_type").val();

            var zilla_user_level = <?php echo $CI->config->item('DISTRICT_GROUP_ID');?>;
            var city_corporation_user_level = <?php echo $CI->config->item('CITY_CORPORATION_GROUP_ID');?>;
            var city_corporation_word_user_level = <?php echo $CI->config->item('CITY_CORPORATION_WORD_GROUP_ID');?>;
            var municipal_user_level = <?php echo $CI->config->item('MUNICIPAL_GROUP_ID');?>;
            var municipal_word_user_level = <?php echo $CI->config->item('MUNICIPAL_WORD_GROUP_ID');?>;
            var upazila_user_level = <?php echo $CI->config->item('UPAZILLA_GROUP_ID');?>;
            var union_user_level = <?php echo $CI->config->item('UNION_GROUP_ID');?>;

            var zilla_id=$(this).val();
            var division_id=$("#user_division_id").val();

            if(specific_user_level==upazila_user_level || specific_user_level==union_user_level || center_type==<?php echo $CI->config->item('ONLINE_UNION_GROUP_ID');?>)
            {
                $("#union_option").hide();
                $("#upazila_option").show();

                $("#user_unioun_id").val("");
                $("#user_upazila_id").val("");

                if(zilla_id>0)
                {
                    $.ajax({
                        url: '<?php echo $CI->get_encoded_url('common/get_upazila'); ?>',
                        type: 'POST',
                        dataType: "JSON",
                        data:{zilla_id:zilla_id},
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
                    $("#upazila_option").hide();
                }
            }
            else if(specific_user_level==city_corporation_user_level || specific_user_level==city_corporation_word_user_level || center_type==<?php echo $CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID');?>)
            {
                $("#city_corporation_ward_option").hide();
                $("#city_corporation_option").show();

                $("#user_city_corporation_ward_id").val("");
                $("#user_citycorporation_id").val("");

                if(zilla_id>0)
                {
                    $.ajax({
                        url: '<?php echo $CI->get_encoded_url('common/get_city_corporation'); ?>',
                        type: 'POST',
                        dataType: "JSON",
                        data:{zilla_id:zilla_id, division_id:division_id},
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
                    $("#city_corporation_option").hide();
                }
            }
            else if(specific_user_level==municipal_user_level || specific_user_level==municipal_word_user_level || center_type==<?php echo $CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID');?>)
            {
                $("#municipal_ward_option").hide();
                $("#municipal_option").show();

                $("#user_municipal_ward_id").val("");
                $("#user_municipal_id").val("");
                if(zilla_id>0)
                {
                    $.ajax({
                        url: '<?php echo $CI->get_encoded_url('common/get_municipal'); ?>',
                        type: 'POST',
                        dataType: "JSON",
                        data:{zilla_id:zilla_id},
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
                    $("#municipal_option").hide();
                }
            }

        });

        $(document).on("change","#user_upazila_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var upazila_user_level = <?php echo $CI->config->item('UPAZILLA_GROUP_ID');?>;

            $("#union_option").show();
            $("#user_unioun_id").val("");
            var zilla_id=$("#user_zilla_id").val();
            var upazila_id=$(this).val();

            if(upazila_id>0 && specific_user_level>upazila_user_level)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_union'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, upazila_id:upazila_id},
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
                $("#union_option").hide();
            }
        });

        $(document).on("change","#user_unioun_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var center_type = $("#center_type").val();

            var zilla_id=$("#user_zilla_id").val();
            var upazila_id=$("#user_upazila_id").val();
            var union_id = $(this).val();

            if(union_id>0 && center_type==<?php echo $CI->config->item('ONLINE_UNION_GROUP_ID');?>)
            {
                $("#digital_center_div").show();

                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_udc'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, upazila_id:upazila_id, union_id:union_id},
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
                $("#digital_center_div").hide();
                $("#digital_center").val("");
            }
        });

        $(document).on("change","#user_municipal_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var municipal_user_level = <?php echo $CI->config->item('MUNICIPAL_GROUP_ID');?>;

            $("#municipal_ward_option").show();
            $("#user_unioun_id").val("");
            var zilla_id=$("#user_zilla_id").val();
            var municipal_id=$(this).val();

            if(municipal_id>0 && specific_user_level>municipal_user_level)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_municipal_ward'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, municipal_id:municipal_id},
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
                $("#municipal_ward_option").hide();
            }
        });

        $(document).on("change","#user_municipal_ward_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var center_type = $("#center_type").val();

            var zilla_id=$("#user_zilla_id").val();
            var municipal_id=$("#user_municipal_id").val();
            var municipal_word_id = $(this).val();

            if(municipal_word_id>0 && center_type==<?php echo $CI->config->item('ONLINE_MUNICIPAL_WORD_GROUP_ID');?>)
            {
                $("#digital_center_div").show();

                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_pdc'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, municipal_id:municipal_id, municipal_word_id:municipal_word_id},
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
                $("#digital_center_div").hide();
                $("#digital_center").val("");
            }
        });

        $(document).on("change","#user_citycorporation_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var city_corporation_user_level = <?php echo $CI->config->item('CITY_CORPORATION_GROUP_ID');?>;

            $("#city_corporation_ward_option").show();
            $("#user_unioun_id").val("");
            var division_id=$("#user_division_id").val();
            var zilla_id=$("#user_zilla_id").val();
            var city_corporation_id=$(this).val();

            if(city_corporation_id>0 && specific_user_level>city_corporation_user_level)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_city_corporation_word'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, division_id:division_id, city_corporation_id: city_corporation_id},
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
                $("#city_corporation_ward_option").hide();
            }
        });

        $(document).on("change","#user_city_corporation_ward_id",function()
        {
            var specific_user_level = $(".specific_user_level").val();
            var center_type = $("#center_type").val();

            var zilla_id=$("#user_zilla_id").val();
            var city_corporation_id=$("#user_citycorporation_id").val();
            var city_corporation_word_id = $(this).val();

            if(city_corporation_word_id>0 && center_type==<?php echo $CI->config->item('ONLINE_CITY_CORPORATION_WORD_GROUP_ID');?>)
            {
                $("#digital_center_div").show();

                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('common/get_cdc'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{zilla_id:zilla_id, city_corporation_id:city_corporation_id, city_corporation_word_id:city_corporation_word_id},
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
                $("#digital_center_div").hide();
                $("#digital_center").val("");
            }
        });

    });
</script>
