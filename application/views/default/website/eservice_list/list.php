<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
    $CI=& get_instance();

//echo "<pre>";
//print_r($services);
//echo "</pre>";

?>
<div id="system_content" class="system_content_margin">

    <div class="clearfix"></div>
    <input type="hidden" name="id" value="<?php if(isset($ServiceInfo['service_id'])){echo $ServiceInfo['service_id'];}else{echo 0;}?>"/>
        <input type="hidden" name="system_save_new_status"  id="system_save_new_status" value="0"/>
        <div class="row widget">
            <div class="widget-header">
                <div class="title">
                    <?php echo $title; ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div style="" class="row show-grid " id="">
                <div class="col-lg-12">
                    <?php
                    if(empty($services))
                    {
                        ?>
                        <label class="control-label pull-right"><span style="color:#FF0000"><?php echo $CI->lang->line('DATA_NOT_FOUND'); ?></span></label>
                    <?php
                    }
                    else
                    {
                        ?>
                        <table class="table table-responsive table-bordered  ">
                            <thead>
                            <tr>
                                <th width="10%"><?php echo $this->lang->line('SERIAL');?></th>
                                <th width="60%"><?php echo $this->lang->line('SERVICE_NAME');?></th>
                                <th width="30%"><?php echo $this->lang->line('SERVICE_MAX_AMOUNT');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //$total_service=count($services);
                            //$services_column=$total_service/3;
                            $sl=0;
                            foreach($services as $service)
                            {
                                ++$sl;
                                ?>
                                <tr>
                                    <td><?php echo System_helper::Get_Eng_to_Bng($sl);?></td>
                                    <td><?php echo $service['service_name'];?></td>
                                    <td><?php echo System_helper::Get_Eng_to_Bng($service['service_amount']);?></td>
                                </tr>
                            <?php
                            }
                            ?>

                            </tbody>
                        </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
