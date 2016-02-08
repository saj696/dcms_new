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

            <p style="margin:15px 0px;text-align: center"><?= System_helper::Get_Eng_to_Bng($from_date).' '.$this->lang->line('FROM_DATE') ?> &nbsp;&nbsp;<?= System_helper::Get_Eng_to_Bng($to_date).' '.$this->lang->line('TO_DATE') ?></p>
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
                    <th><?php echo $this->lang->line('TOTAL_PDC');?></th>
                    <th><?php echo $this->lang->line('NUMBER_OF_ENTREPRENEUR');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UPLOAD_REPORT');?></th>
                    <th><?php echo $this->lang->line('TOTAL_INCOME');?></th>
                    <th><?php echo $this->lang->line('TOTAL_SERVICE_HOLDER');?></th>
                    <th><?php echo $this->lang->line('TOTAL_UPLOAD_REPORT_PERCENTAGE');?></th>
                    <th><?php echo $this->lang->line('TOTAL_PDC_INCOME_PERCENTAGE');?></th>
                    <th><?php echo $this->lang->line('TOTAL_PDC_SERVICE_HOLDER_PERCENTAGE');?></th>
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
                    $pdc=[
                        '01'=>'3',
                        '03'=>'2',
                        '04'=>'4',
                        '06'=>'6',
                        '09'=>'5',
                        '10'=>'12',
                        '12'=>'4',
                        '13'=>'7',
                        '15'=>'13',
                        '18'=>'4',
                        '19'=>'4',
                        '22'=>'4',
                        '26'=>'3',
                        '27'=>'9',
                        '29'=>'5',
                        '30'=>'5',
                        '32'=>'4',
                        '33'=>'3',
                        '35'=>'4',
                        '36'=>'6',
                        '38'=>'5',
                        '39'=>'7',
                        '41'=>'8',
                        '42'=>'2',
                        '44'=>'6',
                        '46'=>'3',
                        '47'=>'2',
                        '48'=>'8',
                        '49'=>'3',
                        '50'=>'5',
                        '51'=>'4',
                        '52'=>'2',
                        '54'=>'4',
                        '55'=>'1',
                        '56'=>'2',
                        '57'=>'2',
                        '58'=>'5',
                        '59'=>'2',
                        '61'=>'10',
                        '64'=>'3',
                        '65'=>'33',
                        '67'=>'5',
                        '68'=>'6',
                        '69'=>'8',
                        '70'=>'4',
                        '72'=>'5',
                        '73'=>'4',
                        '75'=>'8',
                        '76'=>'10',
                        '77'=>'2',
                        '78'=>'5',
                        '79'=>'3',
                        '81'=>'14',
                        '82'=>'3',
                        '84'=>'2',
                        '85'=>'2',
                        '86'=>'6',
                        '87'=>'2',
                        '88'=>'6',
                        '89'=>'4',
                        '90'=>'4',
                        '91'=>'4',
                        '93'=>'11',
                        '94'=>'3',
                    ];
                    $division_name='';
                    $zilla_name='';
                    $upazilla_name='';
                    $union_name='';
                    $uisc_name='';
                    $total_pdc=0;
                    $total_entrepreneur=0;
                    $total_report_upload=0;
                    $total_income=0;
                    $total_service_holder=0;

                    $total_report_upload_percentage=0;
                    $total_income_percentage=0;
                    $total_service_holder_percentage=0;

                    $grand_total_pdc=0;
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

                            $total_pdc=$zilla['total_pdc']?$zilla['total_pdc']:0;
                            $total_entrepreneur=$zilla['total_entrepreneur']?$zilla['total_entrepreneur']:0;
                            $total_report_upload=$zilla['total_report_upload']?$zilla['total_report_upload']:0;
                            $total_income=$zilla['total_income']?$zilla['total_income']:0;
                            $total_service_holder=$zilla['total_service_holder']?$zilla['total_service_holder']:0;

                            if(!empty($total_pdc) && !empty($total_report_upload))
                            {
                                $total_report_upload_percentage=($total_report_upload/$total_pdc);
                            }
                            else
                            {
                                $total_report_upload_percentage=0;
                            }

                            if(!empty($total_pdc) && !empty($total_income))
                            {
                                $total_income_percentage=($total_income/$total_pdc);
                            }
                            else
                            {
                                $total_income_percentage=0;
                            }

                            if(!empty($total_pdc) && !empty($total_service_holder))
                            {
                                $total_service_holder_percentage=($total_service_holder/$total_pdc);
                            }
                            else
                            {
                                $total_service_holder_percentage=0;
                            }

                            $grand_total_pdc+=$total_pdc;
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


                                <td><?php echo System_helper::Get_Eng_to_Bng($pdc[$zilla['zilla_id']]);?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_entrepreneur,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_report_upload,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_income,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_service_holder,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_report_upload_percentage,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_income_percentage,0));?></td>
                                <td><?php echo System_helper::Get_Eng_to_Bng(number_format($total_service_holder_percentage,0));?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <th colspan="2" style="text-align: right"><?php echo $this->lang->line('TOTAL');?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_pdc,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_entrepreneur,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_report_upload,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_income,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_service_holder,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_report_upload_percentage,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_income_percentage,0));?></th>
                    <th><?php echo System_helper::Get_Eng_to_Bng(number_format($grand_total_service_holder_percentage,0));?></th>
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