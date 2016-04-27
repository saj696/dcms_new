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
            <tr>
                <th colspan="21" class="text-center">
                    <?php echo System_helper::Get_Eng_to_Bng($from_date);?> <?php echo $this->lang->line('TO');?> <?php echo System_helper::Get_Eng_to_Bng($to_date);?>
                </th>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('DIVISION_NAME');?></th>
                <th><?php echo $this->lang->line('ZILLA_NAME');?></th>
                <th><?php echo $this->lang->line('MUNICIPAL_NAME');?></th>
                <th><?php echo $this->lang->line('MUNICIPAL_WARD_NAME');?></th>
                <th><?php echo $this->lang->line('UISC_NAME');?></th>
                <th><?php echo $this->lang->line('DATE');?></th>
                <th><?php echo $this->lang->line('MALE');?></th>
                <th><?php echo $this->lang->line('FEMALE');?></th>
                <th><?php echo $this->lang->line('TRIBE');?></th>
                <th><?php echo $this->lang->line('DISABILITY');?></th>
                <th><?php echo $this->lang->line('TOTAL_SERVICE_HOLDER');?></th>
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
                $grand_total_invoice_amount=0;
                $grand_total_invoice_men=0;
                $grand_total_invoice_women=0;
                $grand_total_invoice_tribe=0;
                $grand_total_invoice_disability=0;
                foreach($report as $division)
                {
                    foreach($division['zilla'] as $zilla)
                    {
                        $upazilla_total_invoice_amount=0;
                        $upazilla_total_invoice_men=0;
                        $upazilla_total_invoice_women=0;
                        $upazilla_total_invoice_tribe=0;
                        $upazilla_total_invoice_disability=0;
                        foreach($zilla['municipal'] as $municipal)
                        {
                            foreach($municipal['municipal_ward'] as $municipal_ward)
                            {
                                foreach($municipal_ward['uisc'] as $uisc)
                                {
                                    foreach($uisc['invoice'] as $invoice)
                                    {
                                        $invoice_date = strtotime($invoice['invoice_date']);
//                                        $total_income = $invoice['total_income'];
                                        $total_men = $invoice['total_men'];
                                        $total_women = $invoice['total_women'];
                                        $total_tribe = $invoice['total_tribe'];
                                        $total_disability = $invoice['total_disability'];

//                                        $upazilla_total_invoice_amount += $total_income;
                                        $upazilla_total_invoice_men += $total_men;
                                        $upazilla_total_invoice_women += $total_women;
                                        $upazilla_total_invoice_tribe += $total_tribe;
                                        $upazilla_total_invoice_disability += $total_disability;

//                                        $grand_total_invoice_amount += $total_income;
                                        $grand_total_invoice_men += $total_men;
                                        $grand_total_invoice_women += $total_women;
                                        $grand_total_invoice_tribe += $total_tribe;
                                        $grand_total_invoice_disability += $total_disability;

                                        ?>
                                        <tr>
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
                                            <td><?php echo System_helper::Get_Eng_to_Bng(date('d-m-Y', $invoice_date));?></td>
                                            <td style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($total_men);?></td>
                                            <td style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($total_women);?></td>
                                            <td style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($total_tribe);?></td>
                                            <td style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($total_disability);?></td>
                                            <td style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($total_men+$total_women+$total_tribe+$total_disability);?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <!--<tr>
                                <th colspan="6" style="text-align: right"><?php /*echo $this->lang->line('UPAZILLA');*/?> <?php /*echo $this->lang->line('TOTAL');*/?></th>
                                <th><?php /*echo System_helper::Get_Eng_to_Bng($upazilla_total_invoice_men);*/?></th>
                                <th><?php /*echo System_helper::Get_Eng_to_Bng($upazilla_total_invoice_women);*/?></th>
                                <th><?php /*echo System_helper::Get_Eng_to_Bng($upazilla_total_invoice_tribe);*/?></th>
                                <th><?php /*echo System_helper::Get_Eng_to_Bng($upazilla_total_invoice_disability);*/?></th>
                                <th><?php /*echo System_helper::Get_Eng_to_Bng($upazilla_total_invoice_amount);*/?></th>
                            </tr>-->
                        <?php
                        }
                    }
                }
                ?>
                <tr style="background: #EEEEEE">
                    <th colspan="6" style="text-align: right"><?php echo $this->lang->line('TOTAL');?></th>
                    <th style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($grand_total_invoice_men);?></th>
                    <th style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($grand_total_invoice_women);?></th>
                    <th style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($grand_total_invoice_tribe);?></th>
                    <th style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($grand_total_invoice_disability);?></th>
                    <th style="text-align: right;"><?php echo System_helper::Get_Eng_to_Bng($grand_total_invoice_men+$grand_total_invoice_women+$grand_total_invoice_tribe+$grand_total_invoice_disability);?></th>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>


<!--            <table class="table table-responsive table-bordered">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th colspan="21" class="text-center">-->
<!--                        --><?php //echo System_helper::Get_Eng_to_Bng($from_date);?><!-- --><?php //echo $this->lang->line('TO');?><!-- --><?php //echo System_helper::Get_Eng_to_Bng($to_date);?>
<!--                    </th>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <th>--><?php //echo $this->lang->line('DIVISION_NAME');?><!--</th>-->
<!--                    <th>--><?php //echo $this->lang->line('ZILLA_NAME');?><!--</th>-->
<!--                    <th>--><?php //echo $this->lang->line('UPAZILLA_NAME');?><!--</th>-->
<!--                    <th>--><?php //echo $this->lang->line('UNION_NAME');?><!--</th>-->
<!--                    <th>--><?php //echo $this->lang->line('UISC_NAME');?><!--</th>-->
<!--                    <th colspan="7" style="text-align: center">--><?php //echo $this->lang->line('SERVICE_HOLDER');?><!--</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                --><?php
//                if(empty($report))
//                {
//                    ?>
<!--                    <tr>-->
<!--                        <td colspan="21" style="color: red; text-align: center;">--><?php //echo $this->lang->line('DATA_NOT_FOUND');?><!--</td>-->
<!--                    </tr>-->
<!--                --><?php
//                }
//                else
//                {
//                    $division_name='';
//                    $zilla_name='';
//                    $upazilla_name='';
//                    $union_name='';
//                    $uisc_name='';
//                    $grand_total_invoice_amount=0;
//                    $grand_total_invoice_men=0;
//                    $grand_total_invoice_women=0;
//                    $grand_total_invoice_tribe=0;
//                    $grand_total_invoice_disability=0;
//                    foreach($report as $division)
//                    {
//                        foreach($division['zilla'] as $zilla)
//                        {
//                            $total_invoice_amount=0;
//                            $total_invoice_men=0;
//                            $total_invoice_women=0;
//                            $total_invoice_tribe=0;
//                            $total_invoice_disability=0;
//                            foreach($zilla['upazilla'] as $upazilla)
//                            {
//                                ?>
<!--                                <tr style="background: #cccccc">-->
<!--                                    <td>-->
<!--                                        --><?php
//                                        if ($division_name == '')
//                                        {
//                                            echo $division['division_name'];
//                                            $division_name = $division['division_name'];
//                                            //$currentDate = $preDate;
//                                        }
//                                        else if ($division_name == $division['division_name'])
//                                        {
//                                            //exit;
//                                            echo "&nbsp;";
//                                        }
//                                        else
//                                        {
//                                            echo $division['division_name'];
//                                            $division_name = $division['division_name'];
//                                        }
//                                        ?>
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        --><?php
//                                        if ($zilla_name == '')
//                                        {
//                                            echo $zilla['zilla_name'];
//                                            $zilla_name = $zilla['zilla_name'];
//                                            //$currentDate = $preDate;
//                                        }
//                                        else if ($zilla_name == $zilla['zilla_name'])
//                                        {
//                                            //exit;
//                                            echo "&nbsp;";
//                                        }
//                                        else
//                                        {
//                                            echo $zilla['zilla_name'];
//                                            $zilla_name = $zilla['zilla_name'];
//                                        }
//                                        ?>
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        --><?php
//                                        if ($upazilla_name == '')
//                                        {
//                                            echo $upazilla['upazilla_name'];
//                                            $upazilla_name = $upazilla['upazilla_name'];
//                                            //$currentDate = $preDate;
//                                        }
//                                        else if ($upazilla_name == $upazilla['upazilla_name'])
//                                        {
//                                            //exit;
//                                            echo "&nbsp;";
//                                        }
//                                        else
//                                        {
//                                            echo $upazilla['upazilla_name'];
//                                            $upazilla_name = $upazilla['upazilla_name'];
//                                        }
//                                        ?>
<!--                                    </td>-->
<!--                                    <td>--><?php //echo System_helper::Get_Eng_to_Bng($upazilla['number_of_union']);?><!--</td>-->
<!--                                    <td>--><?php //echo System_helper::Get_Eng_to_Bng($upazilla['number_of_uisc']);?><!--</td>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('DATE');}?><!--</th>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('MALE');}?><!--</th>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('FEMALE');}?><!--</th>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('TRIBE');}?><!--</th>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('DISABILITY');}?><!--</th>-->
<!--                                    <th>--><?php //if(isset($upazilla['invoice'])){echo $this->lang->line('INCOME');}?><!--</th>-->
<!--                                </tr>-->
<!--                                --><?php
//                                if(!isset($municipal['invoice']))
//                                {
//                                    ?>
<!--                                    <tr>-->
<!--                                        <td colspan="5">&nbsp;</td>-->
<!--                                        <th>--><?php //echo $this->lang->line('DATE');?><!--</th>-->
<!--                                        <th>--><?php //echo $this->lang->line('MALE');?><!--</th>-->
<!--                                        <th>--><?php //echo $this->lang->line('FEMALE');?><!--</th>-->
<!--                                        <th>--><?php //echo $this->lang->line('TRIBE');?><!--</th>-->
<!--                                        <th>--><?php //echo $this->lang->line('DISABILITY');?><!--</th>-->
<!--                                        <th>--><?php //echo $this->lang->line('INCOME');?><!--</th>-->
<!--                                    </tr>-->
<!--                                --><?php
//                                }
//                                ?>
<!--                                --><?php
//                                $invoice_date='';
//                                $invoice_amount=0;
//                                $invoice_men=0;
//                                $invoice_women=0;
//                                $invoice_tribe=0;
//                                $invoice_disability=0;
//                                if(isset($upazilla['invoice']))
//                                {
//                                    for($i=0; $i<sizeof($upazilla['invoice']); $i++)
//                                    {
//                                        if(isset($upazilla['invoice'][$i]['invoice_date']))
//                                        {
//                                            $invoice_date = strtotime($upazilla['invoice'][$i]['invoice_date']);
//                                            $invoice_amount = $upazilla['invoice'][$i]['invoice_amount'];
//                                            $invoice_men = $upazilla['invoice'][$i]['invoice_men'];
//                                            $invoice_women = $upazilla['invoice'][$i]['invoice_women'];
//                                            $invoice_tribe = $upazilla['invoice'][$i]['invoice_tribe'];
//                                            $invoice_disability = $upazilla['invoice'][$i]['invoice_disability'];
//
//                                            $total_invoice_amount = $upazilla['invoice'][$i]['invoice_amount'];
//                                            $total_invoice_men = $upazilla['invoice'][$i]['invoice_men'];
//                                            $total_invoice_women = $upazilla['invoice'][$i]['invoice_women'];
//                                            $total_invoice_tribe = $upazilla['invoice'][$i]['invoice_tribe'];
//                                            $total_invoice_disability = $upazilla['invoice'][$i]['invoice_disability'];
//
//                                            $grand_total_invoice_amount = $upazilla['invoice'][$i]['invoice_amount'];
//                                            $grand_total_invoice_men = $upazilla['invoice'][$i]['invoice_men'];
//                                            $grand_total_invoice_women = $upazilla['invoice'][$i]['invoice_women'];
//                                            $grand_total_invoice_tribe = $upazilla['invoice'][$i]['invoice_tribe'];
//                                            $grand_total_invoice_disability = $upazilla['invoice'][$i]['invoice_disability'];
//                                        }
//                                        else
//                                        {
//                                            $invoice_date='';
//                                            $invoice_amount=0;
//                                            $invoice_men=0;
//                                            $invoice_women=0;
//                                            $invoice_tribe=0;
//                                            $invoice_disability=0;
//
//                                            $total_invoice_amount=0;
//                                            $total_invoice_men=0;
//                                            $total_invoice_women=0;
//                                            $total_invoice_tribe=0;
//                                            $total_invoice_disability=0;
//
//                                            $grand_total_invoice_amount=0;
//                                            $grand_total_invoice_men=0;
//                                            $grand_total_invoice_women=0;
//                                            $grand_total_invoice_tribe=0;
//                                            $grand_total_invoice_disability=0;
//                                        }
//                                        ?>
<!--                                        <tr>-->
<!--                                            <td colspan="5">&nbsp;</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng(date('d-m-Y', $invoice_date));?><!--</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng($invoice_men);?><!--</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng($invoice_women);?><!--</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng($invoice_tribe);?><!--</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng($invoice_disability);?><!--</td>-->
<!--                                            <td>--><?php //echo System_helper::Get_Eng_to_Bng($invoice_amount);?><!--</td>-->
<!--                                        </tr>-->
<!--                                    --><?php
//                                    }
//                                }
//                                ?>
<!--                                <tr>-->
<!--                                    <th colspan="6" style="text-align: right">--><?php //echo $this->lang->line('TOTAL');?><!--</th>-->
<!--                                    <th>--><?php //echo System_helper::Get_Eng_to_Bng($total_invoice_men);?><!--</th>-->
<!--                                    <th>--><?php //echo System_helper::Get_Eng_to_Bng($total_invoice_women);?><!--</th>-->
<!--                                    <th>--><?php //echo System_helper::Get_Eng_to_Bng($total_invoice_tribe);?><!--</th>-->
<!--                                    <th>--><?php //echo System_helper::Get_Eng_to_Bng($total_invoice_disability);?><!--</th>-->
<!--                                    <th>--><?php //echo System_helper::Get_Eng_to_Bng($total_invoice_amount);?><!--</th>-->
<!--                                </tr>-->
<!--                            --><?php
//                            }
//                        }
//                    }
//                    ?>
<!--                    <tr>-->
<!--                        <th colspan="6" style="text-align: right">--><?php //echo $this->lang->line('TOTAL');?><!--</th>-->
<!--                        <th>--><?php //echo System_helper::Get_Eng_to_Bng($grand_total_invoice_men);?><!--</th>-->
<!--                        <th>--><?php //echo System_helper::Get_Eng_to_Bng($grand_total_invoice_women);?><!--</th>-->
<!--                        <th>--><?php //echo System_helper::Get_Eng_to_Bng($grand_total_invoice_tribe);?><!--</th>-->
<!--                        <th>--><?php //echo System_helper::Get_Eng_to_Bng($grand_total_invoice_disability);?><!--</th>-->
<!--                        <th>--><?php //echo System_helper::Get_Eng_to_Bng($grand_total_invoice_amount);?><!--</th>-->
<!--                    </tr>-->
<!--                --><?php
//                }
//                ?>
<!--                </tbody>-->
<!--            </table>-->
        </div>
    </div>
</div>
</body>
</html>