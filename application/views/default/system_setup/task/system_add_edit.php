<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('system_setup/task/index/save'); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $task_info['id'];?>"/>
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
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NAME_EN'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="name_en" class="form-control" value="<?php echo $task_info['name_en'];?>">
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('NAME_BN'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="name_bn" class="form-control" value="<?php echo $task_info['name_bn'];?>">
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('COMPONENT_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="component_id" class="form-control" id="component_options">
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$components_list,'drop_down_selected'=>$task_info['component_id']));
                        ?>
                    </select>
                </div>
            </div>
            <div style="<?php if(!($task_info['id']>0)){echo 'display:none';} ?>" class="row show-grid" id="module_container">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MODULE_NAME'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="module_id" class="form-control" id="module_options">
                        <?php
                        $CI->load_view('dropdown',array('drop_down_options'=>$module_list,'drop_down_selected'=>$task_info['module_id']));
                        ?>
                    </select>
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CONTROLLER'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="controller" class="form-control" value="<?php echo $task_info['controller'];?>">
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('ICON'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="icon" class="form-control" value="<?php echo $task_info['icon'];?>">
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('AT_LEFT_MENU'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="checkbox" name="<?php echo $CI->config->item('system_sidebar01') ?>" value="1" <?php if($task_info[$CI->config->item('system_sidebar01')]==1) echo "checked";?>>
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('AT_TOP_MENU'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="checkbox" name="<?php echo $CI->config->item('system_sidebar02') ?>" value="1" <?php if($task_info[$CI->config->item('system_sidebar02')]==1) echo "checked";?>>
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DESCRIPTION'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea name="description" class="form-control"><?php echo $task_info['description'];?></textarea>

                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('ORDERING'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="ordering" class="form-control" value="<?php echo $task_info['ordering'];?>">
                </div>
            </div>
            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="status" class="form-control" id="module_options">
                        <?php
                        $CI->load_view('dropdown',array('drop_down_default_option'=>false,'drop_down_options'=>array(array('text'=>$CI->lang->line('INACTIVE'),'value'=>0),array('text'=>$CI->lang->line('ACTIVE'),'value'=>1)),'drop_down_selected'=>$task_info['status']));
                        ?>
                    </select>
                </div>
            </div>




        </div>

        <div class="clearfix"></div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        turn_off_triggers();
        $(document).on("change","#component_options",function()
        {
            $("#module_container").show();
            $("#module_options").val("");
            var component_id=$(this).val();
            if(component_id>0)
            {
                $.ajax({
                    url: '<?php echo $CI->get_encoded_url('system_setup/task/get_modules_by_component_id'); ?>',
                    type: 'POST',
                    dataType: "JSON",
                    data:{component_id:component_id},
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
                $("#module_container").hide();
            }



        });
    });
</script>