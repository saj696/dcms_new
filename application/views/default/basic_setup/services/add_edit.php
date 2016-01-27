<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('basic_setup/services/index/save'); ?>"
          method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php if (isset($service['id'])) {
            echo $service['id'];
        } else {
            echo 0;
        } ?>"/>
        <input type="hidden" name="system_save_new_status" id="system_save_new_status" value="0"/>
        <div class="row widget">
            <div class="widget-header">
                <div class="title">
                    <?php echo $title; ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('SERVICE_NAME'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="service[name]" class="form-control"
                           value="<?php echo $service['name']; ?>"/>
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('DESCRIPTION'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea class="form-control" name="service[description]" id="" cols="30"
                              rows="10"><?php echo $service['description']; ?></textarea>
                </div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('SERVICE_URL'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="service[service_url]" class="form-control"
                           value="<?php echo $service['service_url']; ?>">
                </div>
            </div>

            <?php if (isset($service['service_logo'])): ?>
                <div style="" class="row show-grid " id="">
                    <div class="col-sm-offset-4 col-sm-4 col-xs-8">
                        <img width="100" height="100"
                             src="<?= base_url() . 'images/service_logo/' . $service['service_logo'] ?>" alt="logo">
                    </div>
                </div>
            <?php endif; ?>

            <div style="" class="row show-grid " id="">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('SERVICE_LOGO'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="file" name="service_logo">
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="service[status]" class="form-control" id="module_options">
                        <?php
                        $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => array(array('text' => $CI->lang->line('INACTIVE'), 'value' => $this->config->item('STATUS_INACTIVE')), array('text' => $CI->lang->line('ACTIVE'), 'value' => $this->config->item('STATUS_ACTIVE'))), 'drop_down_selected' => $service['status']));
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

