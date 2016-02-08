<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
//echo "<pre>";
//print_r($notice_viewers);
//echo "</pre>";
?>
<div id="system_content" class="system_content_margin">
    <div id="system_action_button_container" class="system_action_button_container">
        <?php
        $CI->load_view('system_action_buttons');
        ?>
    </div>

    <?php
    //print_r($MediaInfo);
    ?>

    <div class="clearfix"></div>
    <form id="system_save_form" action="<?php echo $CI->get_encoded_url('media/media_upload/index/save'); ?>"
          method="post" class="signup form_valid" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php if (isset($MediaInfo['id'])) {
            echo $MediaInfo['id'];
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

            <div style="" class="row show-grid ">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MEDIA_TYPE'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="media[media_type]" class="selectbox-1 form-control validate[required] media_type">
                        <option value=""><?php echo $CI->lang->line('SELECT'); ?></option>
                        <?php
                        $types = $CI->config->item('media_type');
                        foreach ($types as $val => $name) {
                            ?>
                            <option value="<?php echo $val; ?>" <?php if ($val == $MediaInfo['media_type']) {
                                echo 'selected';
                            } ?>><?php echo $name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MEDIA_TITLE'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="media[media_title]" class="form-control validate[required]"
                           value="<?php echo $MediaInfo['media_title']; ?>"/>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('MEDIA_DETAILS'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <textarea name="media[media_detail]"
                              class="form-control "><?php echo $MediaInfo['media_detail']; ?></textarea>
                </div>
            </div>

            <div style="display: <?php if ($MediaInfo['media_type'] == 2) {
                echo 'show';
            } else {
                echo 'none';
            } ?>;" class="row show-grid link">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('VIDEO_LINK'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="media[video_link]" class="form-control validate[required]"
                           value="<?php echo $MediaInfo['video_link']; ?>"/>
                </div>
            </div>

            <div style="display: <?php if ($MediaInfo['media_type'] == 3) {
                echo 'show';
            } else {
                echo 'none';
            } ?>;" class="row show-grid print_year">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('PRINT_YEAR'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="media[print_year]" class="selectbox-1 form-control validate[required]">
                        <option value=""><?php echo $CI->lang->line('SELECT'); ?></option>
                        <?php
                        $types = $CI->config->item('media_type');
                        $current_year = date('Y');
                        $last_year = $current_year - 10;
                        for ($i = $current_year; $i > $last_year; $i--) {
                            ?>
                            <option value="<?php echo $i; ?>" <?php if ($i == $MediaInfo['print_year']) {
                                echo 'selected';
                            } ?>><?php echo $i; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div style="display: <?php if ($MediaInfo['media_type'] == 3 || $MediaInfo['media_type'] == 4) {
                echo 'show';
            } else {
                echo 'none';
            } ?>;" class="row show-grid external_link">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('EXTERNAL_LINK'); ?></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <input type="text" name="media[external_link]" class="form-control validate[required]"
                           value="<?php echo $MediaInfo['external_link']; ?>"/>
                </div>
                <div><label class="control-label"><?php echo $CI->lang->line('OR'); ?></label></div>
            </div>

            <div class="row show-grid file_up">
                <div class="col-xs-4">

                    <label class="control-label pull-right file_upload_label">
                        <?php
                        if ($MediaInfo['media_type'] == 2) {
                            echo $CI->lang->line('FILE_UPLOAD (VIDEO THUMBNAIL IMAGE)');
                        }else
                        {
                            echo $CI->lang->line('FILE_UPLOAD');
                        }

                        ?>
                        <span style="color:#FF0000">*</span>
                    </label>

                    <label  class="control-label pull-right video_label" style="display: none" ><?php echo $CI->lang->line('FILE_UPLOAD (VIDEO THUMBNAIL IMAGE)'); ?></label>
                </div>
                <div class="col-xs-2">

                    <input type="file" name="file_name" data-preview-container="#resume_container"
                           data-preview-height="50" class="validate[required]" value=""/>
                </div>
                <div class="col-xs-2" id="resume_container">
                    <?php
                    if ($MediaInfo['file_name']) {
                        $dir_config = $CI->config->item('dcms_upload');
                        if ($MediaInfo['media_type'] == 1) {
                            $directory = $dir_config['media_photo'];
                        } elseif ($MediaInfo['media_type'] == 2) {
                            $directory = $dir_config['media_photo'];
                        } elseif ($MediaInfo['media_type'] == 3) {
                            $directory = $dir_config['media_print'];
                        } elseif ($MediaInfo['media_type'] == 4) {
                            $directory = $dir_config['media_publication'];
                        }

                        $file_picture = FCPATH . $directory . '/' . $MediaInfo['file_name'];

                        if (file_exists($file_picture) && !empty($MediaInfo['file_name'])) {
                            ?>
                            <img src="<?php echo base_url() . $directory . '/' . $MediaInfo['file_name']; ?>"
                                 height="300" width="300">
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo base_url() . 'images/no_image.jpg'; ?>" height="50">
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div style="" class="row show-grid">
                <div class="col-xs-4">
                    <label class="control-label pull-right"><?php echo $CI->lang->line('STATUS'); ?><span
                            style="color:#FF0000">*</span></label>
                </div>
                <div class="col-sm-4 col-xs-8">
                    <select name="media[status]" class="form-control selectbox-1 validate[required]"
                            id="module_options">
                        <?php
                        $CI->load_view('dropdown', array('drop_down_default_option' => false, 'drop_down_options' => array(array('text' => $CI->lang->line('PUBLISHED'), 'value' => $this->config->item('STATUS_ACTIVE')), array('text' => $CI->lang->line('UN_PUBLISHED'), 'value' => $this->config->item('STATUS_INACTIVE'))), 'drop_down_selected' => $MediaInfo['status']));
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        //$(".form_valid").validationEngine();
        $(document).on("change", ".media_type", function () {
            if ($(this).val() == 2) {
                $(".link").show();
                $(".file_upload_label").hide();
                $(".video_label").show();

            }
            else {
                $(".link").hide();
            }

            if ($(this).val() == 3) {
                $(".print_year").show();
            }
            else {
                $(".print_year").hide();
            }

            if ($(this).val() == 3 || $(this).val() == 4) {
                //$(".file_up").hide();
                $(".external_link").show();
            }
            else {
                //$(".file_up").show();
                $(".external_link").hide();
            }
        });

    });
</script>
