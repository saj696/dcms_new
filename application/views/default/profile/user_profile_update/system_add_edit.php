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

    <?php
    //print_r($userInfo);
    ?>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('profile/User_profile_update/index/save'); ?>" method="post">
        <input type="hidden" name="id" value="<?php if(isset($userInfo['id'])){echo $userInfo['id'];}else{echo 0;}?>"/>
        <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
        <div class="row widget">
            <div class="widget-header">
                <div class="title">
                    <?php echo $title; ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('PASSWORD'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="password" name="password" id="" class="form-control" value="">
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('CONFIRM_PASSWORD'); ?><span style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="password" name="confirm_password" id="" class="form-control" value="">
                </div>
            </div>
        </div>
    </form>
</div>
