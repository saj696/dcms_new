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
                <h5>
                    <?php echo $title;?> -
                    (
                    <?php
                    $service_type=$this->config->item('service_type');
                    if($report_status=="")
                    {
                        echo $this->lang->line('ALL');
                    }
                    else if($report_status==1)
                    {
                        echo $service_type[1];
                    }
                    else if($report_status==2)
                    {
                        echo $service_type[2];
                    }
                    else if($report_status==3)
                    {
                        echo $service_type[3];
                    }
                    else
                    {

                    }
                    ?>
                    )
                </h5>
            </div>


            <table class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th colspan="21" class="text-center">
                    <?php echo System_helper::Get_Eng_to_Bng($from_date);?> <?php echo $this->lang->line('TO');?> <?php echo System_helper::Get_Eng_to_Bng($to_date);?>
                </th>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                <th><?php echo $this->lang->line('UPAZILLA_NAME');?></th>
                <th><?php echo $this->lang->line('UNION_NAME');?></th>
                <th><?php echo $this->lang->line('UISC_NAME');?></th>
                <?php
                if($report_status==1)
                {
                ?>
                    <th><?php echo $this->lang->line('NUMBER_OF_SERVICE_HOLDER');?></th>
                    <th><?php echo $this->lang->line('MONTHLY_INCOME');?></th>
                    <th><?php echo $this->lang->line('NUMBER_OF_SERVICE');?></th>
                <?php
                }
                else if($report_status==2)
                {
                    ?>
                    <th><?php echo $this->lang->line('NUMBER_OF_SERVICE_HOLDER');?></th>
                <?php
                }
                else if($report_status==3)
                {
                    ?>
                    <th><?php echo $this->lang->line('MONTHLY_INCOME');?></th>
                <?php
                }
                else if($report_status==4)
                {
                    ?>
                    <th><?php echo $this->lang->line('NUMBER_OF_SERVICE');?></th>
                <?php
                }
                else
                {
                    ?>

                <?php
                }
                ?>

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
                $upazilla_name='';
                $union_name='';
                $uisc_name='';
                $grand_total_monthly_income=0;
                $grand_total_service_holder=0;
                $grand_total_service=0;
                foreach($report as $division)
                {
                    foreach($division['zilla'] as $zilla)
                    {
                        $upazilla_total_monthly_income=0;
                        $upazilla_total_service_holder=0;
                        $upazilla_total_service=0;
                        foreach($zilla['upazilla'] as $upazilla)
                        {
                            foreach($upazilla['union'] as $union)
                            {
                                foreach($union['uisc'] as $uisc)
                                {
                                    $total_monthly_income = $uisc['total_monthly_income'];
                                    $total_service_holder = $uisc['total_service_holder'];
                                    $total_service = $uisc['total_service'];

                                    $upazilla_total_monthly_income += $total_monthly_income;
                                    $upazilla_total_service_holder += $total_service_holder;
                                    $upazilla_total_service += $total_service;

                                    $grand_total_monthly_income += $total_monthly_income;
                                    $grand_total_service_holder += $total_service_holder;
                                    $grand_total_service += $total_service;

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
                                            if ($upazilla_name == '')
                                            {
                                                echo $upazilla['upazilla_name'];
                                                $upazilla_name = $upazilla['upazilla_name'];
                                                //$currentDate = $preDate;
                                            }
                                            else if ($upazilla_name == $upazilla['upazilla_name'])
                                            {
                                                //exit;
                                                echo "&nbsp;";
                                            }
                                            else
                                            {
                                                echo $upazilla['upazilla_name'];
                                                $upazilla_name = $upazilla['upazilla_name'];
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($union_name == '')
                                            {
                                                echo $union['union_name'];
                                                $union_name = $union['union_name'];
                                                //$currentDate = $preDate;
                                            }
                                            else if ($union_name == $union['union_name'])
                                            {
                                                //exit;
                                                echo "&nbsp;";
                                            }
                                            else
                                            {
                                                echo $union['union_name'];
                                                $union_name = $union['union_name'];
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
                                        <?php
                                        if($report_status==1)
                                        {
                                            ?>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_service_holder);?></td>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_monthly_income);?></td>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_service);?></td>
                                        <?php
                                        }
                                        else if($report_status==2)
                                        {
                                            ?>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_service_holder);?></td>
                                        <?php
                                        }
                                        else if($report_status==3)
                                        {
                                            ?>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_monthly_income);?></td>
                                        <?php
                                        }
                                        else if($report_status==4)
                                        {
                                            ?>
                                            <td><?php echo System_helper::Get_Eng_to_Bng($total_service);?></td>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>

                                        <?php
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                            <tr>
                                <th colspan="5" style="text-align: right"><?php echo $this->lang->line('UPAZILLA');?> <?php echo $this->lang->line('TOTAL');?></th>
                                <?php
                                if($report_status==1)
                                {
                                    ?>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_service_holder);?></th>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_monthly_income);?></th>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_service);?></th>
                                <?php
                                }
                                else if($report_status==2)
                                {
                                    ?>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_service_holder);?></th>
                                <?php
                                }
                                else if($report_status==3)
                                {
                                    ?>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_monthly_income);?></th>
                                <?php
                                }
                                else if($report_status==4)
                                {
                                    ?>
                                    <th><?php echo System_helper::Get_Eng_to_Bng($upazilla_total_service);?></th>
                                <?php
                                }
                                else
                                {
                                    ?>

                                <?php
                                }
                                ?>

                            </tr>
                        <?php
                        }
                    }
                }
                ?>
                <tr>
                    <th colspan="5" style="text-align: right"><?php echo $this->lang->line('TOTAL');?></th>
                    <?php
                    if($report_status==1)
                    {
                        ?>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_service_holder);?></th>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_monthly_income);?></th>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_service);?></th>
                    <?php
                    }
                    else if($report_status==2)
                    {
                        ?>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_service_holder);?></th>
                    <?php
                    }
                    else if($report_status==3)
                    {
                        ?>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_monthly_income);?></th>
                    <?php
                    }
                    else if($report_status==4)
                    {
                        ?>
                        <th><?php echo System_helper::Get_Eng_to_Bng($grand_total_service);?></th>
                    <?php
                    }
                    else
                    {
                        ?>

                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
</body>
</html>