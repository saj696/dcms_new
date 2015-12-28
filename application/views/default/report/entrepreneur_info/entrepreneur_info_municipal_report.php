<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link="http://".$_SERVER['HTTP_HOST'].str_replace("/list","/pdf",$_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";
//die();
?>
<html lang="en">
<head>
    <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/templates/default/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="main_container">
        <div class="row show-grid hidden-print">
            <a class="btn btn-primary btn-rect pull-right" href="<?php echo $pdf_link;?>"><?php echo $this->lang->line("BUTTON_PDF"); ?></a>
            <a class="btn btn-primary btn-rect pull-right" style="margin-right: 10px;" href="javascript:window.print();"><?php echo $this->lang->line("BUTTON_PRINT"); ?></a>
            <div class="clearfix"></div>
            <span class="pull-right"><?php echo $this->lang->line('REPORT_CURRENT_DATE_VIEW');?></span>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-12 text-center">
                <h4><?php echo $this->lang->line('REPORT_HEADER_TITLE');?></h4>
                <h5><?php echo $title;?></h5>
            </div>


            <table class="table table-responsive table-bordered">
            <thead>
            <!--            <tr>-->
            <!--                <th colspan="21" class="text-center">-->
            <!--                    --><?php //echo System_helper::Get_Eng_to_Bng($from_date);?><!-- --><?php //echo $this->lang->line('TO');?><!-- --><?php //echo System_helper::Get_Eng_to_Bng($to_date);?>
            <!--                </th>-->
            <!--            </tr>-->
            <tr>
                <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                <th><?php echo $this->lang->line('MUNICIPAL_NAME');?></th>
                <th><?php echo $this->lang->line('MUNICIPAL_WARD_NAME');?></th>
                <th><?php echo $this->lang->line('UISC_NAME');?></th>
                <th><?php echo $this->lang->line('ENTREPRENEUR_NAME');?></th>
                <th><?php echo $this->lang->line('ENTREPRENEUR_TYPE');?></th>
                <th><?php echo $this->lang->line('GENDER');?></th>
                <th><?php echo $this->lang->line('EDUCATION');?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(empty($report))
            {
                ?>
                <tr>
                    <td colspan="21" style="color: red; text-align: center;"><?php echo $this->lang->line('DATA_NOT_FOUND');?></td>
                </tr>
            <?php
            }
            else
            {
                $division_name='';
                $zilla_name='';
                $municipal_name='';
                $municipal_ward_name='';
                $uisc_name='';
                $latest_education_config=$this->config->item('latest_academic_info');
                foreach($report as $division)
                {
                    foreach($division['zilla'] as $zilla)
                    {
                        foreach($zilla['municipal'] as $municipal)
                        {
                            foreach($municipal['municipal_ward'] as $municipal_ward)
                            {
                                foreach($municipal_ward['uisc'] as $uisc)
                                {
                                    for($i=0; $i<sizeof($uisc['entrepreneur_info']); $i++)
                                    {
                                        if($uisc['entrepreneur_info'][$i]['entrepreneur_type']==1)
                                        {
                                            $entrepreneur_type=$this->lang->line('ENTREPRENEUR');
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['entrepreneur_type']==2)
                                        {
                                            $entrepreneur_type=$this->lang->line('NOVICE_ENTREPRENEUR');
                                        }
                                        else
                                        {
                                            $entrepreneur_type='';
                                        }

                                        if($uisc['entrepreneur_info'][$i]['entrepreneur_sex']==$this->config->item('GENDER_MALE'))
                                        {
                                            $entrepreneur_sex=$this->lang->line('MALE');
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['entrepreneur_sex']==$this->config->item('GENDER_FEMALE'))
                                        {
                                            $entrepreneur_sex=$this->lang->line('FEMALE');
                                        }
                                        else
                                        {
                                            $entrepreneur_sex='';
                                        }
                                        //$entrepreneur_sex=$uisc['entrepreneur_info'][$i]['entrepreneur_sex'];
                                        if($uisc['entrepreneur_info'][$i]['latest_education']==1)
                                        {
                                            $latest_education=$latest_education_config[1];
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['latest_education']==2)
                                        {
                                            $latest_education=$latest_education_config[2];
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['latest_education']==3)
                                        {
                                            $latest_education=$latest_education_config[3];
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['latest_education']==4)
                                        {
                                            $latest_education=$latest_education_config[4];
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['latest_education']==5)
                                        {
                                            $latest_education=$latest_education_config[5];
                                        }
                                        elseif($uisc['entrepreneur_info'][$i]['latest_education']==6)
                                        {
                                            $latest_education=$latest_education_config[6];
                                        }
                                        else
                                        {
                                            $latest_education='';
                                        }

                                        ?>
                                        <tr style="background: #cccccc">
                                            <td>
                                                <?php
                                                if ($division_name == '')
                                                {
                                                    echo $division['division_name'];
                                                    $division_name = $division['division_name'];
                                                    //$currentDate = $preDate;
                                                }
                                                else if ($division_name == $division['division_name'])
                                                {
                                                    //exit;
                                                    echo "&nbsp;";
                                                }
                                                else
                                                {
                                                    echo $division['division_name'];
                                                    $division_name = $division['division_name'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($zilla_name == '')
                                                {
                                                    echo $zilla['zilla_name'];
                                                    $zilla_name = $zilla['zilla_name'];
                                                    //$currentDate = $preDate;
                                                }
                                                else if ($zilla_name == $zilla['zilla_name'])
                                                {
                                                    //exit;
                                                    echo "&nbsp;";
                                                }
                                                else
                                                {
                                                    echo $zilla['zilla_name'];
                                                    $zilla_name = $zilla['zilla_name'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($municipal_name == '')
                                                {
                                                    echo $municipal['municipal_name'];
                                                    $municipal_name = $municipal['municipal_name'];
                                                    //$currentDate = $preDate;
                                                }
                                                else if ($municipal_name == $municipal['municipal_name'])
                                                {
                                                    //exit;
                                                    echo "&nbsp;";
                                                }
                                                else
                                                {
                                                    echo $municipal['municipal_name'];
                                                    $municipal_name = $municipal['municipal_name'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($municipal_ward_name == '')
                                                {
                                                    echo $municipal_ward['municipal_ward_name'];
                                                    $municipal_ward_name = $municipal_ward['municipal_ward_name'];
                                                    //$currentDate = $preDate;
                                                }
                                                else if ($municipal_ward_name == $municipal_ward['municipal_ward_name'])
                                                {
                                                    //exit;
                                                    echo "&nbsp;";
                                                }
                                                else
                                                {
                                                    echo $municipal_ward['municipal_ward_name'];
                                                    $municipal_ward_name = $municipal_ward['municipal_ward_name'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($uisc_name == '')
                                                {
                                                    echo $uisc['uisc_name'];
                                                    $uisc_name = $uisc['uisc_name'];
                                                    //$currentDate = $preDate;
                                                }
                                                else if ($uisc_name == $uisc['uisc_name'])
                                                {
                                                    //exit;
                                                    echo "&nbsp;";
                                                }
                                                else
                                                {
                                                    echo $uisc['uisc_name'];
                                                    $uisc_name = $uisc['uisc_name'];
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $uisc['entrepreneur_info'][$i]['entrepreneur_name'];?></td>
                                            <td><?php echo $entrepreneur_type;?></td>
                                            <td><?php echo $entrepreneur_sex;?></td>
                                            <td><?php echo $latest_education;?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</body>
</html>