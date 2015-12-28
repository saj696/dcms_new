<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$pdf_link="http://".$_SERVER['HTTP_HOST'].str_replace("/list","/pdf",$_SERVER['REQUEST_URI']);
//echo "<pre>";
//print_r($report);
//echo "</pre>";

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
                <!--                <tr>-->
                <!--                    <th colspan="21" class="text-center">-->
                <!--                        --><?php //echo System_helper::Get_Eng_to_Bng($from_date);?><!-- --><?php //echo $this->lang->line('TO');?><!-- --><?php //echo System_helper::Get_Eng_to_Bng($to_date);?>
                <!--                    </th>-->
                <!--                </tr>-->
                <tr>
                    <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                    <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                    <!--                    <th>--><?php //echo $this->lang->line('UPAZILLA_NAME');?><!--</th>-->
                    <!--                    <th>--><?php //echo $this->lang->line('UNION_NAME');?><!--</th>-->
                    <th><?php echo $this->lang->line('TOTAL_UDC');?></th>
                    <th><?php echo $this->lang->line('NUMBER_OF_ENTREPRENEUR');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UPLOAD_REPORT');?></th>
                    <th><?php echo $this->lang->line('TOTAL_INCOME');?></th>
                    <th><?php echo $this->lang->line('TOTAL_SERVICE_HOLDER');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UPLOAD_REPORT_PERCENTAGE');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UDC_INCOME_PERCENTAGE');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UDC_SERVICE_HOLDER_PERCENTAGE');?></th>
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
                    $total_udc=0;
                    $total_entrepreneur=0;
                    $total_report_upload=0;
                    $total_income=0;
                    $total_service_holder=0;

                    $total_report_upload_percentage=0;
                    $total_income_percentage=0;
                    $total_service_holder_percentage=0;

                    $grand_total_udc=0;
                    $grand_total_entrepreneur=0;
                    $grand_total_report_upload=0;
                    $grand_total_income=0;
                    $grand_total_service_holder=0;

                    $grand_total_report_upload_percentage=0;
                    $grand_total_income_percentage=0;
                    $grand_total_service_holder_percentage=0;

                    foreach($report as $division)
                    {
                        foreach($division['zilla'] as $zilla)
                        {

                            $total_udc=$zilla['total_udc']?$zilla['total_udc']:0;
                            $total_entrepreneur=$zilla['total_entrepreneur']?$zilla['total_entrepreneur']:0;
                            $total_report_upload=$zilla['total_report_upload']?$zilla['total_report_upload']:0;
                            $total_income=$zilla['total_income']?$zilla['total_income']:0;
                            $total_service_holder=$zilla['total_service_holder']?$zilla['total_service_holder']:0;

                            if(!empty($total_udc) && !empty($total_report_upload))
                            {
                                $total_report_upload_percentage=($total_report_upload/$total_udc);
                            }
                            else
                            {
                                $total_report_upload_percentage=0;
                            }

                            if(!empty($total_udc) && !empty($total_income))
                            {
                                $total_income_percentage=($total_income/$total_udc);
                            }
                            else
                            {
                                $total_income_percentage=0;
                            }

                            if(!empty($total_udc) && !empty($total_service_holder))
                            {
                                $total_service_holder_percentage=($total_service_holder/$total_udc);
                            }
                            else
                            {
                                $total_service_holder_percentage=0;
                            }

                            $grand_total_udc+=$total_udc;
                            $grand_total_entrepreneur+=$total_entrepreneur;
                            $grand_total_report_upload+=$total_report_upload;
                            $grand_total_income+=$total_income;
                            $grand_total_service_holder+=$total_service_holder;

                            $grand_total_report_upload_percentage+=$total_report_upload_percentage;
                            $grand_total_income_percentage+=$total_income_percentage;
                            $grand_total_service_holder_percentage+=$total_service_holder_percentage;
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


                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_udc,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_entrepreneur,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_report_upload,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_income,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_service_holder,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_report_upload_percentage,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_income_percentage,2));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_service_holder_percentage,2));?></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    <th colspan="2" style="text-align: right"><?php echo $this->lang->line('TOTAL');?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_udc,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_entrepreneur,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_report_upload,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_income,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_service_holder,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_report_upload_percentage,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_income_percentage,2));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_service_holder_percentage,2));?></th>
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