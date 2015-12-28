<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$CI =& get_instance();
$user=User_helper::get_user();
$modules=User_helper::get_reports_task_module();
//echo "<pre>";
//print_r($modules);
//echo "</pre>";
?>
<div>
    <?php
    $user_group_id = $user->user_group_id;
    if($user_group_id == $CI->config->item('DIVISION_GROUP_ID'))
    {
        $title = "বিভাগীয় প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('DISTRICT_GROUP_ID'))
    {
        $title = "জেলার প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('UPAZILLA_GROUP_ID'))
    {
        $title = "উপজেলার প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('UNION_GROUP_ID'))
    {
        $title = "ইউনিয়নের প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('CITY_CORPORATION_GROUP_ID'))
    {
        $title = "সিটি কর্পোরেশনের প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('CITY_CORPORATION_WORD_GROUP_ID'))
    {
        $title = "সিটি কর্পোরেশন ওয়ার্ডের প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('MUNICIPAL_GROUP_ID'))
    {
        $title = "পৌরসভার প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('MUNICIPAL_WORD_GROUP_ID'))
    {
        $title = "পৌরসভা ওয়ার্ডের প্রতিবেদন";
    }
    elseif($user_group_id == $CI->config->item('UISC_GROUP_ID'))
    {
        $title = "ইউআইএসসি এর প্রতিবেদন";
    }
    else
    {
        $title = "সারাদেশের প্রতিবেদন";
    }
    ?>
    <div class="home_head_custom" style=""><?php echo $title;?></div>
    <div class="home_txt_div_custom" style="">
        <div>
            <ul>
                <?php
                foreach($modules as $module)
                {
                    ?>
                    <li class="st_custom " style="text-align:center;color:#800081;font-weight:bold;font-family:NiKoshBan,Nikosh,Arial;">
                        <?php echo $module['module_name'] ;?>
                    </li>
                <?php
                    foreach($module['tasks'] as $task)
                    {
                        ?>
                            <li class="st_custom">
                                <a class="a_active <?php echo $task['task_icon']; ?>" href="<?php echo $CI->get_encoded_url($task['controller']); ?>">
                                    <span>
                                        <?php echo $task['task_name'];?>
                                    </span>
                                </a>
                            </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <br />
</div>
