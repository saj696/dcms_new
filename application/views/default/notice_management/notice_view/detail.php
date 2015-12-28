<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
//echo "<pre>";
//print_r($NoticeInfo);
//echo "</pre>";
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
    <div class="row widget">
        <div class="widget-header">
            <div class="title">
                <?php echo $title; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="row show-grid " >
            <div class="col-sm-12 col-xs-12">
                <table class="table table-responsive table-bordered" >
                    <thead>
                    <tr>
                        <th width="15%"><?php echo $CI->lang->line('NOTICE_TITLE'); ?></th>
                        <th><?php echo $NoticeInfo['notice_title'];?></th>
                    </tr>
                    <tr>
                        <th><?php echo $CI->lang->line('NOTICE_DETAILS'); ?></th>
                        <th><?php echo $NoticeInfo['notice_details'];?></th>
                    </tr>
                    <tr>
                        <th><?php echo $CI->lang->line('DOWNLOAD'); ?></th>
                        <th>
                            <?php
                            if(!empty($NoticeInfo['upload_file']))
                            {
                                ?>
                                <?php echo $NoticeInfo['upload_file'];?>
                                <a href="<?php echo base_url().'images/notice/'.$NoticeInfo['upload_file']?>" target="_blank" class="external">
                                    <span style='color:red;'><?php echo $CI->lang->line('CLICK_HERE_TO_DOWNLOAD');?></span>
                                </a>
                            <?php
                            }
                            ?>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

