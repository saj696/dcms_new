<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$CI=& get_instance();
?>
<div id="system_action_button_container" class="system_action_button_container">
    <?php
    //$CI->load_view('system_action_buttons');

    ?>
</div>

<style>
    body {
        background: #e9e9e9;
        font-family: 'Roboto', sans-serif;
        text-align: center;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

</style>

<div class="clearfix"></div>
<div id="system_content" class="dashboard-wrapper">
<div class="grid_10" >
<div class="box round first">
    <h2><?php echo $this->lang->line('DIGITAL_CENTER_NAME');?></h2>
    <div class="block ">
        <span class="labelcell"><?php echo $uisc_detail['uisc_name'];?></span>
    </div>
</div>
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('CHAIRMEN_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('NAME');?> </td>
                    <td width="28%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $chairmen_info['chairmen_name'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('MOBILE_NO')?></span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $chairmen_info['chairmen_mobile'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('EMAIL')?></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $chairmen_info['chairmen_email'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('ADDRESS')?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input textarea">
                            <?php echo $chairmen_info['chairmen_address'];?>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

<div class="box round first">
    <h2><?php echo $this->lang->line('SECRETARY_RELATED_INFO');?></h2>
    <div class="block ">
        <table class="signup table" width="100%">
            <tbody>
            <tr>
                <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('NAME');?></td>
                <td width="28%" class="custom fieldcell">
                    <div class="input text">
                        <span class="labelcell"><?php echo $secretary['secretary_name'];?></span>
                    </div>
                </td>
                <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('MOBILE_NO')?></span></td>
                <td width="29%" class="custom fieldcell">
                    <div class="input text">
                        <span class="labelcell"><?php echo $secretary['secretary_mobile'];?></span>
                    </div>
                </td>
            </tr>

            <tr>
                <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('EMAIL')?></span></td>
                <td width="29%" class="custom fieldcell">
                    <div class="input text">
                        <span class="labelcell"><?php echo $secretary['secretary_email'];?></span>
                    </div>
                </td>
                <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('ADDRESS')?> </span></td>
                <td width="29%" class="custom fieldcell">
                    <div class="input textarea">
                        <span class="labelcell"><?php echo $secretary['secretary_address'];?></span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<!--START ENTREPRENEUR INFO-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('ENTREPRENEUR_RELATED_INFO');?></h2>
        <div class="block" id="entrepreneur_list">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('ENTREPRENEUR_TYPE');?> </td>
                    <td  class="custom fieldcella">
                        <?php
                        if($entrepreneur_info['entrepreneur_type']==1)
                        {
                            echo $this->lang->line('ENTREPRENEUR');
                        }
                        elseif($entrepreneur_info['entrepreneur_type']==2)
                        {
                            echo $this->lang->line('NOVICE_ENTREPRENEUR');
                        }
                        else
                        {

                        }
                        ?>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('NAME');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $entrepreneur_info['entrepreneur_name'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('MOTHERS_NAME');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $entrepreneur_info['entrepreneur_mother_name'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('FATHERS_NAME');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $entrepreneur_info['entrepreneur_father_name'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('MOBILE_NO');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $entrepreneur_info['entrepreneur_mobile'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('EMAIL');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input text">
                            <?php echo $entrepreneur_info['entrepreneur_email'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('GENDER');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input select">
                            <?php
                            if($entrepreneur_info['entrepreneur_sex']==$this->config->item('GENDER_MALE'))
                            {
                                echo $this->lang->line('MALE');
                            }
                            elseif($entrepreneur_info['entrepreneur_sex']==$this->config->item('GENDER_FEMALE'))
                            {
                                echo $this->lang->line('FEMALE');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('ADDRESS');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input textarea">
                            <?php echo $entrepreneur_info['entrepreneur_address'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('NID');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input select">
                            <?php echo $entrepreneur_info['entrepreneur_nid'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('BANK_NAME');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input textarea">
                            <?php echo $entrepreneur_info['entrepreneur_bank_name'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('BANK_ACCOUNT_NO');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input select">
                            <?php echo $entrepreneur_info['entrepreneur_bank_account_no'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('BANK_ACCOUNT_HOLDER_NAME');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input textarea">
                            <?php echo $entrepreneur_info['entrepreneur_bank_holder_name'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('BLOG_MEMBER');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input select">
                            <?php
                            if($entrepreneur_info['entrepreneur_blog_member']==$this->config->item('STATUS_ACTIVE'))
                            {
                                echo $this->lang->line('YES');
                            }
                            elseif($entrepreneur_info['entrepreneur_blog_member']==$this->config->item('STATUS_INACTIVE'))
                            {
                                echo $this->lang->line('NO');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('FACE_BOOK_GROUP_MEMBER');?> </span></td>
                    <td width="29%" class="custom fieldcell">
                        <div class="input textarea">
                            <?php
                            if($entrepreneur_info['entrepreneur_fb_group_member']==$this->config->item('STATUS_ACTIVE'))
                            {
                                echo $this->lang->line('YES');
                            }
                            elseif($entrepreneur_info['entrepreneur_fb_group_member']==$this->config->item('STATUS_INACTIVE'))
                            {
                                echo $this->lang->line('NO');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell">
                        <?php echo $this->lang->line('PROFILE_PIC');?>
                    </td>
                    <td  class="custom fieldcell">
                        <div class="input select">
                            <div id="imtext" style="width: 150px; height: 150px;">
                                <?php
                                if(!empty($user_info['picture_name']))
                                {
                                    ?>
                                    <img src="<?php echo base_url().'images/entrepreneur/'.$user_info['picture_name']; ?>" style="width: 130px; height: 130px;" id="imtext" />
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <img src="<?php echo base_url()?>images/profile.png" style="width: 130px; height: 130px;" id="imtext" />
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<!--END ENTREPRENEUR INFO-->
    <!-- START EDUCATION_RELATED_INFO-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('EDUCATION_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('LATEST_ACADEMIC_INFO');?></td>
                    <td>
                        <div class="input select">
                            <?php
                            foreach($this->config->item('latest_academic_info') as $key=>$academic)
                            {
                                if($key==$education_info['latest_education'])
                                {
                                    ?>
                                    <?php echo $academic;?>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('PASSING_YEAR');?></td>
                    <td>
                        <div class="input select">
                            <?php
                            $current_year=date('Y', time())+1;
                            for($i=1970; $i<$current_year; $i++)
                            {
                                if($i==$education_info['passing_year'])
                                {
                                    ?>
                                    <?php echo $i;?>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END EDUCATION_RELATED_INFO-->

    <!-- START ENTREPRENEUR_TRAINING_RELATED_INFO-->

    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('ENTREPRENEUR_TRAINING_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" id="training_info" width="100%">
                <thead>
                <tr>
                    <th class="labelcell"><?php echo $this->lang->line('COURSE_NAME');?></th>
                    <th class="labelcell"><?php echo $this->lang->line('INSTITUTION_NAME');?></th>
                    <th class="labelcell"><?php echo $this->lang->line('TIME_SPAN');?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0; $i<sizeof($training_info); $i++)
                {
                    ?>
                    <tr id="supliments_1">
                        <td class="custom fieldcell">
                            <div class="input select">
                                <?php
                                foreach($this->config->item('training_course') as $course_id=>$training)
                                {
                                    if($course_id==$training_info[$i]['course_name'])
                                    {
                                        ?>
                                        <?php echo $training;?>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </td>

                        <td class="custom fieldcell">
                            <div class="input text">
                                <?php echo $training_info[$i]['institute_name'];?>
                            </div>
                        </td>
                        <td class="custom fieldcell">
                            <div class="input text">
                                <?php echo $training_info[$i]['timespan'];?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END ENTREPRENEUR_TRAINING_RELATED_INFO-->
    <!-- START INVESTMENT_RELATED_INFO-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('INVESTMENT_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('SELF_INVESTMENT');?></span></td>
                    <td>
                        <div class="input select">
                            <?php echo $investment_info['self_investment'];?>
                        </div>
                    </td>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('INVEST_DEBT');?> </td>
                    <td>
                        <div class="input select">
                            <?php echo $investment_info['invest_debt'];?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('INVESTED_MONEY_AMOUNT');?> </td>
                    <td>
                        <div class="input select">
                            <?php echo $investment_info['invested_money'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('INVEST_SECTOR');?></span></td>
                    <td width="29%" class="custom fieldcell">
                        <?php echo $investment_info['invest_sector'];?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END INVESTMENT_RELATED_INFO-->
    <!-- START CENTER_LOCATION_RELATED_INFO-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('CENTER_LOCATION_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('TYPE');?></td>
                    <td>
                        <div class="input select">
                            <?php
                            foreach($this->config->item('center_location_info') as $key=>$location)
                            {
                                if($key==$location_info['center_type'])
                                {
                                    ?>
                                    <?php echo $location;?>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END CENTER_LOCATION_RELATED_INFO-->
    <!-- START EQUIPMENT-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('EQUIPMENT');?></h2>
        <div class="block ">
            <table class="signup table" id="resource_info" width="100%">
                <thead>
                <tr>
                    <th class="labelcell"><?php echo $this->lang->line('NAME');?></th>
                    <th class="labelcell"><?php echo $this->lang->line('DETAIL');?></th>
                    <th class="labelcell"><?php echo $this->lang->line('NUMBER');?></th>
                    <th class="labelcell"><?php echo $this->lang->line('STATUS');?></th>
                </tr>
                </thead>
                <tbody>
                <?php

                $sl=1;
                for($i=0; $i<sizeof($resources_info); $i++)
                {
                    ?>
                    <tr id="supliments_1">
                        <td  class="custom fieldcell">
                            <div class="input select">
                                <?php
                                foreach($resources as $equipment)
                                {
                                    echo $equipment['res_name'];
                                }
                                ?>
                            </div>
                        </td>

                        <td  class="custom fieldcell">
                            <?php echo $resources_info[$i]['res_detail'];?>
                        </td>
                        <td  class="custom fieldcell">
                            <div class="input text">
                                <?php echo $resources_info[$i]['quantity'];?>
                            </div>
                        </td>
                        <td class="custom col2">
                            <?php
                            foreach($this->config->item('equipment_status') as $val=>$equipment_status)
                            {
                                if($val==$resources_info[$i]['status'])
                                {
                                    ?>
                                    <?php echo $equipment_status;?>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    ++$sl;
                }

                ?>

                </tbody>
            </table>

        </div>
    </div>
    <!-- END EQUIPMENT-->
    <!-- START DEVICE_RELATED_INFO-->
    <div class="box round first">
        <h2><?php echo $this->lang->line('DEVICE_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('CONNECTION_TYPE');?> </td>
                    <td>
                        <div class="input select">
                            <?php echo $device_info['connection_type'];?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('MODEM');?></span></td>
                    <td>
                        <div class="input select">
                            <?php
                            foreach($this->config->item('modem') as $val=>$modem)
                            {
                                if($val==$device_info['modem'])
                                {
                                    ?>
                                    <?php echo $modem;?>
                                    <?php
                                }
                                else
                                {
                                    ?>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('IP_ADDRESS');?></span></td>
                    <td width="29%" class="custom fieldcell">
                        <?php echo $device_info['ip_address'];?>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
    <!-- END DEVICE_RELATED_INFO-->
    <!-- START ELECTRICITY_RELATED_INFO-->
    <div class="box round first">
        <h2 class="text-center"><?php echo $this->lang->line('ELECTRICITY_RELATED_INFO');?></h2>
        <div class="block ">
            <table class="signup table" width="100%">
                <tbody>
                <tr>
                    <td class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('ELECTRICITY');?></td>
                    <td>
                        <div class="input select">
                            <?php
                            if($electricity_info['electricity']==$this->config->item('STATUS_ACTIVE'))
                            {
                                echo $this->lang->line('YES');
                            }
                            elseif($electricity_info['electricity']==$this->config->item('STATUS_INACTIVE'))
                            {
                                echo $this->lang->line('NO');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('SOLAR');?></span></td>
                    <td>
                        <div class="input select">
                            <?php
                            if($electricity_info['solar']==$this->config->item('STATUS_ACTIVE'))
                            {
                                echo $this->lang->line('YES');
                            }
                            elseif($electricity_info['solar']==$this->config->item('STATUS_INACTIVE'))
                            {
                                echo $this->lang->line('NO');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="20%" class="custom smalllabelcell"><span class="labelcell"><?php echo $this->lang->line('IPS');?></span></td>
                    <td>
                        <div class="input select">
                            <?php
                            if($electricity_info['ips']==$this->config->item('STATUS_ACTIVE'))
                            {
                                echo $this->lang->line('YES');
                            }
                            elseif($electricity_info['ips']==$this->config->item('STATUS_INACTIVE'))
                            {
                                echo $this->lang->line('NO');
                            }
                            else
                            {

                            }
                            ?>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END ELECTRICITY_RELATED_INFO-->
</div>

<div class="clear">
</div>
<div style="line-height:15px;">&nbsp;</div>
</div>
</div>
