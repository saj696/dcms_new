<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 12/6/15
 * Time: 5:50 PM
 */
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
            <td style="width: 25px; text-align: center"><input type="checkbox" name="sub_group[]" value="<?php echo $sub_group['id']?>" /></td>
            <td><label class="control-label"><?php echo $sub_group['name'];?></label></td>
        </tr>
    <?php
    }
    ?>
    </table>
</div>